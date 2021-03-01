<?php

namespace Qameta\Allure\Model;

use JsonSerializable;

/**
 * Class Link
 * @package Qameta\Allure\Model
 */
class Link implements JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $type;

    /**
     * Link constructor.
     * @param string $name
     * @param string $url
     * @param string $type
     */
    public function __construct($name = null, $url = null, $type = null)
    {
        $this->name = $name;
        $this->url = $url;
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
     * @return Link
     */
    public function setName(string $name): Link
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Link
     */
    public function setUrl(string $url): Link
    {
        $this->url = $url;
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
     * @return Link
     */
    public function setType(string $type): Link
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
