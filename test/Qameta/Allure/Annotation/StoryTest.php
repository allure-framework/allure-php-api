<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Qameta\Allure\Annotation\Story
 */
class StoryTest extends TestCase
{
    use AnnotationTestTrait;

    public function testGetName_Always_ReturnsMatchingValue(): void
    {
        $story = $this->getStoryInstance('demoWithValue');
        self::assertSame('story', $story->getName());
    }

    public function testGetValue_WithValue_ReturnsSameString(): void
    {
        $story = $this->getStoryInstance('demoWithValue');
        self::assertSame('a', $story->getValue());
    }

    #[Story("a")]
    protected function demoWithValue(): void
    {
    }

    private function getStoryInstance(string $methodName): Story
    {
        return $this->getAttributeInstance(Story::class, $methodName);
    }
}
