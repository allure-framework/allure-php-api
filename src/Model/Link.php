<?php

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Qameta\Allure\Internal\JsonSerializableTrait;

final class Link implements JsonSerializable
{
    use JsonSerializableTrait;

    #[Pure]
    public function __construct(
        private ?string $name = null,
        private ?string $url = null,
        private ?LinkType $type = null,
    ) {
    }

    #[Pure]
    public static function issue(string $name, string $url): self
    {
        return new self(
            name: $name,
            url: $url,
            type: LinkType::issue(),
        );
    }

    #[Pure]
    public static function tms(string $name, string $url): self
    {
        return new self(
            name: $name,
            url: $url,
            type: LinkType::tms(),
        );
    }

    #[Pure]
    public static function custom(string $name, string $url): self
    {
        return new self(
            name: $name,
            url: $url,
            type: LinkType::custom(),
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
    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    #[Pure]
    public function getType(): ?LinkType
    {
        return new $this->type;
    }

    public function setType(?LinkType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
