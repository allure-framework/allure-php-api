<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Entity;
use Yandex\Allure\Adapter\Model\Failure;
use Yandex\Allure\Adapter\Model\TestCase;
use Yandex\Allure\Adapter\Support\Utils;

abstract class TestCaseStatusChangedEvent implements TestCaseEvent {

    /**
     * @var \Exception
     */
    private $exception;

    /**
     * @var string
     */
    private $message;
    
    /**
     * @return string
     */
    protected abstract function getStatus();
    
    function process(Entity $context)
    {
        if ($context instanceof TestCase){
            $context->setStatus($this->getStatus());
            $exception = $this->exception;
            if (isset($exception)){
                $failure = new Failure($this->message);
                $failure->setStackTrace($exception->getTraceAsString());
                $context->setFailure($failure);
            }
        }
    }

    public function withMessage($message){
        $this->message = $message;
        return $this;
    }
    
    public function withException($exception){
        $this->exception = $exception;
        return $this;
    }

} 