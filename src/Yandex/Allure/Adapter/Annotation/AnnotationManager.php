<?php

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation;
use Yandex\Allure\Adapter\Event\TestCaseStartedEvent;
use Yandex\Allure\Adapter\Event\TestSuiteStartedEvent;
use Yandex\Allure\Adapter\Model;
use Yandex\Allure\Adapter\Model\ConstantChecker;

class AnnotationManager {

    /**
     * @var string
     */
    private $title;

    /**
     * @var Model\Description
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
    

    function __construct(array $annotations)
    {
        $this->labels = [];
        $this->parameters = [];
        $this->processAnnotations($annotations);
    }
    
    private function processAnnotations(array $annotations)
    {
        foreach ($annotations as $annotation){
            if ($annotation instanceof Title) {
                $this->title = $annotation->value;
            } else if ($annotation instanceof Description) {
                $this->description = new Model\Description(
                    $annotation->type,
                    $annotation->value
                );
            } else if ($annotation instanceof Features) {
                foreach ($annotation->getFeatureNames() as $featureName) {
                    $this->labels[] = Model\Label::feature($featureName);
                }
            } else if ($annotation instanceof Stories) {
                foreach ($annotation->getStories() as $storyName) {
                    $this->labels[] = Model\Label::story($storyName);
                }
            } else if ($annotation instanceof Severity) {
                $this->labels[] = Model\Label::severity(ConstantChecker::validate('Yandex\Allure\Adapter\Model\SeverityLevel', $annotation->level));
            } else if ($annotation instanceof Parameter) {
                $this->parameters[] = new Model\Parameter(
                    $annotation->name,
                    $annotation->value,
                    $annotation->kind
                );
            }
        }
    }

    public function updateTestSuiteEvent(TestSuiteStartedEvent $event)
    {
        
        if ($this->isTitlePresent()){
            $event->setTitle($this->getTitle());
        }
        
        if ($this->isDescriptionPresent()){
            $event->setDescription($this->getDescription());
        }
        
        if ($this->areLabelsPresent()){
            $event->setLabels($this->getLabels());
        }
        
    }
    
    public function updateTestCaseEvent(TestCaseStartedEvent $event){
        
        if ($this->isTitlePresent()){
            $event->setTitle($this->getTitle());
        }

        if ($this->isDescriptionPresent()){
            $event->setDescription($this->getDescription());
        }

        if ($this->areLabelsPresent()){
            $event->setLabels($this->getLabels());
        }
        
        if ($this->areParametersPresent()){
            $event->setParameters($this->getParameters());
        }
        
    }

    /**
     * @return Model\Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    public function isTitlePresent()
    {
        return isset($this->title);
    }
    
    public function isDescriptionPresent()
    {
        return isset($this->description);
    }
    
    public function areLabelsPresent()
    {
        return !empty($this->labels);
    }
    
    public function areParametersPresent()
    {
        return !empty($this->parameters);
    }
} 