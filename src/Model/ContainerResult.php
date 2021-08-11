<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use function array_map;
use function array_values;

final class ContainerResult extends StorableResult
{

    /**
     * @var list<TestResult>
     */
    protected array $children = [];

    /**
     * @var list<FixtureResult>
     */
    protected array $setUps = [];

    /**
     * @var list<FixtureResult>
     */
    protected array $tearDowns = [];

    /**
     * @var list<Link>
     */
    protected array $links = [];

    public function getResultType(): ResultType
    {
        return ResultType::container();
    }

    /**
     * @return list<TestResult>
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function addChildren(TestResult ...$children): self
    {
        return $this->setChildren(...$this->children, ...array_values($children));
    }

    public function setChildren(TestResult ...$children): self
    {
        $this->children = array_values($children);

        return $this;
    }

    /**
     * @return list<FixtureResult>
     */
    public function getSetUps(): array
    {
        return $this->setUps;
    }

    public function addSetUps(FixtureResult ...$setUps): self
    {
        return $this->setSetUps(...$this->setUps, ...array_values($setUps));
    }

    public function setSetUps(FixtureResult ...$setUps): self
    {
        $this->setUps = array_values($setUps);

        return $this;
    }

    /**
     * @return list<FixtureResult>
     */
    public function getTearDowns(): array
    {
        return $this->tearDowns;
    }

    public function addTearDowns(FixtureResult ...$tearDowns): self
    {
        return $this->setTearDowns(...$this->tearDowns, ...array_values($tearDowns));
    }

    public function setTearDowns(FixtureResult ...$tearDowns): self
    {
        $this->tearDowns = array_values($tearDowns);

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

    protected function prepareForSerialization(string $propertyName, mixed $property): mixed
    {
        return match ($propertyName) {
            'children' => array_map(
                fn (TestResult $child) => $child->getUuid(),
                (array) $property,
            ),
            default => parent::prepareForSerialization($propertyName, $property),
        };
    }

    /**
     * @return list<ResultInterface>
     */
    public function getNestedResults(): array
    {
        return [
            ...$this->setUps,
            ...$this->children,
            ...$this->tearDowns,
        ];
    }
}
