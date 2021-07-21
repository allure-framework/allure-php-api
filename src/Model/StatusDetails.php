<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Qameta\Allure\Internal\JsonSerializableTrait;

final class StatusDetails implements JsonSerializable
{
    use JsonSerializableTrait;

    #[Pure]
    public function __construct(
        private ?bool $known = null,
        private ?bool $muted = null,
        private ?bool $flaky = null,
        private ?string $message = null,
        private ?string $trace = null,
    ) {
    }

    #[Pure]
    public function isKnown(): ?bool
    {
        return $this->known;
    }

    public function makeKnown(?bool $known): self
    {
        $this->known = $known;

        return $this;
    }

    #[Pure]
    public function isMuted(): ?bool
    {
        return $this->muted;
    }

    public function makeMuted(?bool $muted): self
    {
        $this->muted = $muted;

        return $this;
    }

    #[Pure]
    public function getFlaky(): ?bool
    {
        return $this->flaky;
    }

    public function makeFlaky(?bool $flaky): self
    {
        $this->flaky = $flaky;

        return $this;
    }

    #[Pure]
    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    #[Pure]
    public function getTrace(): ?string
    {
        return $this->trace;
    }

    public function setTrace(?string $trace): self
    {
        $this->trace = $trace;

        return $this;
    }
}
