<?php

declare(strict_types=1);

namespace Qameta\Allure\Test\Attribute;

use PHPUnit\Framework\TestCase;
use Qameta\Allure\Attribute\Parameter;

/**
 * @covers \Qameta\Allure\Attribute\Parameter
 * @covers \Qameta\Allure\Attribute\AbstractParameter
 */
class ParameterTest extends TestCase
{
    use AnnotationTestTrait;

    public function testGetName_WithVNameReturnsSameString(): void
    {
        $parameter = $this->getParameterInstance('demoWithNameAndValue');
        self::assertSame('a', $parameter->getName());
    }

    public function testGetValue_WithValue_ReturnsSameString(): void
    {
        $parameter = $this->getParameterInstance('demoWithNameAndValue');
        self::assertSame('b', $parameter->getValue());
    }

    #[Parameter("a", "b")]
    protected function demoWithNameAndValue(): void
    {
    }

    private function getParameterInstance(string $methodName): Parameter
    {
        return $this->getAttributeInstance(Parameter::class, $methodName);
    }
}