<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use Doctrine\Common\Annotations\IndexedReader;
use Doctrine\Common\Annotations\Reader;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

use function array_map;
use function array_pop;
use function array_values;

final class AnnotationReader implements Reader
{

    private Reader $delegate;

    public function __construct(Reader $reader)
    {
        $this->delegate = new IndexedReader($reader);
    }

    /**
     * @param ReflectionAttribute ...$attributes
     * @return list<object>
     */
    private function getAttributeInstances(ReflectionAttribute ...$attributes): array
    {
        return array_map(
            fn (ReflectionAttribute $attribute) => $attribute->newInstance(),
            array_values($attributes),
        );
    }

    /**
     * @return list<object>
     */
    public function getClassAnnotations(ReflectionClass $class): array
    {
        return [
            ...array_values($this->delegate->getClassAnnotations($class)),
            ...$this->getAttributeInstances(...$class->getAttributes()),
        ];
    }

    /**
     * @template T
     * @param ReflectionClass $class
     * @param class-string<T>    $annotationName
     * @return T|null
     */
    public function getClassAnnotation(ReflectionClass $class, $annotationName)
    {
        $annotations = $this->getAttributeInstances(...$class->getAttributes($annotationName));
        $legacyAnnotation = $this->delegate->getClassAnnotation($class, $annotationName);
        if (isset($legacyAnnotation)) {
            $annotations = [$legacyAnnotation, ...$annotations];
        }

        $annotation = empty($annotations)
            ? null
            : array_pop($annotations);

        return $annotation instanceof $annotationName
            ? $annotation
            : null;
    }

    /**
     * @return list<object>
     */
    public function getMethodAnnotations(ReflectionMethod $method): array
    {
        return [
            ...array_values($this->delegate->getMethodAnnotations($method)),
            ...$this->getAttributeInstances(...$method->getAttributes()),
        ];
    }

    /**
     * @template T
     * @param ReflectionMethod $method
     * @param class-string<T> $annotationName
     * @return T|null
     */
    public function getMethodAnnotation(ReflectionMethod $method, $annotationName)
    {
        $annotations = $this->getAttributeInstances(...$method->getAttributes($annotationName));
        $legacyAnnotation = $this->delegate->getMethodAnnotation($method, $annotationName);
        if (isset($legacyAnnotation)) {
            $annotations = [$legacyAnnotation, ...$annotations];
        }

        $annotation = empty($annotations)
            ? null
            : array_pop($annotations);

        return $annotation instanceof $annotationName
            ? $annotation
            : null;
    }

    /**
     * @return list<object>
     */
    public function getPropertyAnnotations(ReflectionProperty $property): array
    {
        return [
            ...array_values($this->delegate->getPropertyAnnotations($property)),
            ...$this->getAttributeInstances(...$property->getAttributes()),
        ];
    }

    /**
     * @template T
     * @param ReflectionProperty $property
     * @param class-string<T>  $annotationName
     * @return T|null
     */
    public function getPropertyAnnotation(ReflectionProperty $property, $annotationName)
    {
        $annotations = $this->getAttributeInstances(...$property->getAttributes($annotationName));
        $legacyAnnotation = $this->delegate->getPropertyAnnotation($property, $annotationName);
        if (isset($legacyAnnotation)) {
            $annotations = [$legacyAnnotation, ...$annotations];
        }

        $annotation = empty($annotations)
            ? null
            : array_pop($annotations);

        return $annotation instanceof $annotationName
            ? $annotation
            : null;
    }
}
