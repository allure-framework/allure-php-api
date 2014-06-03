<?php

namespace Yandex\Allure\Adapter;


use Yandex\Allure\Adapter\Event\ClearStepStorageEvent;
use Yandex\Allure\Adapter\Event\ClearTestCaseStorageEvent;
use Yandex\Allure\Adapter\Event\Event;
use Yandex\Allure\Adapter\Event\StepEvent;
use Yandex\Allure\Adapter\Event\StepFinishedEvent;
use Yandex\Allure\Adapter\Event\StepStartedEvent;
use Yandex\Allure\Adapter\Event\Storage\StepStorage;
use Yandex\Allure\Adapter\Event\Storage\TestCaseStorage;
use Yandex\Allure\Adapter\Event\Storage\TestSuiteStorage;
use Yandex\Allure\Adapter\Event\TestCaseEvent;
use Yandex\Allure\Adapter\Event\TestCaseFinishedEvent;
use Yandex\Allure\Adapter\Event\TestCaseStartedEvent;
use Yandex\Allure\Adapter\Event\TestSuiteEvent;
use Yandex\Allure\Adapter\Event\TestSuiteFinishedEvent;
use Yandex\Allure\Adapter\Model\Provider;
use Yandex\Allure\Adapter\Model\Step;
use Yandex\Allure\Adapter\Model\TestSuite;
use Yandex\Allure\Adapter\Support\Utils;

class Allure {
    
    use Utils;
    
    private static $lifecycle;

    private $stepStorage;
    private $testCaseStorage;
    private $testSuiteStorage;

    private function __construct()
    {
        $this->stepStorage = new StepStorage();
        $this->testCaseStorage = new TestCaseStorage();
        $this->testSuiteStorage = new TestSuiteStorage();
    }

    public static function lifecycle()
    {
        if (!isset(self::$lifecycle)){
            self::$lifecycle = new Allure();
        }
        return self::$lifecycle;
    }

    public function fire(Event $event)
    {
        if ($event instanceof StepStartedEvent){
            $this->processStepStartedEvent($event);
        } else if ($event instanceof StepFinishedEvent){
            $this->processStepFinishedEvent($event);
        } else if ($event instanceof TestCaseStartedEvent){
            $this->processTestCaseStartedEvent($event);
        } else if ($event instanceof TestCaseFinishedEvent){
            $this->processTestCaseFinishedEvent($event);
        } else if ($event instanceof TestSuiteFinishedEvent){
            $this->processTestSuiteFinishedEvent($event);
        } else if ($event instanceof TestSuiteEvent){
            $this->processTestSuiteEvent($event);
        } else if ($event instanceof ClearStepStorageEvent){
            $this->processClearStepStorageEvent();
        } else if ($event instanceof ClearTestCaseStorageEvent){
            $this->processClearTestCaseStorageEvent();
        } else if ($event instanceof TestCaseEvent){
            $this->processTestCaseEvent($event);
        } else if ($event instanceof StepEvent) {
            $this->processStepEvent($event);
        } else {
            throw new AllureException("Unknown event: " . get_class($event));
        }
    }

    private function processStepStartedEvent(StepStartedEvent $event)
    {
        $step = new Step();
        $event->process($step);
        $this->getStepStorage()->put($step);
    }
    
    private function processStepFinishedEvent(StepFinishedEvent $event)
    {
        $step = $this->getStepStorage()->pollLast();
        $event->process($step);
        $this->getStepStorage()->getLast()->addStep($step);
    }
    
    private function processStepEvent(StepEvent $event)
    {
        $step = $this->getStepStorage()->getLast();
        $event->process($step);
    }
    
    private function processTestCaseStartedEvent(TestCaseStartedEvent $event)
    {
        //init root step in parent thread if needed
        $this->getStepStorage()->getLast();
        
        $testCase = $this->getTestCaseStorage()->get();
        $event->process($testCase);
        $this->getTestSuiteStorage()->get($event->getSuiteUuid())->addTestCase($testCase);
    }

    private function processTestCaseFinishedEvent(TestCaseFinishedEvent $event)
    {
        $testCase = $this->getTestCaseStorage()->get();
        $event->process($testCase);
        $root = $this->getStepStorage()->pollLast();
        foreach ($root->getSteps() as $step){
            $testCase->addStep($step);
        }
        foreach ($root->getAttachments() as $attachment){
            $testCase->addAttachment($attachment);
        }
    }
    
    private function processTestCaseEvent(TestCaseEvent $event)
    {
        $testCase = $this->getTestCaseStorage()->get();
        $event->process($testCase);
    }

    private function processTestSuiteEvent(TestSuiteEvent $event)
    {
        $uuid = $event->getUuid();
        $testSuite = $this->getTestSuiteStorage()->get($uuid);
        $event->process($testSuite);
    }

    private function processTestSuiteFinishedEvent(TestSuiteFinishedEvent $event)
    {
        $suiteUuid = $event->getUuid();
        $testSuite = $this->getTestSuiteStorage()->get($suiteUuid);
        $event->process($testSuite);
        $this->getTestSuiteStorage()->remove($suiteUuid);
        $this->saveToFile($testSuite);
    }
    
    private function saveToFile(TestSuite $testSuite)
    {
        if ($testSuite->size() > 0) {
            $xml = $testSuite->serialize();
            $fileName = self::generateUUID() . '-testsuite.xml';
            $filePath = Provider::getOutputDirectory() . DIRECTORY_SEPARATOR . $fileName;
            file_put_contents($filePath, $xml);
        }
    }
    
    private function processClearStepStorageEvent()
    {
        $this->getStepStorage()->clear();
    }
    
    private function processClearTestCaseStorageEvent()
    {
        $this->getTestCaseStorage()->clear();
    }
    
    /**
     * @return \Yandex\Allure\Adapter\Event\Storage\StepStorage
     */
    public function getStepStorage()
    {
        return $this->stepStorage;
    }

    /**
     * @return \Yandex\Allure\Adapter\Event\Storage\TestCaseStorage
     */
    public function getTestCaseStorage()
    {
        return $this->testCaseStorage;
    }

    /**
     * @return \Yandex\Allure\Adapter\Event\Storage\TestSuiteStorage
     */
    public function getTestSuiteStorage()
    {
        return $this->testSuiteStorage;
    }
    
    
}