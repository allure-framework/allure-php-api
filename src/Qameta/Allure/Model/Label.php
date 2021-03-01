<?php

namespace Qameta\Allure\Model;

use JsonSerializable;

/**
 * Class Label
 * @package Qameta\Allure\Model
 */
class Label implements JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * Label constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct($name = null, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
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
     * @return Label
     */
    public function setName(string $name): Label
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return Label
     */
    public function setValue(string $value): Label
    {
        $this->value = $value;
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
