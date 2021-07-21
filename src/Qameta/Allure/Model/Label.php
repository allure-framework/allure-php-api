<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Qameta\Allure\Internal\JsonSerializableTrait;

final class Label implements JsonSerializable
{
    use JsonSerializableTrait;

    public const ALLURE_ID = "AS_ID";
    public const SUITE = "suite";
    public const PARENT_SUITE = "parentSuite";
    public const SUB_SUITE = "subSuite";
    public const EPIC = "epic";
    public const FEATURE = "feature";
    public const STORY = "story";
    public const SEVERITY = "severity";
    public const TAG = "tag";
    public const OWNER = "owner";
    public const LEAD = "lead";
    public const HOST = "host";
    public const THREAD = "thread";
    public const TEST_ID = "testId";
    public const TEST_METHOD = "testMethod";
    public const TEST_CLASS = "testClass";
    public const PACKAGE = "package";
    public const FRAMEWORK = "framework";
    public const LANGUAGE = "language";

    #[Pure]
    public function __construct(
        private ?string $name = null,
        private ?string $value = null,
    ) {
    }

    #[Pure]
    public static function id(?string $value): self
    {
        return new self(
            name: self::ALLURE_ID,
            value: $value,
        );
    }

    #[Pure]
    public static function suite(?string $value): self
    {
        return new self(
            name: self::SUITE,
            value: $value,
        );
    }

    #[Pure]
    public static function parentSuite(?string $value): self
    {
        return new self(
            name: self::PARENT_SUITE,
            value: $value,
        );
    }

    #[Pure]
    public static function subSuite(?string $value): self
    {
        return new self(
            name: self::SUB_SUITE,
            value: $value,
        );
    }

    #[Pure]
    public static function epic(?string $value): self
    {
        return new self(
            name: self::EPIC,
            value: $value,
        );
    }

    #[Pure]
    public static function feature(?string $value): self
    {
        return new self(
            name: self::FEATURE,
            value: $value,
        );
    }

    #[Pure]
    public static function story(?string $value): self
    {
        return new self(
            name: self::STORY,
            value: $value,
        );
    }

    #[Pure]
    public static function severity(Severity $value): self
    {
        return new self(
            name: self::SEVERITY,
            value: (string) $value,
        );
    }

    #[Pure]
    public static function tag(?string $value): self
    {
        return new self(
            name: self::TAG,
            value: $value,
        );
    }

    #[Pure]
    public static function owner(?string $value): self
    {
        return new self(
            name: self::OWNER,
            value: $value,
        );
    }

    #[Pure]
    public static function lead(?string $value): self
    {
        return new self(
            name: self::LEAD,
            value: $value,
        );
    }

    #[Pure]
    public static function host(?string $value): self
    {
        return new self(
            name: self::HOST,
            value: $value,
        );
    }

    #[Pure]
    public static function thread(?string $value): self
    {
        return new self(
            name: self::THREAD,
            value: $value,
        );
    }

    #[Pure]
    public static function testMethod(?string $value): self
    {
        return new self(
            name: self::TEST_METHOD,
            value: $value,
        );
    }

    #[Pure]
    public static function testClass(?string $value): self
    {
        return new self(
            name: self::TEST_CLASS,
            value: $value,
        );
    }

    #[Pure]
    public static function package(?string $value): self
    {
        return new self(
            name: self::PACKAGE,
            value: $value,
        );
    }

    #[Pure]
    public static function framework(?string $value): self
    {
        return new self(
            name: self::FRAMEWORK,
            value: $value,
        );
    }

    #[Pure]
    public static function language(?string $value): self
    {
        return new self(
            name: self::LANGUAGE,
            value: $value,
        );
    }

    #[Pure]
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    #[Pure]
    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
