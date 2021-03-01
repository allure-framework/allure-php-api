<?php


namespace Qameta\Allure\Model;

use JsonSerializable;

/**
 * Class FixtureResult
 * @package Qameta\Allure\Model
 */
class FixtureResult implements StepsAware, AttachmentsAware, ParametersAware, JsonSerializable
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return FixtureResult
     */
    public function setName(string $name): FixtureResult
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
     * @return FixtureResult
     */
    public function setStatus(string $status): FixtureResult
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
     * @return FixtureResult
     */
    public function setStatusDetails(StatusDetails $statusDetails): FixtureResult
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
     * @return FixtureResult
     */
    public function setDescription(string $description): FixtureResult
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
     * @return FixtureResult
     */
    public function setDescriptionHtml(string $descriptionHtml): FixtureResult
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
     * @return FixtureResult
     */
    public function setSteps(array $steps): FixtureResult
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
     * @return FixtureResult
     */
    public function setAttachments(array $attachments): FixtureResult
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
     * @return FixtureResult
     */
    public function setParameters(array $parameters): FixtureResult
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
     * @return FixtureResult
     */
    public function setStart(int $start): FixtureResult
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
     * @return FixtureResult
     */
    public function setStop(int $stop): FixtureResult
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