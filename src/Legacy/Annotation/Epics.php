<?php

declare(strict_types=1);

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use JetBrains\PhpStorm\Pure;
use Qameta\Allure\Annotation\Epic;
use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;

use function array_map;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 * @deprecated Use native PHP attribute {@see \Qameta\Allure\Annotation\Epics}
 */
class Epics implements LegacyAnnotationInterface
{
    /**
     * @var array<string>
     * @Required
     */
    public array $epicNames;

    /**
     * @return list<string>
     */
    public function getEpicNames(): array
    {
        return $this->epicNames;
    }

    /**
     * @return list<Epic>
     */
    #[Pure]
    public function convert(): array
    {
        return array_map(
            fn (string $name) => new Epic($name),
            $this->epicNames,
        );
    }
}
