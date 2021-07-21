<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Qameta\Allure\Annotation\TmsLink
 */
class TmsLinkTest extends TestCase
{
    use AnnotationTestTrait;

    public function testGetType_Always_ReturnsMatchingValue(): void
    {
        $tmsLink = $this->getIssueInstance('demoOnlyName');
        self::assertSame('tms', $tmsLink->getType());
    }

    /**
     * @dataProvider providerGetName
     */
    public function testGetName_Loaded_ReturnsMatchingValue(string $methodName, ?string $expectedValue): void
    {
        $tmsLink = $this->getIssueInstance($methodName);
        self::assertSame($expectedValue, $tmsLink->getName());
    }

    public function providerGetName(): iterable
    {
        return [
            'No arguments' => ['demoNoArguments', null],
            'Only name' => ['demoOnlyName', 'a'],
            'Only URL' => ['demoOnlyUrl', null],
            'Name and URL' => ['demoWithNameAndUrl', 'a'],
        ];
    }

    /**
     * @dataProvider providerGetUrl
     */
    public function testGetUrl_Loaded_ReturnsMatchingValue(string $methodName, ?string $expectedValue): void
    {
        $tmsLink = $this->getIssueInstance($methodName);
        self::assertSame($expectedValue, $tmsLink->getUrl());
    }

    public function providerGetUrl(): iterable
    {
        return [
            'No arguments' => ['demoNoArguments', null],
            'Only name' => ['demoOnlyName', null],
            'Only URL' => ['demoOnlyUrl', 'a'],
            'Name and URL' => ['demoWithNameAndUrl', 'b'],
        ];
    }

    #[TmsLink]
    protected function demoNoArguments(): void
    {
    }

    #[TmsLink("a")]
    protected function demoOnlyName(): void
    {
    }

    #[TmsLink(url: "a")]
    protected function demoOnlyUrl(): void
    {
    }

    #[TmsLink("a", "b")]
    protected function demoWithNameAndUrl(): void
    {
    }

    private function getIssueInstance(string $methodName): TmsLink
    {
        return $this->getAttributeInstance(TmsLink::class, $methodName);
    }
}
