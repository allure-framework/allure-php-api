<?php

namespace Yandex\Allure\Adapter\Annotation\Fixtures;

use Yandex\Allure\Adapter\Annotation\Issues;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Model\DescriptionType;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Model\ParameterKind;

/**
 * @Title("test-suite-title")
 * @Description(value="test-suite-description", type=DescriptionType::MARKDOWN)
 * @Features({"test-suite-feature1", "test-suite-feature2"})
 * @Stories({"test-suite-story1", "test-suite-story2"})
 * @Issues({"test-suite-issue1", "test-suite-issue2"})
 */
class ExampleTestSuite
{
    /**
     * @Title("test-case-title")
     * @Description(value="test-case-description", type=DescriptionType::HTML)
     * @Features({"test-case-feature1", "test-case-feature2"})
     * @Stories({"test-case-story1", "test-case-story2"})
     * @Severity(SeverityLevel::BLOCKER)
     * @Parameter(name = "test-case-param-name", value = "test-case-param-value", kind = ParameterKind::ARGUMENT)
     * @Issues({"test-case-issue1", "test-case-issue2"})
     */
    public function exampleTestCase()
    {
    }
}
