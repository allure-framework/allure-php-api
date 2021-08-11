<?php

declare(strict_types=1);

namespace Qameta\Allure\Attribute;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionProperty;

use function array_filter;
use function array_map;
use function array_values;
use function class_exists;
use function is_a;

final class AttributeReader implements AttributeReaderInterface
{

    /**
     * @param ReflectionClass $class
     * @param class-string|null     $name
     * @return list<AttributeInterface>
     */
    public function getClassAnnotations(ReflectionClass $class, ?string $name = null): array
    {
        return $this->getAttributeInstances(...$class->getAttributes($name));
    }

    /**
     * @param ReflectionMethod $method
     * @param class-string|null      $name
     * @return list<AttributeInterface>
     */
    public function getMethodAnnotations(ReflectionMethod $method, ?string $name = null): array
    {
        return $this->getAttributeInstances(...$method->getAttributes($name));
    }

    /**
     * @param ReflectionProperty $property
     * @param class-string|null        $name
     * @return list<AttributeInterface>
     */
    public function getPropertyAnnotations(ReflectionProperty $property, ?string $name = null): array
    {
        return $this->getAttributeInstances(...$property->getAttributes($name));
    }

    /**
     * @param ReflectionFunction $function
     * @param class-string|null        $name
     * @return list<AttributeInterface>
     */
    public function getFunctionAnnotations(ReflectionFunction $function, ?string $name = null): array
    {
        return $this->getAttributeInstances(...$function->getAttributes($name));
    }

    /**
     * @param ReflectionAttribute ...$attributes
     * @return list<AttributeInterface>
     */
    private function getAttributeInstances(ReflectionAttribute ...$attributes): array
    {
        /** @var array<ReflectionAttribute<AttributeInterface>> $filteredAttributes */
        $filteredAttributes = array_filter(
            $attributes,
            fn (ReflectionAttribute $attribute): bool =>
                class_exists($attribute->getName()) &&
                is_a($attribute->getName(), AttributeInterface::class, true),
        );

        return array_map(
            fn (ReflectionAttribute $attribute): AttributeInterface => $attribute->newInstance(),
            array_values($filteredAttributes),
        );
    }
}
