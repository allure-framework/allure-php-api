<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use Stringable;

final class ResultType implements Stringable
{

    private const CONTAINER = 'container';
    private const FIXTURE = 'fixture';
    private const TEST = 'test';
    private const STEP = 'step';
    private const ATTACHMENT = 'attachment';

    /**
     * @var array<string, ResultType>
     */
    private static array $instances = [];

    private function __construct(private string $value)
    {
    }

    public static function container(): self
    {
        return self::$instances[self::CONTAINER] ??= new self(self::CONTAINER);
    }

    public static function fixture(): self
    {
        return self::$instances[self::FIXTURE] ??= new self(self::FIXTURE);
    }

    public static function test(): self
    {
        return self::$instances[self::TEST] ??= new self(self::TEST);
    }

    public static function step(): self
    {
        return self::$instances[self::STEP] ??= new self(self::STEP);
    }

    public static function attachment(): self
    {
        return self::$instances[self::ATTACHMENT] ??= new self(self::ATTACHMENT);
    }

    public function is(ResultType $type): bool
    {
        return $this->value == $type->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
