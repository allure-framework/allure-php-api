<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Stringable;

final class Stage implements JsonSerializable, Stringable
{

    private const SCHEDULED = 'scheduled';
    private const RUNNING = 'running';
    private const FINISHED = 'finished';
    private const PENDING = 'pending';
    private const INTERRUPTED = 'interrupted';

    #[Pure]
    private function __construct(private string $value)
    {
    }

    #[Pure]
    public static function scheduled(): self
    {
        return new self(self::SCHEDULED);
    }

    #[Pure]
    public static function running(): self
    {
        return new self(self::RUNNING);
    }

    #[Pure]
    public static function finished(): self
    {
        return new self(self::FINISHED);
    }

    #[Pure]
    public static function pending(): self
    {
        return new self(self::PENDING);
    }

    #[Pure]
    public static function interrupted(): self
    {
        return new self(self::INTERRUPTED);
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
