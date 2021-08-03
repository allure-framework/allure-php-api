<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JsonSerializable;
use Stringable;

final class LinkType implements JsonSerializable, Stringable
{

    public const ISSUE = "issue";
    public const TMS = "tms";
    public const CUSTOM = "custom";

    public function __construct(private string $value)
    {
    }

    public static function issue(): self
    {
        return new self(self::ISSUE);
    }

    public static function tms(): self
    {
        return new self(self::TMS);
    }

    public static function custom(): self
    {
        return new self(self::CUSTOM);
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
