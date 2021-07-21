<?php

declare(strict_types=1);

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use Qameta\Allure\Annotation\Parameter as QametaParameter;
use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;

use function array_map;

/**
 * @Annotation
 * @Target({"METHOD"})
 * @deprecated Use native PHP attribute {@see \Qameta\Allure\Annotation\Parameter} (repeatable).
 */
class Parameters implements LegacyAnnotationInterface
{
    /**
     * @var array<\Yandex\Allure\Adapter\Annotation\Parameter>
     * @Required
     */
    public array $parameters;

    /**
     * @return list<QametaParameter>
     */
    public function convert(): array
    {
        return array_map(
            fn (Parameter $parameter) => $parameter->convert(),
            $this->parameters,
        );
    }
}
