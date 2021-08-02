<?php

declare(strict_types=1);

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use JetBrains\PhpStorm\Pure;
use Qameta\Allure\Annotation\AllureId as QametaAllureId;
use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;

/**
 * @Annotation
 * @Target({"METHOD"})
 * @deprecated Use native PHP attribute {@see \Qameta\Allure\Annotation\AllureId}
 */
class AllureId implements LegacyAnnotationInterface
{
    /**
     * @var string
     * @Required
     */
    public string $value;

    #[Pure]
    public function convert(): QametaAllureId
    {
        return new QametaAllureId($this->value);
    }
}
