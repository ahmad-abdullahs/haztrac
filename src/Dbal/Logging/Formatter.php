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

namespace Sugarcrm\Sugarcrm\Dbal\Logging;

use Monolog\Formatter\FormatterInterface;
use Monolog\Logger;

/**
 * Formats parametrized query originated by the DBAL
 */
final class Formatter implements FormatterInterface
{
    /**
     * @var int
     */
    private const MAX_PARAM_LENGTH = 100;

    /**
     * @var FormatterInterface
     */
    private $formatter;

    public function __construct(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @inheritDoc
     */
    public function format(array $record)
    {
        $message = $record['message'];
        $context = $record['context'];

        if (!empty($context['params'])) {
            $message .= PHP_EOL . 'Params: ' . $this->stringify($context['params']);
        }

        if (!empty($context['types'])) {
            $message .= PHP_EOL . 'Types: ' . $this->stringify($context['types']);
        }

        $record['message'] = $message;

        return $this->formatter->format($record);
    }

    /**
     * @inheritDoc
     */
    public function formatBatch(array $records)
    {
        $message = '';

        foreach ($records as $record) {
            $message .= $this->format($record);
        }

        return $message;
    }

    /**
     * @param array $message Array to log
     *
     * @return string
     */
    private function stringify(array $message)
    {
        return json_encode(
            array_map(
                function ($str) {
                    if (is_string($str) && (strlen($str) > self::MAX_PARAM_LENGTH)) {
                        return substr($str, 0, self::MAX_PARAM_LENGTH) . '...';
                    }

                    return $str;
                },
                $message
            )
        );
    }

    /**
     * Prepends itself to all handler of the given monolog logger
     *
     * @param Logger $logger
     */
    public static function wrapLogger(Logger $logger) : void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(
                new self(
                    $handler->getFormatter()
                )
            );
        }
    }
}
