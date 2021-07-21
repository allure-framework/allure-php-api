<?php

declare(strict_types=1);

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use JetBrains\PhpStorm\Pure;
use Qameta\Allure\Annotation\Label as QametaLabel;
use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;

use function array_map;

/**
 * @Annotation
 * @Target({"METHOD", "ANNOTATION"})
 * @deprecated Use native PHP attribute {@see \Qameta\Allure\Annotation\Label}
 */
class Label implements LegacyAnnotationInterface
{
    /**
     * @Required
     */
    public string $name;

    /**
     * @var array
     * @Required
     */
    public array $values;

    #[Pure]
    public function convert(): array
    {
        return array_map(
            fn (string $value) => new QametaLabel($this->name, $value),
            $this->values,
        );
    }
}
