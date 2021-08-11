<?php

declare(strict_types=1);

namespace Qameta\Allure\Test\Attribute;

use PHPUnit\Framework\TestCase;
use Qameta\Allure\Attribute\Title;

/**
 * @covers \Qameta\Allure\Attribute\Title
 * @covers \Qameta\Allure\Attribute\AbstractTitle
 */
class TitleTest extends TestCase
{
    use AnnotationTestTrait;

    public function testGetValue_WithValue_ReturnsSameValue(): void
    {
        $title = $this->getTitleInstance('demoWithValue');
        self::assertSame('a', $title->getValue());
    }

    #[Title("a")]
    protected function demoWithValue(): void
    {
    }

    private function getTitleInstance(string $methodName): Title
    {
        return $this->getAttributeInstance(Title::class, $methodName);
    }
}
