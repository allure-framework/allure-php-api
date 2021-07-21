<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use Doctrine\Common\Annotations\IndexedReader;
use Doctrine\Common\Annotations\Reader;
use JetBrains\PhpStorm\Pure;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

use function array_map;
use function array_pop;

final class AnnotationReader implements Reader
{

    private Reader $delegate;

    #[Pure]
    public function __construct(
        Reader $reader,
    ) {
        $this->delegate = new IndexedReader($reader);
    }

    private function getAttributeInstances(ReflectionAttribute ...$attributes): array
    {
        return array_map(
            fn (ReflectionAttribute $attribute) => $attribute->newInstance(),
            $attributes,
        );
    }

    public function getClassAnnotations(ReflectionClass $class): array
    {
        return [
            ...$this->delegate->getClassAnnotations($class),
            ...$this->getAttributeInstances(...$class->getAttributes()),
        ];
    }

    public function getClassAnnotation(ReflectionClass $class, $annotationName): ?object
    {
        $annotations = [
            ...(array) $this->delegate->getClassAnnotation($class, $annotationName),
            ...$this->getAttributeInstances(...$class->getAttributes($annotationName)),
        ];

        return array_pop($annotations);
    }

    public function getMethodAnnotations(ReflectionMethod $method): array
    {
        return [
            ...$this->delegate->getMethodAnnotations($method),
            ...$this->getAttributeInstances(...$method->getAttributes()),
        ];
    }

    public function getMethodAnnotation(ReflectionMethod $method, $annotationName)
    {
        $annotations = [
            ...(array) $this->delegate->getMethodAnnotation($method, $annotationName),
            ...$this->getAttributeInstances(...$method->getAttributes($annotationName)),
        ];

        return array_pop($annotations);
    }

    public function getPropertyAnnotations(ReflectionProperty $property): array
    {
        return [
            ...$this->delegate->getPropertyAnnotations($property),
            ...$this->getAttributeInstances(...$property->getAttributes()),
        ];
    }

    public function getPropertyAnnotation(ReflectionProperty $property, $annotationName)
    {
        $annotations = [
            ...(array) $this->delegate->getPropertyAnnotation($property, $annotationName),
            ...$this->getAttributeInstances(...$property->getAttributes($annotationName)),
        ];

        return array_pop($annotations);
    }
}
