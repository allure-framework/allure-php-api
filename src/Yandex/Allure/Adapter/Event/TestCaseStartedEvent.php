<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Description;
use Yandex\Allure\Adapter\Model\Entity;
use Yandex\Allure\Adapter\Model\Status;
use Yandex\Allure\Adapter\Model\TestCase;
use Yandex\Allure\Adapter\Support\Utils;

class TestCaseStartedEvent implements TestCaseEvent {
    
    use Utils;

    /**
     * @var string
     */
    private $suiteUuid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var Description
     */
    private $description;

    /**
     * @var array
     */
    private $labels;
    
    /**
     * @var array
     */
    private $parameters;

    function __construct($suiteUuid, $name)
    {
        $this->suiteUuid = $suiteUuid;
        $this->name = $name;
        $this->labels = array();
        $this->parameters = array();
    }
    
    function process(Entity $context)
    {
        if ($context instanceof TestCase){
            $context->setName($this->name);
            $context->setStatus(Status::PASSED);
            $context->setStart(self::getTimestamp());
            $context->setTitle($this->title);
            $context->setDescription($this->description);
            foreach ($this->labels as $label){
                $context->addLabel($label);
            }
        }
    }

    /**
     * @param string $title
     * @return $this
     */
    function withTitle($title){
        $this->setTitle($title);
        return $this;
    }

    /**
     * @param Description $description
     * @return $this
     */
    function withDescription(Description $description){
        $this->setDescription($description);
        return $this;
    }

    /**
     * @param array $labels
     * @return $this
     */
    function withLabels(array $labels){
        $this->setLabels($labels);
        return $this;
    }
    
    /**
     * @param array $parameters
     * @return $this
     */
    function withParameters(array $parameters){
        $this->setParameters($parameters);
        return $this;
    }

    /**
     * @return string
     */
    public function getSuiteUuid()
    {
        return $this->suiteUuid;
    }

    /**
     * @param \Yandex\Allure\Adapter\Model\Description $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param array $labels
     */
    public function setLabels(array $labels)
    {
        $this->labels = $labels;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }
    
} 