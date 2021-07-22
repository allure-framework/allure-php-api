<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class LegacyPropertyAnnotation
{

    /**
     * @var string
     * @Required
     */
    public string $value;
}
