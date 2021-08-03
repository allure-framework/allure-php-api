<?php

declare(strict_types=1);

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use Qameta\Allure\Annotation\Parameter as QametaParameter;
use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;
use Yandex\Allure\Adapter\Model\ParameterKind;

/**
 * @Annotation
 * @Target({"METHOD", "ANNOTATION"})
 * @deprecated Use native PHP attribute {@see \Qameta\Allure\Annotation\Parameter}
 * @psalm-suppress MissingConstructor
 */
class Parameter implements LegacyAnnotationInterface
{
    /**
     * @Required
     */
    public string $name;

    /**
     * @Required
     */
    public string $value;

    public string $kind = ParameterKind::ARGUMENT;

    public function convert(): QametaParameter
    {
        return new QametaParameter($this->name, $this->value);
    }
}
