<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Qameta\Allure\Annotation\Feature
 */
class FeatureTest extends TestCase
{
    use AnnotationTestTrait;

    public function testGetName_Always_ReturnsMatchingValue(): void
    {
        $feature = $this->getFeatureInstance('demoWithValue');
        self::assertSame('feature', $feature->getName());
    }

    public function testGetValue_WithValue_ReturnsSameString(): void
    {
        $feature = $this->getFeatureInstance('demoWithValue');
        self::assertSame('a', $feature->getValue());
    }

    #[Feature("a")]
    protected function demoWithValue(): void
    {
    }

    private function getFeatureInstance(string $methodName): Feature
    {
        return $this->getAttributeInstance(Feature::class, $methodName);
    }
}
