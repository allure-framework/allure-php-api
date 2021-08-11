<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JsonSerializable;
use Stringable;

final class ParameterMode implements JsonSerializable, Stringable
{

    private const MASKED = 'masked';
    private const HIDDEN = 'hidden';

    private function __construct(
        private string $value,
    ) {
    }

    public static function masked(): self
    {
        return new self(self::MASKED);
    }

    public static function hidden(): self
    {
        return new self(self::HIDDEN);
    }

    public function equals(self $mode): bool
    {
        return $mode->value === $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
