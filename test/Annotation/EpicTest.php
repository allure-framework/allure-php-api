<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Qameta\Allure\Annotation\Epic
 */
class EpicTest extends TestCase
{
    use AnnotationTestTrait;

    public function testGetName_Always_ReturnsMatchingValue(): void
    {
        $epic = $this->getEpicInstance('demoWithValue');
        self::assertSame('epic', $epic->getName());
    }

    public function testGetValue_WithValue_ReturnsSameString(): void
    {
        $epic = $this->getEpicInstance('demoWithValue');
        self::assertSame('a', $epic->getValue());
    }

    #[Epic("a")]
    protected function demoWithValue(): void
    {
    }

    private function getEpicInstance(string $methodName): Epic
    {
        return $this->getAttributeInstance(Epic::class, $methodName);
    }
}
