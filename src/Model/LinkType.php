<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Stringable;

final class LinkType implements JsonSerializable, Stringable
{

    public const ISSUE = "issue";
    public const TMS = "tms";
    public const CUSTOM = "custom";

    #[Pure]
    public function __construct(private string $value)
    {
    }

    #[Pure]
    public static function issue(): self
    {
        return new self(self::ISSUE);
    }

    #[Pure]
    public static function tms(): self
    {
        return new self(self::TMS);
    }

    #[Pure]
    public static function custom(): self
    {
        return new self(self::CUSTOM);
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->value;
    }

    #[Pure]
    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
