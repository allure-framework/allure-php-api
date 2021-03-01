<?php


namespace Qameta\Allure\Model;

use JsonSerializable;

/**
 * Class Parameter
 * @package Qameta\Allure\Model
 */
class Parameter implements JsonSerializable
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
     * Parameter constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct(string $name = null, string $value = null)
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
     * @return Parameter
     */
    public function setName(string $name): Parameter
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
     * @return Parameter
     */
    public function setValue(string $value): Parameter
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
