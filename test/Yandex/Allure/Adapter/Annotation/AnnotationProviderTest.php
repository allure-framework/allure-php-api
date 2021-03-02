<?php

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationRegistry;
use PHPUnit\Framework\TestCase;

class AnnotationProviderTest extends TestCase
{
    private const TYPE_CLASS = 'class';
    private const TYPE_METHOD = 'method';
    private const METHOD_NAME = 'methodWithAnnotations';
    private const ALL_ANNOTATIONS_METHOD_NAME = 'methodWithAllAnnotations';
    private static $allAnnotations;

    public static function setUpBeforeClass(): void
    {
        AnnotationRegistry::registerFile(__DIR__ . '/Fixtures/TestAnnotation.php');
        $instance = new Fixtures\ClassWithAnnotations();
        self::$allAnnotations = AnnotationProvider::getMethodAnnotations($instance, self::ALL_ANNOTATIONS_METHOD_NAME);
    }

    protected function tearDown(): void
    {
        AnnotationProvider::tearDown();
    }

    public function testGetClassAnnotations(): void
    {
        $instance = new Fixtures\ClassWithAnnotations();
        $annotations = AnnotationProvider::getClassAnnotations($instance);
        $this->assertTrue(sizeof($annotations) === 1);
        $annotation = array_pop($annotations);
        $this->assertInstanceOf('Yandex\Allure\Adapter\Annotation\Fixtures\TestAnnotation', $annotation);
        $this->assertEquals(self::TYPE_CLASS, $annotation->value);
    }

    public function testGetMethodAnnotations(): void
    {
        $instance = new Fixtures\ClassWithAnnotations();
        $annotations = AnnotationProvider::getMethodAnnotations($instance, self::METHOD_NAME);
        $this->assertTrue(sizeof($annotations) === 1);
        $annotation = array_pop($annotations);
        $this->assertInstanceOf('Yandex\Allure\Adapter\Annotation\Fixtures\TestAnnotation', $annotation);
        $this->assertEquals(self::TYPE_METHOD, $annotation->value);
    }

    public function testShouldThrowExceptionForNotImportedAnnotations(): void
    {
        $instance = new Fixtures\ClassWithIgnoreAnnotation();
        $this->expectException(AnnotationException::class);
        AnnotationProvider::getClassAnnotations($instance);
    }

    public function testShouldIgnoreGivenAnnotations(): void
    {
        $instance = new Fixtures\ClassWithIgnoreAnnotation();
        AnnotationProvider::addIgnoredAnnotations(['SomeCustomClassAnnotation', 'SomeCustomMethodAnnotation']);

        $this->assertEmpty(AnnotationProvider::getClassAnnotations($instance));
        $this->assertEmpty(AnnotationProvider::getMethodAnnotations($instance, 'methodWithIgnoredAnnotation'));
    }

    public function annotationsDataProvider(): array
    {
        return [
            ['Yandex\Allure\Adapter\Annotation\AllureId', 'e7a8ff6cdd2908d4f50bee573708727085778061', 'value'],
            ['Yandex\Allure\Adapter\Annotation\Description', 'Use this page to register account', 'value'],
            ['Yandex\Allure\Adapter\Annotation\Epics', ['Make app more stable'], 'epicNames'],
            ['Yandex\Allure\Adapter\Annotation\Features', ['Multi-factor authentication'], 'featureNames'],
            ['Yandex\Allure\Adapter\Annotation\Issues', ['Can`t create user with numbers in login'], 'issueKeys'],
            ['Yandex\Allure\Adapter\Annotation\Label', ['master'], 'values'],
            ['Yandex\Allure\Adapter\Annotation\Parameter', 'John', 'value'],
            ['Yandex\Allure\Adapter\Annotation\Severity', 'Highest', 'level'],
            ['Yandex\Allure\Adapter\Annotation\Step', 'Open sign up page', 'value'],
            ['Yandex\Allure\Adapter\Annotation\Stories', ['User authentication'], 'stories'],
            ['Yandex\Allure\Adapter\Annotation\TestCaseId', ['testUserSignUp'], 'testCaseIds'],
            ['Yandex\Allure\Adapter\Annotation\TestType', 'screenshotDiff', 'type'],
            ['Yandex\Allure\Adapter\Annotation\Title', 'Sign Up', 'value'],
        ];
    }

    /**
     * @dataProvider annotationsDataProvider
     */
    public function testGetAllAnnotations(string $expectedClassName, $value, string $propertyName): void
    {
        $annotation = array_shift(self::$allAnnotations);
        $this->assertInstanceOf($expectedClassName, $annotation);
        $this->assertEquals($value, $annotation->$propertyName);
    }
}
