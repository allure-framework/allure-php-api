<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Qameta\Allure\Internal\JsonSerializableTrait;

final class TestResult implements
    AttachmentsAware,
    ParametersAware,
    StatusDetailsAware,
    StepsAware,
    Storable,
    JsonSerializable,
    UuidAware,
    LabelsAware,
    Result
{
    use ExecutableTrait;
    use JsonSerializableTrait;

    private ?string $historyId = null;

    private ?string $testCaseId = null;

    private ?string $rerunOf = null;

    private ?string $fullName = null;

    /**
     * @var array list<Label>
     */
    private array $labels = [];

    /**
     * @var array list<Label>
     */
    private array $links = [];

    public function __construct(private string $uuid)
    {
    }

    public function getResultType(): ResultType
    {
        return ResultType::test();
    }

    #[Pure]
    public function getUuid(): string
    {
        return $this->uuid;
    }

    #[Pure]
    public function getHistoryId(): ?string
    {
        return $this->historyId;
    }

    public function setHistoryId(?string $historyId): self
    {
        $this->historyId = $historyId;

        return $this;
    }

    #[Pure]
    public function getTestCaseId(): ?string
    {
        return $this->testCaseId;
    }

    public function setTestCaseId(?string $testCaseId): self
    {
        $this->testCaseId = $testCaseId;

        return $this;
    }

    #[Pure]
    public function getRerunOf(): ?string
    {
        return $this->rerunOf;
    }

    public function setRerunOf(string $rerunOf): self
    {
        $this->rerunOf = $rerunOf;

        return $this;
    }

    #[Pure]
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return list<Label>
     */
    #[Pure]
    public function getLabels(): array
    {
        return $this->labels;
    }

    public function addLabels(Label ...$labels): self
    {
        return $this->setLabels(...$this->labels, ...$labels);
    }

    public function setLabels(Label ...$labels): self
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * @return list<Link>
     */
    #[Pure]
    public function getLinks(): array
    {
        return $this->links;
    }

    public function addLinks(Link ...$links): self
    {
        return $this->setLinks(...$this->links, ...$links);
    }

    public function setLinks(Link ...$links): self
    {
        $this->links = $links;

        return $this;
    }
}
