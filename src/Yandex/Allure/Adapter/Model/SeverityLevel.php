<?php

namespace Yandex\Allure\Adapter\Model;

/**
 * Severity level
 * @package Yandex\Allure\Adapter\Model
 */
final class SeverityLevel
{
    const BLOCKER = 'blocker';
    const CRITICAL = 'critical';
    const NORMAL = 'normal';
    const MINOR = 'minor';
    const TRIVIAL = 'trivial';

    /**
     * @return array
     */
    public function getSupportedSeverityLevels()
    {
        return [
            self::BLOCKER,
            self::CRITICAL,
            self::NORMAL,
            self::MINOR,
            self::TRIVIAL,
        ];
    }
}
