<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;

trait ExecutableTrait
{
    use TimeAwareTrait;

    protected ?Status $status = null;

    protected ?StatusDetails $statusDetails = null;

    protected ?Stage $stage = null;

    protected array $steps = [];

    protected array $attachments = [];

    protected array $parameters = [];

    abstract public function getResultType(): ResultType;

    #[Pure]
    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    #[Pure]
    public function getStatusDetails(): ?StatusDetails
    {
        return $this->statusDetails;
    }

    public function setStatusDetails(?StatusDetails $statusDetails): static
    {
        $this->statusDetails = $statusDetails;

        return $this;
    }

    #[Pure]
    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): static
    {
        $this->stage = $stage;

        return $this;
    }

    /**
     * @return list<StepResult>
     */
    #[Pure]
    public function getSteps(): array
    {
        return $this->steps;
    }

    public function addSteps(StepResult ...$steps): static
    {
        return $this->setSteps(...$this->steps, ...$steps);
    }

    public function setSteps(StepResult ...$steps): static
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * @return list<Attachment>
     */
    #[Pure]
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function addAttachments(Attachment ...$attachments): static
    {
        return $this->setAttachments(...$this->attachments, ...$attachments);
    }

    public function setAttachments(Attachment ...$attachments): static
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @return list<Parameter>
     */
    #[Pure]
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function addParameters(Parameter ...$parameters): static
    {
        return $this->setParameters(...$this->parameters, ...$parameters);
    }

    public function setParameters(Parameter ...$parameters): static
    {
        $this->parameters = $parameters;

        return $this;
    }
}
