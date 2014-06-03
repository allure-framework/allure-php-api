<?php

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;

class AnnotationProviderTest extends \PHPUnit_Framework_TestCase {
    
    public function testGetClassAnnotations()
    {
        $instance = new ClassWithAnnotations();
        $annotations = AnnotationProvider::getClassAnnotations($instance);
        $this->assertTrue(sizeof($annotations) === 1);
        $annotation = array_pop($annotations);
        $this->assertTrue($annotation instanceof TestAnnotation);
        $this->assertEquals('class', $annotation->value);
    }
    
    public function testGetMethodAnnotations()
    {
        $instance = new ClassWithAnnotations();
        $annotations = AnnotationProvider::getMethodAnnotations($instance, 'methodWithAnnotations');
        $this->assertTrue(sizeof($annotations) === 1);
        $annotation = array_pop($annotations);
        $this->assertTrue($annotation instanceof TestAnnotation);
        $this->assertEquals('method', $annotation->value);
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