<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Qameta\Allure\Annotation\Link
 */
class LinkTest extends TestCase
{
    use AnnotationTestTrait;

    /**
     * @dataProvider providerGetType
     */
    public function testGetType_Loaded_ReturnsMatchingValue(string $methodName, string $expectedValue): void
    {
        $link = $this->getLinkInstance($methodName);
        self::assertSame($expectedValue, $link->getType());
    }

    public function providerGetType(): iterable
    {
        return [
            'No arguments' => ['demoEmpty', 'custom'],
            'Name and URL' => ['demoWithNameAndUrl', 'custom'],
            'Only name' => ['demoOnlyName', 'custom'],
            'Only URL' => ['demoOnlyUrl', 'custom'],
            'Custom type' => ['demoWithCustomType', 'custom'],
            'Issue' => ['demoWithIssueType', 'issue'],
            'TMS link' => ['demoWithTmsType', 'tms'],
        ];
    }

    /**
     * @dataProvider providerGetName
     */
    public function testGetName_Loaded_ReturnsMatchingValue(string $methodName, ?string $expectedValue): void
    {
        $link = $this->getLinkInstance($methodName);
        self::assertSame($expectedValue, $link->getName());
    }

    public function providerGetName(): iterable
    {
        return [
            'No arguments' => ['demoEmpty', null],
            'Name and URL' => ['demoWithNameAndUrl', 'a'],
            'Only name' => ['demoOnlyName', 'a'],
            'Only URL' => ['demoOnlyUrl', null],
        ];
    }

    /**
     * @dataProvider providerGetUrl
     */
    public function testGetUrl_Loaded_ReturnsMatchingValue(string $methodName, ?string $expectedValue): void
    {
        $link = $this->getLinkInstance($methodName);
        self::assertSame($expectedValue, $link->getUrl());
    }

    public function providerGetUrl(): iterable
    {
        return [
            'No arguments' => ['demoEmpty', null],
            'Name and URL' => ['demoWithNameAndUrl', 'b'],
            'Only name' => ['demoOnlyName', null],
            'Only URL' => ['demoOnlyUrl', 'a'],
        ];
    }

    #[Link]
    protected function demoEmpty(): void
    {
    }

    #[Link("a", "b")]
    protected function demoWithNameAndUrl(): void
    {
    }

    #[Link("a")]
    protected function demoOnlyName(): void
    {
    }

    #[Link(url: "a")]
    protected function demoOnlyUrl(): void
    {
    }

    #[Link("a", "b", Link::CUSTOM)]
    protected function demoWithCustomType(): void
    {
    }

    #[Link("a", "b", Link::ISSUE)]
    protected function demoWithIssueType(): void
    {
    }

    #[Link("a", "b", Link::TMS)]
    protected function demoWithTmsType(): void
    {
    }

    private function getLinkInstance(string $methodName): Link
    {
        return $this->getAttributeInstance(Link::class, $methodName);
    }
}