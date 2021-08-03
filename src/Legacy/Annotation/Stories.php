<?php

declare(strict_types=1);

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use Qameta\Allure\Annotation\Story as QametaStory;
use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;

use function array_map;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 * @deprecated Use native PHP attribute {@see \Qameta\Allure\Annotation\Story}
 * @psalm-suppress MissingConstructor
 */
class Stories implements LegacyAnnotationInterface
{
    /**
     * @var array
     * @psalm-var list<string>
     * @Required
     */
    public array $stories;

    public function getStories(): array
    {
        return $this->stories;
    }

    /**
     * @return list<QametaStory>
     */
    public function convert(): array
    {
        return array_map(
            fn (string $value) => new QametaStory($value),
            $this->stories,
        );
    }
}
