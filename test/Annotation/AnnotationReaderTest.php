<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use Doctrine\Common\Annotations\AnnotationReader as DoctrineReader;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionProperty;

use function array_map;

/**
 * @covers \Qameta\Allure\Annotation\AnnotationReader
 */
class AnnotationReaderTest extends TestCase
{

    protected mixed $demoNoAnnotations = null;

    #[NativePropertyAnnotation("a")]
    #[NativePropertyAnnotation("b")]
    protected mixed $demoOnlyNativeAnnotations = null;

    /**
     * @ConvertableLegacyPropertyAnnotation("a")
     * @ConvertableLegacyPropertyAnnotation("b")
     * @LegacyPropertyAnnotation("c")
     */
    protected mixed $demoOnlyLegacyAnnotations = null;

    /**
     * @ConvertableLegacyPropertyAnnotation("a")
     * @ConvertableLegacyPropertyAnnotation("b")
     * @LegacyPropertyAnnotation("c")
     */
    #[NativePropertyAnnotation("d")]
    #[NativePropertyAnnotation("e")]
    protected mixed $demoMixedAnnotations = null;

    /**
     * @throws ReflectionException
     */
    public function testGetPropertyAnnotations_NoAnnotations_ReturnsEmptyArray(): void
    {
        $reader = new AnnotationReader(new DoctrineReader());
        $annotations = $reader->getPropertyAnnotations(new ReflectionProperty($this, 'demoNoAnnotations'));
        self::assertEmpty($annotations);
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPropertyAnnotations_OnlyNativeAnnotations_ReturnsMatchingList(): void
    {
        $reader = new AnnotationReader(new DoctrineReader());
        $annotations = $reader->getPropertyAnnotations(new ReflectionProperty($this, 'demoOnlyNativeAnnotations'));
        $expectedList = [
            ['class' => NativePropertyAnnotation::class, 'value' => 'a'],
            ['class' => NativePropertyAnnotation::class, 'value' => 'b'],
        ];
        self::assertSame($expectedList, $this->exportAnnotations(...$annotations));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPropertyAnnotations_OnlyLegacyAnnotations_ReturnsMatchingList(): void
    {
        $reader = new AnnotationReader(new DoctrineReader());
        $annotations = $reader->getPropertyAnnotations(new ReflectionProperty($this, 'demoOnlyLegacyAnnotations'));
        $expectedList = [
            ['class' => ConvertableLegacyPropertyAnnotation::class, 'value' => 'b'],
            ['class' => LegacyPropertyAnnotation::class, 'value' => 'c'],
        ];
        self::assertSame($expectedList, $this->exportAnnotations(...$annotations));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPropertyAnnotations_MixedAnnotations_ReturnsMatchingList(): void
    {
        $reader = new AnnotationReader(new DoctrineReader());
        $annotations = $reader->getPropertyAnnotations(new ReflectionProperty($this, 'demoMixedAnnotations'));
        $expectedList = [
            ['class' => ConvertableLegacyPropertyAnnotation::class, 'value' => 'b'],
            ['class' => LegacyPropertyAnnotation::class, 'value' => 'c'],
            ['class' => NativePropertyAnnotation::class, 'value' => 'd'],
            ['class' => NativePropertyAnnotation::class, 'value' => 'e'],
        ];
        self::assertSame($expectedList, $this->exportAnnotations(...$annotations));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPropertyAnnotation_NoAnnotations_ReturnsNull(): void
    {
        $reader = new AnnotationReader(new DoctrineReader());
        $annotation = $reader->getPropertyAnnotation(
            new ReflectionProperty($this, 'demoNoAnnotations'),
            NativePropertyAnnotation::class,
        );
        self::assertNull($annotation);
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPropertyAnnotation_OnlyNativeAnnotations_ReturnsMatchingAnnotation(): void
    {
        $reader = new AnnotationReader(new DoctrineReader());
        $annotation = $reader->getPropertyAnnotation(
            new ReflectionProperty($this, 'demoOnlyNativeAnnotations'),
            NativePropertyAnnotation::class,
        );
        $expectedData = ['class' => NativePropertyAnnotation::class, 'value' => 'b'];
        self::assertSame($expectedData, $this->exportAnnotation($annotation));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPropertyAnnotation_OnlyLegacyAnnotations_ReturnsMatchingAnnotation(): void
    {
        $reader = new AnnotationReader(new DoctrineReader());
        $annotation = $reader->getPropertyAnnotation(
            new ReflectionProperty($this, 'demoOnlyLegacyAnnotations'),
            ConvertableLegacyPropertyAnnotation::class,
        );
        $expectedList = ['class' => ConvertableLegacyPropertyAnnotation::class, 'value' => 'a'];
        self::assertSame($expectedList, $this->exportAnnotation($annotation));
    }

    private function exportAnnotations(object ...$annotations): array
    {
        return array_map(
            fn (object $annotation) => $this->exportAnnotation($annotation),
            $annotations,
        );
    }

    private function exportAnnotation(object $annotation): array
    {
        $data = [
            'class' => $annotation::class,
        ];
        if ($annotation instanceof NativePropertyAnnotation) {
            $data['value'] = $annotation->getValue();
        }
        if ($annotation instanceof LegacyPropertyAnnotation) {
            $data['value'] = $annotation->value;
        }
        if ($annotation instanceof ConvertableLegacyPropertyAnnotation) {
            $data['value'] = $annotation->value;
        }

        return $data;
    }
}
