<?php

namespace Yandex\Allure\Adapter\Event\Storage;

use Yandex\Allure\Adapter\Model\TestCase;

class TestCaseStorageTest extends \PHPUnit_Framework_TestCase
{
    public function testLifecycle()
    {
        $storage = new TestCaseStorage();
        $testCase = $storage->get();
        $this->assertEmpty($testCase->getName());

        $name1 = 'test-name1';
        $testCase->setName($name1);
        $this->assertEquals($name1, $storage->get()->getName());

        $name2 = 'test-name1';
        $testCase = new TestCase();
        $testCase->setName($name2);
        $storage->put($testCase);
        $this->assertEquals($name2, $storage->get()->getName());

        $storage->clear();
        $this->assertEmpty($storage->get()->getName());
    }
}
