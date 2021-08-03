<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JsonSerializable;
use Qameta\Allure\Internal\JsonSerializableTrait;
use function array_values;

final class ResultContainer implements JsonSerializable, UuidAwareInterface, ResultInterface
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
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return list<string>
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function addChildren(string ...$children): self
    {
        return $this->setChildren(...$this->children, ...array_values($children));
    }

    public function setChildren(string ...$children): self
    {
        $this->children = array_values($children);

        return $this;
    }

    /**
     * @return list<FixtureResult>
     */
    public function getBefores(): array
    {
        return $this->befores;
    }

    public function addSetUps(FixtureResult ...$befores): self
    {
        return $this->setBefores(...$this->befores, ...array_values($befores));
    }

    public function setBefores(FixtureResult ...$befores): self
    {
        $this->befores = array_values($befores);

        return $this;
    }

    /**
     * @return list<FixtureResult>
     */
    public function getAfters(): array
    {
        return $this->afters;
    }

    public function addTearDowns(FixtureResult ...$afters): self
    {
        return $this->setAfters(...$this->afters, ...array_values($afters));
    }

    public function setAfters(FixtureResult ...$afters): self
    {
        $this->afters = array_values($afters);

        return $this;
    }

    /**
     * @return list<Link>
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    public function addLinks(Link ...$links): self
    {
        return $this->setLinks(...$this->links, ...array_values($links));
    }

    public function setLinks(Link ...$links): self
    {
        $this->links = array_values($links);

        return $this;
    }
}
