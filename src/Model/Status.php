<?php

namespace Qameta\Allure\Model;

use JsonSerializable;
use Stringable;

final class Status implements JsonSerializable, Stringable
{
    private const FAILED = 'failed';
    private const BROKEN = 'broken';
    private const PASSED = 'passed';
    private const SKIPPED = 'skipped';

    private function __construct(private string $value)
    {
    }

    public static function failed(): self
    {
        return new self(self::FAILED);
    }

    public static function broken(): self
    {
        return new self(self::BROKEN);
    }

    public static function passed(): self
    {
        return new self(self::PASSED);
    }

    public static function skipped(): self
    {
        return new self(self::SKIPPED);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(self $status): bool
    {
        return $status->value == $this->value;
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
