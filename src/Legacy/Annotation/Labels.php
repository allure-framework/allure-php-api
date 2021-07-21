<?php

declare(strict_types=1);

namespace Yandex\Allure\Adapter\Annotation;

use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;

use function array_map;
use function array_merge;

/**
 * @Annotation
 * @Target({"METHOD"})
 * @deprecated Use native PHP attribute {@see \Qameta\Allure\Annotation\Label} (repeatable).
 */
class Labels implements LegacyAnnotationInterface
{
    /**
     * @var array<\Yandex\Allure\Adapter\Annotation\Label>
     * @Required
     */
    public array $labels;

    public function convert(): array
    {
        return array_merge(
            ...array_map(
                fn (Label $label) => $label->convert(),
                $this->labels,
            ),
        );
    }
}
