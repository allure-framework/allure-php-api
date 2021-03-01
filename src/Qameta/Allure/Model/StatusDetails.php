<?php


namespace Qameta\Allure\Model;

use JsonSerializable;

/**
 * Class StatusDetails
 * @package Qameta\Allure\Model
 */
class StatusDetails implements JsonSerializable
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $trace;

    /**
     * StatusDetails constructor.
     * @param string $message
     * @param string $trace
     */
    public function __construct(string $message = null, string $trace = null)
    {
        $this->message = $message;
        $this->trace = $trace;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return StatusDetails
     */
    public function setMessage(string $message): StatusDetails
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getTrace(): string
    {
        return $this->trace;
    }

    /**
     * @param string $trace
     * @return StatusDetails
     */
    public function setTrace(string $trace): StatusDetails
    {
        $this->trace = $trace;
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
