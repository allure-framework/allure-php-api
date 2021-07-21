<?php

declare(strict_types=1);

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use JetBrains\PhpStorm\Pure;
use Qameta\Allure\Annotation\Description as QametaDescription;
use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;
use Yandex\Allure\Adapter\Model\DescriptionType;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 * @deprecated Use native PHP attribute {@see \Qameta\Allure\Annotation\Description}
 */
class Description implements LegacyAnnotationInterface
{
    /**
     * @var string
     * @Required
     */
    public string $value;

    /**
     * @var string
     */
    public string $type = DescriptionType::TEXT;

    #[Pure]
    public function convert(): QametaDescription
    {
        return new QametaDescription(
            $this->value,
            DescriptionType::HTML == $this->type,
        );
    }
}
