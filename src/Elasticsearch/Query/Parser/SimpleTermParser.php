<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

namespace Sugarcrm\Sugarcrm\Elasticsearch\Query\Parser;

/**
 * to parse a full text search string to an araay of terms
 * Class SimpleTermParser
 * @package Sugarcrm\Sugarcrm\Elasticsearch\Query\Parser
 */
class SimpleTermParser implements ParserInterface
{
    // tokenizer is using 1, 15 ngram, make sure the length of term is less than 15
    const MAX_TERM_SIZE = 15;

    protected $defaultOperator;
    protected $useShortcutOperator = false;

    /**
     * default Operator for space
     * @return string
     */
    public function getDefaultOperator()
    {
        return !empty($this->defaultOperator)? $this->defaultOperator : TermParserHelper::OPERATOR_AND;
    }

    /**
     * to set default operator
     * @param string $defaultOperator
     */
    public function setDefaultOperator($defaultOperator)
    {
        $this->defaultOperator = TermParserHelper::getOperator($defaultOperator);
    }

    /**
     * to set use shortcut operator, such as '&' for AND, '|' for OR, '-' for NOT
     * @param bool $use
     */
    public function setUseShortcutOperator(bool $use)
    {
        $this->useShortcutOperator = $use;
    }

    /**
     * @inheritdoc
     * @param string $terms
     */
    public function parse($terms)
    {
        // replace '-' to 'NOT' operator,
        // replace /(\&|\|)/ to ' & ' | ' | '
        // add space before and after '(', ')'
        $terms = $this->preProcess($terms);

        // parse the parentheses
        $data = SearchStringProcessor::parse($terms);

        // parse and compress the terms
        $basicTerms = $this->compressTerms($data);

        return $basicTerms->toArray();
    }

    /**
     * pre process search terms
     * @param $terms
     * @return mixed
     */
    protected function preProcess($terms)
    {
        // to replace '-' to 'NOT' operator, keep leading space to make parser happy
        $terms = ' ' . $terms;
        $patterns = array(
            '/\(/',
            '/\)/',
            );
        $replacedBy = array(
            ' ( ',
            ' ) ',
        );
        $temp = preg_replace($patterns, $replacedBy, $terms);

        $processed = $temp;
        if ($this->useShortcutOperator) {
            $patterns = array(
                '/\s+(\-)/',
                '/\&/',
                '/\|/',
            );
            $replacedBy = array(
                ' ' . TermParserHelper::OPERATOR_NOT . ' ',
                ' ' . TermParserHelper::OPERATOR_AND . ' ',
                ' ' . TermParserHelper::OPERATOR_OR . ' ',
            );
            $processed = preg_replace($patterns, $replacedBy, $temp);
        }

        // remove non-alphanumeric chars, such '$%&' in "a $%& b" => "a b"
        $patterns = ['/\s+[^a-zA-Z\d\.\(\):]+\s+/'];
        $processed = trim(preg_replace($patterns, [' '], $processed));

        // need to split large term to small size (<= 15)
        $splitted = explode(' ', $processed);
        $searchString = '';
        foreach ($splitted as $item) {
            $item = trim($item);
            if (!empty($item)) {
                if (strlen($item) <= self::MAX_TERM_SIZE) {
                    $searchString .= $item . ' ';
                } else {
                    $splittedItems = str_split($item, self::MAX_TERM_SIZE);
                    $useAndOp = false;
                    foreach ($splittedItems as $sItem) {
                        if (!$useAndOp) {
                            // turn on 'AND' operator
                            $useAndOp = true;
                            $searchString .= '(';
                        } else {
                            $searchString .= ' ' . TermParserHelper::OPERATOR_AND . ' ';
                        }
                        $searchString .= $sItem;
                    }
                    if ($useAndOp) {
                        $searchString .= ') ';
                    }
                }
            }
        }
        
        return trim($searchString);
    }

