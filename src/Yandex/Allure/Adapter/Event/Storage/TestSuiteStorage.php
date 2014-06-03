<?php

namespace Yandex\Allure\Adapter\Event\Storage;


use Yandex\Allure\Adapter\Model\TestSuite;

class TestSuiteStorage {

    /**
     * @var array
     */
    private $storage;

    function __construct()
    {
        $this->storage = [];
    }

    /**
     * @param $uuid
     * @return TestSuite
     */
    public function get($uuid){
        if (!array_key_exists($uuid, $this->storage)){
            $this->storage[$uuid] = new TestSuite();
        }
        return $this->storage[$uuid];
    }
    
    public function remove($uuid){
        if (array_key_exists($uuid, $this->storage)){
            unset($this->storage[$uuid]);
        }
    }

} 