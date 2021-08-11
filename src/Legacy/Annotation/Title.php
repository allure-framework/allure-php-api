<?php

declare(strict_types=1);

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use Qameta\Allure\Attribute\Title as QametaTitle;
use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 * @deprecated Use native PHP attribute {@see \Qameta\Allure\Attribute\Title}
 * @psalm-suppress MissingConstructor
 */
class Title implements LegacyAnnotationInterface
{
    /**
     * @Required
     */
    public string $value;

    public function convert(): QametaTitle
    {
        return new QametaTitle($this->value);
    }
}
