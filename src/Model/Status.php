<?php

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Stringable;

final class Status implements JsonSerializable, Stringable
{
    private const FAILED = 'failed';
    private const BROKEN = 'broken';
    private const PASSED = 'passed';
    private const SKIPPED = 'skipped';

    #[Pure]
    private function __construct(private string $value)
    {
    }

    #[Pure]
    public static function failed(): self
    {
        return new self(self::FAILED);
    }

    #[Pure]
    public static function broken(): self
    {
        return new self(self::BROKEN);
    }

    #[Pure]
    public static function passed(): self
    {
        return new self(self::PASSED);
    }

    #[Pure]
    public static function skipped(): self
    {
        return new self(self::SKIPPED);
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->value;
    }

    #[Pure]
    public function is(self $another): bool
    {
        return $another->value == $this->value;
    }

    #[Pure]
    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
