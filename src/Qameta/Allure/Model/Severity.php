<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use Stringable;

final class Severity implements Stringable
{

    public const BLOCKER = "blocker";
    public const CRITICAL = "critical";
    public const NORMAL = "normal";
    public const MINOR = "minor";
    public const TRIVIAL = "trivial";

    #[Pure]
    public function __construct(private string $value)
    {
    }

    #[Pure]
    public static function blocker(): self
    {
        return new self(self::BLOCKER);
    }

    #[Pure]
    public static function critical(): self
    {
        return new self(self::CRITICAL);
    }

    #[Pure]
    public static function normal(): self
    {
        return new self(self::NORMAL);
    }

    #[Pure]
    public static function minor(): self
    {
        return new self(self::MINOR);
    }

    #[Pure]
    public static function trivial(): self
    {
        return new self(self::TRIVIAL);
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->value;
    }
}
