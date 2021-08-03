<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Qameta\Allure\Annotation\Issue
 */
class IssueTest extends TestCase
{
    use AnnotationTestTrait;

    public function testGetType_Always_ReturnsMatchingValue(): void
    {
        $issue = $this->getIssueInstance('demoOnlyName');
        self::assertSame('issue', $issue->getType());
    }

    /**
     * @dataProvider providerGetName
     */
    public function testGetName_Loaded_ReturnsMatchingValue(string $methodName, ?string $expectedValue): void
    {
        $issue = $this->getIssueInstance($methodName);
        self::assertSame($expectedValue, $issue->getName());
    }

    /**
     * @return iterable<string, array{string, string|null}>
     */
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
        $issue = $this->getIssueInstance($methodName);
        self::assertSame($expectedValue, $issue->getUrl());
    }

    /**
     * @return iterable<string, array{string, string|null}>
     */
    public function providerGetUrl(): iterable
    {
        return [
            'No arguments' => ['demoNoArguments', null],
            'Only name' => ['demoOnlyName', null],
            'Only URL' => ['demoOnlyUrl', 'a'],
            'Name and URL' => ['demoWithNameAndUrl', 'b'],
        ];
    }

    #[Issue]
    protected function demoNoArguments(): void
    {
    }

    #[Issue("a")]
    protected function demoOnlyName(): void
    {
    }

    #[Issue(url: "a")]
    protected function demoOnlyUrl(): void
    {
    }

    #[Issue("a", "b")]
    protected function demoWithNameAndUrl(): void
    {
    }

    private function getIssueInstance(string $methodName): Issue
    {
        return $this->getAttributeInstance(Issue::class, $methodName);
    }
}
