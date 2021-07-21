<?php

declare(strict_types=1);

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use JetBrains\PhpStorm\Pure;
use Qameta\Allure\Annotation\Title as QametaTitle;
use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 * @deprecated Use native PHP attribute {@see \Qameta\Allure\Annotation\Title}
 */
class Title implements LegacyAnnotationInterface
{
    /**
     * @Required
     */
    public string $value;

    #[Pure]
    public function convert(): QametaTitle
    {
        return new QametaTitle($this->value);
    }
}
