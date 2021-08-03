<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JsonSerializable;
use Qameta\Allure\Internal\JsonSerializableTrait;

final class StatusDetails implements JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        private ?bool $known = null,
        private ?bool $muted = null,
        private ?bool $flaky = null,
        private ?string $message = null,
        private ?string $trace = null,
    ) {
    }

    public function isKnown(): ?bool
    {
        return $this->known;
    }

    public function makeKnown(?bool $known): self
    {
        $this->known = $known;

        return $this;
    }

    public function isMuted(): ?bool
    {
        return $this->muted;
    }

    public function makeMuted(?bool $muted): self
    {
        $this->muted = $muted;

        return $this;
    }

    public function getFlaky(): ?bool
    {
        return $this->flaky;
    }

    public function makeFlaky(?bool $flaky): self
    {
        $this->flaky = $flaky;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

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
