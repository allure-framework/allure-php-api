<?php

namespace Yandex\Allure\Adapter;

use Yandex\Allure\Adapter\Event\ClearStepStorageEvent;
use Yandex\Allure\Adapter\Event\ClearTestCaseStorageEvent;
use Yandex\Allure\Adapter\Model\Step;
use Yandex\Allure\Adapter\Model\TestCase;

class AllureTest extends \PHPUnit_Framework_TestCase {

    public function testStepStorageClearEvent()
    {
        Allure::lifecycle()->getStepStorage()->clear();
        Allure::lifecycle()->getStepStorage()->put(new Step());
        Allure::lifecycle()->fire(new ClearStepStorageEvent());
        $this->assertTrue(Allure::lifecycle()->getStepStorage()->isEmpty());
    }
    
    public function testTestCaseStorageClear()
    {
        Allure::lifecycle()->getTestCaseStorage()->clear();
        Allure::lifecycle()->getTestCaseStorage()->put(new TestCase());
        Allure::lifecycle()->fire(new ClearTestCaseStorageEvent());
        $this->assertTrue(Allure::lifecycle()->getTestCaseStorage()->isEmpty());
    }
} 