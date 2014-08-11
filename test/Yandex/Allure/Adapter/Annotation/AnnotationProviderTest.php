<?php

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\AnnotationRegistry;

class AnnotationProviderTest extends \PHPUnit_Framework_TestCase
{
    const TYPE_CLASS = 'class';
    const TYPE_METHOD = 'method';
    const ANNOTATION_NAME = 'TestAnnotation';
    const METHOD_NAME = 'methodWithAnnotations';

    public static function setUpBeforeClass()
    {
        AnnotationRegistry::registerFile(__DIR__ . '/Fixtures/TestAnnotation.php');
    }

    public function testGetClassAnnotations()
    {
        //new TestAnnotation();
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

    public function testIgnoreAnnotations()
    {
        $instance = new Fixtures\ClassWithAnnotations();
        AnnotationProvider::addIgnoredAnnotations([self::ANNOTATION_NAME]);
        $this->assertEmpty(AnnotationProvider::getClassAnnotations($instance));
        $this->assertEmpty(AnnotationProvider::getMethodAnnotations($instance, self::METHOD_NAME));
    }
}
