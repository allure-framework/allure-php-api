<?php

namespace Qameta\Allure\Model;

use JsonSerializable;

/**
 * Class Attachment
 * @package Qameta\Allure\Model
 */
class Attachment implements JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $type;

    /**
     * Attachment constructor.
     * @param string $name
     * @param string $source
     * @param string $type
     */
    public function __construct($name = null, $source = null, $type = null)
    {
        $this->name = $name;
        $this->source = $source;
        $this->type = $type;
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
     * @return Attachment
     */
    public function setName(string $name): Attachment
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return Attachment
     */
    public function setSource(string $source): Attachment
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Attachment
     */
    public function setType(string $type): Attachment
    {
        $this->type = $type;
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
