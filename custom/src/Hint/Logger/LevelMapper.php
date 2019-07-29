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
namespace Sugarcrm\Sugarcrm\custom\Hint\Logger;

use Psr\Log\LogLevel;

final class LevelMapper
{
    // SugarLogger level to PSR LogLevel
    const SUGAR_TO_PSR_MAP = [
        'debug' => LogLevel::DEBUG,
        'info'  => LogLevel::INFO,
        'warn' => LogLevel::WARNING,
        'deprecated' => LogLevel::NOTICE,
        'error' => LogLevel::ERROR,
        'fatal' => LogLevel::ALERT,
        'security' => LogLevel::CRITICAL,
    ];

    // PSR LogLevel to SugarLogger level
    const PSR_TO_SUGAR_MAP = [
        LogLevel::EMERGENCY => 'fatal',
        LogLevel::ALERT => 'fatal',
        LogLevel::CRITICAL => 'fatal',
        LogLevel::ERROR => 'error',
        LogLevel::WARNING => 'warn',
        LogLevel::NOTICE => 'info',
        LogLevel::INFO => 'info',
        LogLevel::DEBUG => 'debug',
    ];

    /**
     * Converts sugar log level to PSR LogLevel type
     *
     * @param string $logLevel
     * @return string
     * @throws \InvalidArgumentException
     */
    public function toPsr(string $logLevel): string
    {
        if (!isset(self::SUGAR_TO_PSR_MAP[$logLevel])) {
            // check if given level is already a PSR type
            if (defined(sprintf('%s::%s', LogLevel::class, strtoupper($logLevel)))) {
                return $logLevel;
            }

            throw new \InvalidArgumentException(sprintf('Unknown sugar log level: "%s"', $logLevel));
        }

        return self::SUGAR_TO_PSR_MAP[$logLevel];
    }

    /**
     * Converts PSR LogLevel type to sugar log level
     *
     * @param string $logLevel
     * @return string
     * @throws \InvalidArgumentException
     */
    public function toSugar(string $logLevel): string
    {
        $logLevel = strtolower($logLevel);
        if (!isset(self::PSR_TO_SUGAR_MAP[$logLevel])) {
            // check if given level is already a sugar logger type
            if (in_array($logLevel, array_keys(self::SUGAR_TO_PSR_MAP), true)) {
                return $logLevel;
            }

            throw new \InvalidArgumentException(sprintf('Unknown PSR log level: "%s"', $logLevel));
        }

        return self::PSR_TO_SUGAR_MAP[$logLevel];
    }
}
