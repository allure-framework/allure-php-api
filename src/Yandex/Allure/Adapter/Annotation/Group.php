<?php

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 * @package Yandex\Allure\Adapter\Annotation
 */
class Group
{
    /**
     * @var string
     * @Required
     */
    public $groupName;

    /**
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }
}
