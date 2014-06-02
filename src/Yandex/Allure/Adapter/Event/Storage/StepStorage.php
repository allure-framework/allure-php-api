<?php

namespace Yandex\Allure\Adapter\Event\Storage;

use Yandex\Allure\Adapter\Model\Status;
use Yandex\Allure\Adapter\Model\Step;
use \SplStack;
use Yandex\Allure\Adapter\Support\Utils;

class StepStorage {

    use Utils;
    
    /**
     * @var SplStack
     */
    private $storage;

    function __construct()
    {
        $this->storage = new SplStack();
    }

    /**
     * @return Step
     */
    public function getLast(){
        if ($this->storage->isEmpty()){
            $this->put($this->getRootStep());
        }
        return $this->storage->top();
    }

    /**
     * @return Step
     */
    public function pollLast()
    {
        $step = $this->storage->pop();
        if ($this->storage->isEmpty()){
            $this->storage->push($this->getRootStep());
        }
        return $step;
    }
    
    /**
     * @param Step $step
     */
    public function put(Step $step){
        $this->storage->push($step);
    }

    /**
     * @return Step
     */
    private function getRootStep(){
        $step = new Step();
        $step->setName("Root step");
        $step->setTitle("If you're seeing this then there's an error in step processing. Please send feedback to allure@yandex-team.ru. Thank you.");
        $step->setStart(self::getTimestamp());
        $step->setStatus(Status::BROKEN);
        return $step;
    }

} 