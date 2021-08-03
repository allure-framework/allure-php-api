<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 * @psalm-suppress MissingConstructor
 */
final class LegacyPropertyAnnotation
{

    /**
     * @var string
     * @Required
     */
    public string $value;
}
