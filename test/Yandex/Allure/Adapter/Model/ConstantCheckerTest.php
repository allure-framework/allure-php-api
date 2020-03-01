<?php

namespace Yandex\Allure\Adapter\Model;

use PHPUnit\Framework\TestCase;
use Yandex\Allure\Adapter\AllureException;
use Yandex\Allure\Adapter\Model\Fixtures\TestConstants;

class ConstantCheckerTest extends TestCase
{
    const CLASS_NAME = 'Yandex\Allure\Adapter\Model\Fixtures\TestConstants';

    public function testConstantIsPresent()
    {
        $this->assertEquals(
            TestConstants::TEST_CONSTANT,
            ConstantChecker::validate(self::CLASS_NAME, TestConstants::TEST_CONSTANT)
        );
    }

    /**
     * @expectedException \Yandex\Allure\Adapter\AllureException
     */
    public function testConstantIsMissing()
    {
        ConstantChecker::validate(self::CLASS_NAME, 'missing-value');
    }
}
