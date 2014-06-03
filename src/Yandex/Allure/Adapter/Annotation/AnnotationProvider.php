<?php

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\IndexedReader;

AnnotationRegistry::registerAutoloadNamespace(
    'JMS\Serializer\Annotation',
    __DIR__ . "/../../../../../../../../vendor/jms/serializer/src"
);

AnnotationRegistry::registerAutoloadNamespace(
    'Yandex\Allure\Adapter\Annotation',
    __DIR__ . "/../../../../../src"
);

class AnnotationProvider
{

    /**
     * @var AnnotationReader
     */
    private static $annotationsReader;

    /**
     * Returns a list of class annotations
     * @param $instance
     * @return array
     */
    public static function getClassAnnotations($instance)
    {
        $ref = new \ReflectionClass($instance);
        return self::getAnnotationsReader()->getClassAnnotations($ref);
    }

    /**
     * Returns a list of method annotations
     * @param $instance
     * @param $methodName
     * @return array
     */
    public static function getMethodAnnotations($instance, $methodName)
    {
        $ref = new \ReflectionMethod($instance, $methodName);
        return self::getAnnotationsReader()->getMethodAnnotations($ref);
    }

    /**
     * @return IndexedReader
     */
    private static function getAnnotationsReader()
    {
        if (!isset(self::$annotationsReader)) {
            self::$annotationsReader = new IndexedReader(new AnnotationReader());
        }
        return self::$annotationsReader;
    }

}