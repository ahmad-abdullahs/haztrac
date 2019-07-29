<?php

class FieldMaskHandler
{
    /**
     * Apply the mask (masks are selected in the Admin SynoFieldMask panel)
     *
     * @param SugarBean $target
     * @param string $targetField
     * @param string $mask
     * @return bool
     */
    public static function applyMask(SugarBean $target, $targetField, $mask)
    {
        $fieldValue = $target->{$targetField};

        switch ($mask) {
            case 'upper':
                $target->{$targetField} = self::strToUpper($fieldValue);
                return true;
            case 'upper_first':
                $target->{$targetField} = self::strToUpperFirst($fieldValue);
                return true;
            case 'lower':
                $target->{$targetField} = self::strToLower($fieldValue);
                return true;
            default:
                // Do not verify custom masks. The data loss would be too important in SugarCRM imports.
        }

        return false;
    }

    /**
     * Upper case text
     * @param string Data to capitalize
     * @return string Capitalized words
     */
    public static function strToUpper($text)
    {
        return function_exists('mb_convert_case') ? mb_convert_case($text, MB_CASE_UPPER, 'UTF-8') : strtoupper($text);
    }

    /**
     * Upper case text
     * @param string Data to capitalize
     * @return string Capitalized words
     */
    public static function strToLower($text)
    {
        return function_exists('mb_convert_case') ? mb_convert_case($text, MB_CASE_LOWER, 'UTF-8') : strtolower($text);
    }

    /**
     * Capitalize all words
     *
     * @param string $words = data to capitalize
     * @param array $charList = word delimiters
     * @return string Capitalized words
     */
    public static function strToUpperFirst($words, $charList = array())
    {
        // Use ucwords if no delimiters are given
        if (empty($charList)) {
            return function_exists('mb_convert_case') ? mb_convert_case($words, MB_CASE_TITLE, 'UTF-8') : ucwords($words);
        }

        // Go through all characters
        $capitalizeNext = true;
        $words = self::strToLower($words);

        for ($i = 0, $max = strlen($words); $i < $max; $i++) {

            if (in_array($words[$i], $charList) !== false) {
                $capitalizeNext = true;
            } elseif ($capitalizeNext) {
                $capitalizeNext = false;
                $words[$i] = self::strToUpper($words[$i]);
            }
        }

        return $words;
    }
}