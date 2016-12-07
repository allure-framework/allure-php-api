<?php

namespace Yandex\Allure\Adapter\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlRoot;

/**
 * @package Yandex\Allure\Adapter\Model
 * @XmlRoot("label")
 */
class Label implements Entity
{

    /**
     * @var string
     * @Type("string")
     * @XmlAttribute
     */
    private $name;

    /**
     * @var string
     * @Type("string")
     * @XmlAttribute
     */
    private $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $featureName
     * @return Label
     */
    public static function feature($featureName)
    {
        return new Label(LabelType::FEATURE, $featureName);
    }

    /**
     * @param $storyName
     * @return Label
     */
    public static function story($storyName)
    {
        return new Label(LabelType::STORY, $storyName);
    }

    /**
     * @param $severityLevel
     * @return Label
     */
    public static function severity($severityLevel)
    {
        return new Label(LabelType::SEVERITY, $severityLevel);
    }
    
    /**
     * @param $issueKey
     * @return Label
     */
    public static function issue($issueKey)
    {
        return new Label(LabelType::ISSUE, $issueKey);
    }

    /**
     * @param $testCaseId
     *
     * @return Label
     */
    public static function testId($testCaseId)
    {
        return new Label(LabelType::TEST_ID, $testCaseId);
    }
    
}