    /**
     * to parse any array into a BasicTerms, it could be recursive
     * @param array $terms
     * @return BasicTerms
     */
    protected function compressTerms(array $terms)
    {
        $currentOperator = TermParserHelper::OPERATOR_OR;

        $prevTerm = '';

        $orTerms = new BasicTerms(TermParserHelper::OPERATOR_OR);

        // pop the last element if it is an operator
        while (!empty($terms) && TermParserHelper::isOperator(end($terms))) {
            array_pop($terms);
        }

        if (empty($terms)) {
            // keep one white space
            return new BasicTerms(TermParserHelper::OPERATOR_OR, array(' '));
        }

        $andTerms = array();
        $notTerms = array();

        for ($i = 0; $i < count($terms); $i++) {
            $term = $terms[$i];
            if (empty($term)) {
                continue;
            }

            if (TermParserHelper::isOperator($term)) {
                $currentOperator = $term;
                $prevTerm = $currentOperator;
                continue;
            }

            if (is_array($term)) {
                // recursive build
                $term = $this->compressTerms($term);
            }

            // handle real terms
            if (!empty($prevTerm) && !TermParserHelper::isOperator($prevTerm)) {
                // there is no operator, use default
                $currentOperator = $this->getDefaultOperator();
            }

            //check next operator
            if (isset($terms[$i+1])) {
                if (TermParserHelper::isOperator($terms[$i+1])) {
                    $nextOperator = $terms[$i+1];
                } else {
                    $nextOperator = $this->getDefaultOperator();
                }
                if ($currentOperator != $nextOperator) {
                    // logic operator changes
                    if (TermParserHelper::isOrOperator($currentOperator)) {
                        // starting none-OR operator
                        if (TermParserHelper::isAndOperator($nextOperator)) {
                            // a OR b AND c => a OR (b AND c), at posiion b,
                            $andTerms = array($term);
                        } else {
                            $notTerms = array();
                            if (empty($prevTerm)) {
                                // b NOT c, at the beginning, this is AND
                                $andTerms = array($term);
                            } else {
                                // a OR b NOT c => a OR (b NOT c)
                                // will staring
                                $andTerms[] =$term;
                            }
                        }
                    } else {
                        // starting 'OR', end of 'AND' OR 'NOT' operators
                        if (TermParserHelper::isOrOperator($nextOperator)) {
                            // a AND b OR c, => (a AND b) OR c
                            if (TermParserHelper::isAndOperator($currentOperator)) {
                                $andTerms[] = $term;
                            } else {
                                // a NOT b OR c, => (a NOT b) OR c
                                $notTerms[] = $term;
                            }
                            $orTerms->addTerm($this->createAndNotTerms($andTerms, $notTerms));
                            $andTerms = array();
                            $notTerms = array();
                        } else {
                            if (TermParserHelper::isNotOperator($currentOperator)) {
                                // a NOT b AND c, at position b
                                $notTerms[] = $term;
                            } else {
                                // a AND b NOT c, => (a AND b) NOT c
                                $andTerms[] = $term;
                            }
                        }
                    }
                } else {
                    // same operator
                    if (TermParserHelper::isOrOperator($currentOperator)) {
                        $orTerms->addTerm($term);
                    } elseif (TermParserHelper::isNotOperator($currentOperator)) {
                        // a NOT b NOT c, at position b
                        $notTerms[] = $term;
                    } else {
                        // a AND b AND c, => (a AND b) AND c
                        $andTerms[] = $term;
                    }
                }
            } else {
                // end of string
                if (TermParserHelper::isOrOperator($currentOperator)) {
                    $orTerms->addTerm($term);
                } else {
                    if (TermParserHelper::isNotOperator($currentOperator)) {
                        // a NOT b NOT c, at position b
                        $notTerms[] = $term;
                    } else {
                        // a AND b AND c, => (a AND b) AND c
                        $andTerms[] = $term;
                    }
                    $orTerms->addTerm($this->createAndNotTerms($andTerms, $notTerms));
                }
            }
            $prevTerm = $term;
        }
        return $orTerms;
    }

    /**
     * helper method, to create a BasicTerms via combine AND array with NOT array
     * @param array $andTerms
     * @param array $notTerms
     * @return bool|null|BasicTerms
     */
    protected function createAndNotTerms(array $andTerms, array $notTerms)
    {
        if (empty($andTerms) && empty($notTerms)) {
            return false;
        }

        $andTerm = null;
        $notTerm = null;

        if (!empty($andTerms)) {
            $andTerm = new BasicTerms(TermParserHelper::OPERATOR_AND, $andTerms);
        }

        if (!empty($notTerms)) {
            $notTerm = new BasicTerms(TermParserHelper::OPERATOR_NOT, $notTerms);
        }

        if (empty($andTerms)) {
            return $notTerm;
        } elseif (empty($notTerms)) {
            return $andTerm;
        } else {
            // combine AND and NOT basicTerms together
            return new BasicTerms(TermParserHelper::OPERATOR_AND, array($andTerm, $notTerm));
        }
    }
}
