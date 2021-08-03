<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use Stringable;

final class Severity implements Stringable
{

    public const BLOCKER = "blocker";
    public const CRITICAL = "critical";
    public const NORMAL = "normal";
    public const MINOR = "minor";
    public const TRIVIAL = "trivial";

    public function __construct(private string $value)
    {
    }

    public static function blocker(): self
    {
        return new self(self::BLOCKER);
    }

    public static function critical(): self
    {
        return new self(self::CRITICAL);
    }

    public static function normal(): self
    {
        return new self(self::NORMAL);
    }

    public static function minor(): self
    {
        return new self(self::MINOR);
    }

    public static function trivial(): self
    {
        return new self(self::TRIVIAL);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
