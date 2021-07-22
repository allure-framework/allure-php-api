<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class ConvertableLegacyPropertyAnnotation implements LegacyAnnotationInterface
{

    /**
     * @var string
     * @Required
     */
    public string $value;

    public function convert(): NativePropertyAnnotation
    {
        return new NativePropertyAnnotation($this->value);
    }
}
