<?php

namespace Yandex\Allure\Adapter\Model;


use Yandex\Allure\Adapter\AllureException;

class ConstantCheckerTest extends \PHPUnit_Framework_TestCase {
    
    const CLASS_NAME = 'Yandex\Allure\Adapter\Model\TestConstants';
    
    public function testConstantIsPresent()
    {
        $this->assertEquals(TestConstants::TEST_CONSTANT, ConstantChecker::validate(self::CLASS_NAME, TestConstants::TEST_CONSTANT));
    }

    /**
     * @expectedException \Yandex\Allure\Adapter\AllureException
     */
    public function testConstantIsMissing()
    {
        ConstantChecker::validate(self::CLASS_NAME, 'missing-value');
    }
}

class TestConstants {
    const TEST_CONSTANT = 'test-value';
}