<?php


namespace Qameta\Allure\Model;

use JsonSerializable;

/**
 * Class TestResult
 * @package Qameta\Allure\Model
 */
class TestResult implements StepsAware, AttachmentsAware, ParametersAware, JsonSerializable
{

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $historyId;

    /**
     * @var string
     */
    private $testCaseId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $fullName;

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
     * @var array<Label>
     */
    private $labels;

    /**
     * @var array<Link>
     */
    private $links;

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
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return TestResult
     */
    public function setUuid(string $uuid): TestResult
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getHistoryId(): string
    {
        return $this->historyId;
    }

    /**
     * @param string $historyId
     * @return TestResult
     */
    public function setHistoryId(string $historyId): TestResult
    {
        $this->historyId = $historyId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTestCaseId(): string
    {
        return $this->testCaseId;
    }

    /**
     * @param string $testCaseId
     * @return TestResult
     */
    public function setTestCaseId(string $testCaseId): TestResult
    {
        $this->testCaseId = $testCaseId;
        return $this;
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
     * @return TestResult
     */
    public function setName(string $name): TestResult
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     * @return TestResult
     */
    public function setFullName(string $fullName): TestResult
    {
        $this->fullName = $fullName;
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
     * @return TestResult
     */
    public function setStatus(string $status): TestResult
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
     * @return TestResult
     */
    public function setStatusDetails(StatusDetails $statusDetails): TestResult
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
     * @return TestResult
     */
    public function setDescription(string $description): TestResult
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
     * @return TestResult
     */
    public function setDescriptionHtml(string $descriptionHtml): TestResult
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
     * @return TestResult
     */
    public function setSteps(array $steps): TestResult
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
     * @return TestResult
     */
    public function setAttachments(array $attachments): TestResult
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
     * @return TestResult
     */
    public function setParameters(array $parameters): TestResult
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @param array $labels
     * @return TestResult
     */
    public function setLabels(array $labels): TestResult
    {
        $this->labels = $labels;
        return $this;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param array $links
     * @return TestResult
     */
    public function setLinks(array $links): TestResult
    {
        $this->links = $links;
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
     * @return TestResult
     */
    public function setStart(int $start): TestResult
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
     * @return TestResult
     */
    public function setStop(int $stop): TestResult
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