<?php

namespace Yandex\Allure\Adapter\Annotation\Fixtures;
use Yandex\Allure\Adapter\Annotation\AllureId;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Epics;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Issues;
use Yandex\Allure\Adapter\Annotation\Label;
use Yandex\Allure\Adapter\Annotation\Labels;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Parameters;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Annotation\Step;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\TestCaseId;
use Yandex\Allure\Adapter\Annotation\TestType;
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @TestAnnotation("class")
 */
class ClassWithAnnotations
{
    /**
     * @TestAnnotation("method")
     */
    public function methodWithAnnotations()
    {
    }

    /**
     * @AllureId ("e7a8ff6cdd2908d4f50bee573708727085778061")
     * @Description ("Use this page to register account")
     * @Epics ("Make app more stable")
     * @Features ("Multi-factor authentication")
     * @Issues ("Can`t create user with numbers in login")
     * @Label (name = "backend", values="master")
     * @Parameter (name = "firstName", value = "John")
     * @Severity ("Highest")
     * @Step ("Open sign up page")
     * @Stories ("User authentication")
     * @TestCaseId ("testUserSignUp")
     * @TestType ("screenshotDiff")
     * @Title ("Sign Up")
     */
    public function methodWithAllAnnotations()
    {
    }
}
