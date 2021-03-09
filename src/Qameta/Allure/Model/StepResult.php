<?php


namespace Qameta\Allure\Model;

use JsonSerializable;

/**
 * Class StepResult
 * @package Qameta\Allure\Model
 */
class StepResult implements StepsAware, AttachmentsAware, ParametersAware, JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $status;

    /**
     * @var StatusDetails
     */
    private $statusDetails;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $descriptionHtml;

    /**
     * @var array<StepResult>
     */
    private $steps;

    /**
     * @var array<Attachment>
     */
    private $attachments;

    /**
     * @var array<Parameter>
     */
    private $parameters;

    /**
     * @var integer
     */
    private $start;

    /**
     * @var integer
     */
    private $stop;

    /**
     * StepResult constructor.
     * @param string $name
     * @param string $status
     */
    public function __construct($name = null, $status = null)
    {
        $this->name = $name;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return StepResult
     */
    public function setName(string $name): StepResult
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return StepResult
     */
    public function setStatus(string $status): StepResult
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return StatusDetails
     */
    public function getStatusDetails(): StatusDetails
    {
        return $this->statusDetails;
    }

    /**
     * @param StatusDetails $statusDetails
     * @return StepResult
     */
    public function setStatusDetails(StatusDetails $statusDetails): StepResult
    {
        $this->statusDetails = $statusDetails;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return StepResult
     */
    public function setDescription(string $description): StepResult
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescriptionHtml(): string
    {
        return $this->descriptionHtml;
    }

    /**
     * @param string $descriptionHtml
     * @return StepResult
     */
    public function setDescriptionHtml(string $descriptionHtml): StepResult
    {
        $this->descriptionHtml = $descriptionHtml;
        return $this;
    }

    /**
     * @return array
     */
    public function getSteps(): array
    {
        return $this->steps;
    }

    /**
     * @param array $steps
     * @return StepResult
     */
    public function setSteps(array $steps): StepResult
    {
        $this->steps = $steps;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @param array $attachments
     * @return StepResult
     */
    public function setAttachments(array $attachments): StepResult
    {
        $this->attachments = $attachments;
        return $this;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     * @return StepResult
     */
    public function setParameters(array $parameters): StepResult
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @param int $start
     * @return StepResult
     */
    public function setStart(int $start): StepResult
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return int
     */
    public function getStop(): int
    {
        return $this->stop;
    }

    /**
     * @param int $stop
     * @return StepResult
     */
    public function setStop(int $stop): StepResult
    {
        $this->stop = $stop;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}