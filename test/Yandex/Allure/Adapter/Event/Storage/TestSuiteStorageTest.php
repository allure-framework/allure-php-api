<?php

namespace Yandex\Allure\Adapter\Event\Storage;

class TestSuiteStorageTest extends \PHPUnit_Framework_TestCase
{
    public function testLifecycle()
    {
        $storage = new TestSuiteStorage();
        $uuid = 'some-uuid';
        $name = 'some-name';
        $testSuite = $storage->get($uuid);
        $this->assertEmpty($testSuite->getName());
        $testSuite->setName($name);
        $this->assertEquals($name, $storage->get($uuid)->getName());

        $storage->remove($uuid);
        $this->assertEmpty($storage->get($uuid)->getName());
    }
}
