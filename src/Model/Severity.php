<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JsonSerializable;

final class Severity extends AbstractEnum implements JsonSerializable
{

    public const BLOCKER = "blocker";
    public const CRITICAL = "critical";
    public const NORMAL = "normal";
    public const MINOR = "minor";
    public const TRIVIAL = "trivial";

    public static function blocker(): self
    {
        return self::create(self::BLOCKER);
    }

    public static function critical(): self
    {
        return self::create(self::CRITICAL);
    }

    public static function normal(): self
    {
        return self::create(self::NORMAL);
    }

    public static function minor(): self
    {
        return self::create(self::MINOR);
    }

    public static function trivial(): self
    {
        return self::create(self::TRIVIAL);
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
