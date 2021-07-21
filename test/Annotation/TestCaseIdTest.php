<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Qameta\Allure\Annotation\TestCaseId
 */
class TestCaseIdTest extends TestCase
{
    use AnnotationTestTrait;

    public function testGetValue_WithValue_ReturnsSameValue(): void
    {
        $testCaseId = $this->getTestCaseIdInstance('demoWithValue');
        self::assertSame('a', $testCaseId->getValue());
    }

    #[TestCaseId("a")]
    public function testGetName_Loaded_ReturnsMoacthingValue(): void
    {
        $testCaseId = $this->getTestCaseIdInstance('demoWithValue');
        self::assertSame('testId', $testCaseId->getName());
    }

    #[TestCaseId("a")]
    protected function demoWithValue(): void
    {
    }

    private function getTestCaseIdInstance(string $methodName): TestCaseId
    {
        return $this->getAttributeInstance(TestCaseId::class, $methodName);
    }
}
