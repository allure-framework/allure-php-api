<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JsonSerializable;
use Stringable;

final class Stage implements JsonSerializable, Stringable
{

    private const SCHEDULED = 'scheduled';
    private const RUNNING = 'running';
    private const FINISHED = 'finished';
    private const PENDING = 'pending';
    private const INTERRUPTED = 'interrupted';

    private function __construct(private string $value)
    {
    }

    public static function scheduled(): self
    {
        return new self(self::SCHEDULED);
    }

    public static function running(): self
    {
        return new self(self::RUNNING);
    }

    public static function finished(): self
    {
        return new self(self::FINISHED);
    }

    public static function pending(): self
    {
        return new self(self::PENDING);
    }

    public static function interrupted(): self
    {
        return new self(self::INTERRUPTED);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function is(self $another): bool
    {
        return $another->value == $this->value;
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
