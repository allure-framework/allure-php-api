<?php

declare(strict_types=1);

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use JetBrains\PhpStorm\Pure;
use Qameta\Allure\Annotation\Feature;
use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;

use function array_map;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 * @deprecated Use native PHP attribute {@see \Qameta\Allure\Annotation\Features}
 */
class Features implements LegacyAnnotationInterface
{
    /**
     * @var array
     * @Required
     */
    public array $featureNames;

    public function getFeatureNames(): array
    {
        return $this->featureNames;
    }

    /**
     * @return list<Feature>
     */
    #[Pure]
    public function convert(): array
    {
        return array_map(
            fn (string $name) => new Feature($name),
            $this->featureNames,
        );
    }
}
