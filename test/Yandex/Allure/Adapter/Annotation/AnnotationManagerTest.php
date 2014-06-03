<?php

namespace Yandex\Allure\Adapter\Annotation;

use Yandex\Allure\Adapter\Event\TestCaseStartedEvent;
use Yandex\Allure\Adapter\Event\TestSuiteStartedEvent;
use Yandex\Allure\Adapter\Model\DescriptionType;
use Yandex\Allure\Adapter\Model\ParameterKind;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Model;
use Yandex\Allure\Adapter\Model\Label;
use Yandex\Allure\Adapter\Model\LabelType;

class AnnotationManagerTest extends \PHPUnit_Framework_TestCase{
    
    public function testUpdateTestSuiteStartedEvent()
    {
        $instance = new ExampleTestSuite();
        $testSuiteAnnotations = AnnotationProvider::getClassAnnotations($instance);
        $annotationManager = new AnnotationManager($testSuiteAnnotations);
        $event = new TestSuiteStartedEvent('some-name');
        $annotationManager->updateTestSuiteEvent($event);
        
        $this->assertEquals('test-suite-title', $event->getTitle());
        $this->assertEquals('test-suite-description', $event->getDescription()->getValue());
        $this->assertEquals(DescriptionType::MARKDOWN, $event->getDescription()->getType());
        $this->assertEquals(4, sizeof($event->getLabels()));

        //Check feature presence
        $features = $this->getLabelsByType($event->getLabels(), LabelType::FEATURE);
        $this->assertEquals(2, sizeof($features));
        $index = 1;
        foreach ($features as $feature){
            $this->assertTrue( ($feature instanceof Label) && ($feature->getValue() === "test-suite-feature$index") );
            $index++;
        }

        //Check stories presence
        $stories = $this->getLabelsByType($event->getLabels(), LabelType::STORY);
        $this->assertEquals(2, sizeof($stories));
        $index = 1;
        foreach ($stories as $story){
            $this->assertTrue( ($story instanceof Label) && ($story->getValue() === "test-suite-story$index") );
            $index++;
        }
    }

    public function testUpdateTestCaseStartedEvent()
    {
        $instance = new ExampleTestSuite();
        $testCaseAnnotations = AnnotationProvider::getMethodAnnotations($instance, 'exampleTestCase');
        $annotationManager = new AnnotationManager($testCaseAnnotations);
        $event = new TestCaseStartedEvent('some-uid', 'some-name');
        $annotationManager->updateTestCaseEvent($event);

        //Check scalar properties
        $this->assertEquals('test-case-title', $event->getTitle());
        $this->assertEquals('test-case-description', $event->getDescription()->getValue());
        $this->assertEquals(DescriptionType::HTML, $event->getDescription()->getType());
        $this->assertEquals(5, sizeof($event->getLabels()));

        //Check feature presence
        $features = $this->getLabelsByType($event->getLabels(), LabelType::FEATURE);
        $this->assertEquals(2, sizeof($features));
        $index = 1;
        foreach ($features as $feature){
            $this->assertTrue( ($feature instanceof Label) && ($feature->getValue() === "test-case-feature$index") );
            $index++;
        }

        //Check stories presence
        $stories = $this->getLabelsByType($event->getLabels(), LabelType::STORY);
        $this->assertEquals(2, sizeof($stories));
        $index = 1;
        foreach ($stories as $story){
            $this->assertTrue( ($story instanceof Label) && ($story->getValue() === "test-case-story$index") );
            $index++;
        }

        //Check severity presence
        $severities = $this->getLabelsByType($event->getLabels(), LabelType::SEVERITY);
        $this->assertEquals(1, sizeof($severities));
        $severity = array_pop($severities);
        $this->assertTrue( ($severity instanceof Label) && ($severity->getValue() === SeverityLevel::BLOCKER) );
        
        //Check parameter presence
        $parameters = $event->getParameters();
        $this->assertEquals(1, sizeof($parameters));
        $parameter = array_pop($parameters);
        $this->assertTrue(
            ($parameter instanceof Model\Parameter) &&
            ($parameter->getName() === 'test-case-parameter-name') &&
            ($parameter->getValue() === 'test-case-parameter-value') &&
            ($parameter->getKind() === ParameterKind::ARGUMENT)
        );
        
    }

    /**
     * @param array $labels
     * @param string $labelType
     * @return array
     */
    private function getLabelsByType(array $labels, $labelType)
    {
        $filteredArray =  array_filter($labels, function($element) use ($labelType) {
            return ($element instanceof Label) && ($element->getName() === $labelType);
        });
        uasort($filteredArray, function(Label $l1, Label $l2){
            $label1Value = $l1->getValue();
            $label2Value = $l2->getValue();
            if ($label1Value === $label2Value) {
                return 0;
            }
            return ($label1Value < $label2Value) ? -1 : 1;
        });
        return $filteredArray;
    }
}

/**
 * @Title("test-suite-title")
 * @Description(value="test-suite-description", type=DescriptionType::MARKDOWN)
 * @Features({"test-suite-feature1", "test-suite-feature2"})
 * @Stories({"test-suite-story1", "test-suite-story2"})
 */
class ExampleTestSuite {


    /**
     * @Title("test-case-title")
     * @Description(value="test-case-description", type=DescriptionType::HTML)
     * @Features({"test-case-feature1", "test-case-feature2"})
     * @Stories({"test-case-story1", "test-case-story2"})
     * @Severity(SeverityLevel::BLOCKER)
     * @Parameter(name = "test-case-parameter-name", value = "test-case-parameter-value", kind = ParameterKind::ARGUMENT)
     */
    public function exampleTestCase(){}
    
}