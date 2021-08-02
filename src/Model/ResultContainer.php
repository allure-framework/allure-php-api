<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Qameta\Allure\Internal\JsonSerializableTrait;

final class ResultContainer implements JsonSerializable, UuidAware, Result
{
    use JsonSerializableTrait;
    use TimeAwareTrait;

    /**
     * @var list<string>
     */
    private array $children = [];

    /**
     * @var list<FixtureResult>
     */
    private array $befores = [];

    /**
     * @var list<FixtureResult>
     */
    private array $afters = [];

    /**
     * @var list<Link>
     */
    private array $links = [];

    #[Pure]
    public function __construct(private string $uuid)
    {
    }

    public function getResultType(): ResultType
    {
        return ResultType::container();
    }

    /**
     * @return string
     */
    #[Pure]
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return list<string>
     */
    #[Pure]
    public function getChildren(): array
    {
        return $this->children;
    }

    public function addChildren(string ...$children): self
    {
        return $this->setChildren(...$this->children, ...$children);
    }

    public function setChildren(string ...$children): self
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return list<FixtureResult>
     */
    #[Pure]
    public function getBefores(): array
    {
        return $this->befores;
    }

    public function addSetUps(FixtureResult ...$befores): self
    {
        return $this->setBefores(...$this->befores, ...$befores);
    }

    public function setBefores(FixtureResult ...$befores): self
    {
        $this->befores = $befores;

        return $this;
    }

    /**
     * @return list<FixtureResult>
     */
    #[Pure]
    public function getAfters(): array
    {
        return $this->afters;
    }

    public function addTearDowns(FixtureResult ...$afters): self
    {
        return $this->setAfters(...$this->afters, ...$afters);
    }

    public function setAfters(FixtureResult ...$afters): self
    {
        $this->afters = $afters;

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
