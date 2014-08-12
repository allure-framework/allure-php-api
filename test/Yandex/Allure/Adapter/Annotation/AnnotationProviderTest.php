<?php

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\AnnotationRegistry;

class AnnotationProviderTest extends \PHPUnit_Framework_TestCase
{
    const TYPE_CLASS = 'class';
    const TYPE_METHOD = 'method';
    const METHOD_NAME = 'methodWithAnnotations';

    public static function setUpBeforeClass()
    {
        AnnotationRegistry::registerFile(__DIR__ . '/Fixtures/TestAnnotation.php');
    }

    protected function tearDown()
    {
        AnnotationProvider::tearDown();
    }

    public function testGetClassAnnotations()
    {
        $instance = new Fixtures\ClassWithAnnotations();
        $annotations = AnnotationProvider::getClassAnnotations($instance);
        $this->assertTrue(sizeof($annotations) === 1);
        $annotation = array_pop($annotations);
        $this->assertInstanceOf('Yandex\Allure\Adapter\Annotation\Fixtures\TestAnnotation', $annotation);
        $this->assertEquals(self::TYPE_CLASS, $annotation->value);
    }

    public function testGetMethodAnnotations()
    {
        $instance = new Fixtures\ClassWithAnnotations();
        $annotations = AnnotationProvider::getMethodAnnotations($instance, self::METHOD_NAME);
        $this->assertTrue(sizeof($annotations) === 1);
        $annotation = array_pop($annotations);
        $this->assertInstanceOf('Yandex\Allure\Adapter\Annotation\Fixtures\TestAnnotation', $annotation);
        $this->assertEquals(self::TYPE_METHOD, $annotation->value);
    }

    /**
     * @expectedException \Doctrine\Common\Annotations\AnnotationException
     */
    public function testShouldThrowExceptionForNotImportedAnnotations()
    {
        $instance = new Fixtures\ClassWithIgnoreAnnotation();
        AnnotationProvider::getClassAnnotations($instance);
    }

    public function testShouldIgnoreGivenAnnotations()
    {
        $instance = new Fixtures\ClassWithIgnoreAnnotation();
        AnnotationProvider::addIgnoredAnnotations(['SomeCustomClassAnnotation', 'SomeCustomMethodAnnotation']);

        $this->assertEmpty(AnnotationProvider::getClassAnnotations($instance));
        $this->assertEmpty(AnnotationProvider::getMethodAnnotations($instance, 'methodWithIgnoredAnnotation'));
    }
}
