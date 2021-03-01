<?php


namespace Qameta\Allure\Model;

use JsonSerializable;

/**
 * Class TestResultContainer
 * @package Qameta\Allure\Model
 */
class TestResultContainer implements JsonSerializable
{

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var array<string>
     */
    private $children;

    /**
     * @var array<FixtureResult>
     */
    private $befores;

    /**
     * @var array<FixtureResult>
     */
    private $afters;

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return TestResultContainer
     */
    public function setUuid(string $uuid): TestResultContainer
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param array $children
     * @return TestResultContainer
     */
    public function setChildren(array $children): TestResultContainer
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @return array
     */
    public function getBefores(): array
    {
        return $this->befores;
    }

    /**
     * @param array $befores
     * @return TestResultContainer
     */
    public function setBefores(array $befores): TestResultContainer
    {
        $this->befores = $befores;
        return $this;
    }

    /**
     * @return array
     */
    public function getAfters(): array
    {
        return $this->afters;
    }

    /**
     * @param array $afters
     * @return TestResultContainer
     */
    public function setAfters(array $afters): TestResultContainer
    {
        $this->afters = $afters;
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