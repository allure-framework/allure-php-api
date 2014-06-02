<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Description;
use Yandex\Allure\Adapter\Model\Entity;
use Yandex\Allure\Adapter\Model\TestSuite;
use Yandex\Allure\Adapter\Support\Utils;

class TestSuiteStartedEvent extends AbstractTestSuiteEvent {
    
    use Utils;

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

    function __construct($name)
    {
        parent::__construct();
        $this->name = $name;
        $this->labels = array();
    }
    
    function process(Entity $context)
    {
        if ($context instanceof TestSuite){
            $context->setName($this->name);
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
     * @param \Yandex\Allure\Adapter\Model\Description $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param array $labels
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

} 