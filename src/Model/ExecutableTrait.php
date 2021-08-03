<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use function array_values;

trait ExecutableTrait
{
    use TimeAwareTrait;

    protected ?Status $status = null;

    protected ?StatusDetails $statusDetails = null;

    protected ?Stage $stage = null;

    /**
     * @var list<StepResult>
     */
    protected array $steps = [];

    /**
     * @var list<Attachment>
     */
    protected array $attachments = [];

    /**
     * @var list<Parameter>
     */
    protected array $parameters = [];

    abstract public function getResultType(): ResultType;

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getStatusDetails(): ?StatusDetails
    {
        return $this->statusDetails;
    }

    public function setStatusDetails(?StatusDetails $statusDetails): static
    {
        $this->statusDetails = $statusDetails;

        return $this;
    }

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
    public function getSteps(): array
    {
        return $this->steps;
    }

    public function addSteps(StepResult ...$steps): static
    {
        return $this->setSteps(...$this->steps, ...array_values($steps));
    }

    public function setSteps(StepResult ...$steps): static
    {
        $this->steps = array_values($steps);

        return $this;
    }

    /**
     * @return list<Attachment>
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function addAttachments(Attachment ...$attachments): static
    {
        return $this->setAttachments(...$this->attachments, ...array_values($attachments));
    }

    public function setAttachments(Attachment ...$attachments): static
    {
        $this->attachments = array_values($attachments);

        return $this;
    }

    /**
     * @return list<Parameter>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function addParameters(Parameter ...$parameters): static
    {
        return $this->setParameters(...$this->parameters, ...array_values($parameters));
    }

    public function setParameters(Parameter ...$parameters): static
    {
        $this->parameters = array_values($parameters);

        return $this;
    }
}
