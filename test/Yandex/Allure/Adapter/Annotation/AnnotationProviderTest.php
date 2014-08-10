<?php

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;

const TYPE_CLASS = 'class';
const TYPE_METHOD = 'method';
const ANNOTATION_NAME = 'TestAnnotation';
const METHOD_NAME = 'methodWithAnnotations';

class AnnotationProviderTest extends \PHPUnit_Framework_TestCase {
    
    public function testGetClassAnnotations()
    {
        $instance = new ClassWithAnnotations();
        $annotations = AnnotationProvider::getClassAnnotations($instance);
        $this->assertTrue(sizeof($annotations) === 1);
        $annotation = array_pop($annotations);
        $this->assertTrue($annotation instanceof TestAnnotation);
        $this->assertEquals(TYPE_CLASS, $annotation->value);
    }
    
    public function testGetMethodAnnotations()
    {
        $instance = new ClassWithAnnotations();
        $annotations = AnnotationProvider::getMethodAnnotations($instance, METHOD_NAME);
        $this->assertTrue(sizeof($annotations) === 1);
        $annotation = array_pop($annotations);
        $this->assertTrue($annotation instanceof TestAnnotation);
        $this->assertEquals(TYPE_METHOD, $annotation->value);
    }

    public function testIgnoreAnnotations()
    {
        $instance = new ClassWithAnnotations();
        AnnotationProvider::addIgnoredAnnotations([ANNOTATION_NAME]);
        $this->assertEmpty(AnnotationProvider::getClassAnnotations($instance));
        $this->assertEmpty(AnnotationProvider::getMethodAnnotations($instance, METHOD_NAME));
    }

}

/**
 * @TestAnnotation("class")
 */
class ClassWithAnnotations {
    
    /**
     * @TestAnnotation("method")
     */
    public function methodWithAnnotations(){}
}

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class TestAnnotation
{
    /**
     * @var string
     * @Required
     */
    public $value;
}