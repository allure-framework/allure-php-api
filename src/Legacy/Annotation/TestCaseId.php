<?php

declare(strict_types=1);

namespace Yandex\Allure\Adapter\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use Qameta\Allure\Annotation\TestCaseId as QametaTestCaseId;
use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;

use function array_map;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 * @deprecated Use native PHP attribute {@see \Qameta\Allure\Annotation\TestCaseId}
 * @psalm-suppress MissingConstructor
 */
class TestCaseId implements LegacyAnnotationInterface
{
    /**
     * @var array
     * @psalm-var list<string>
     * @Required
     */
    public array $testCaseIds;

    public function getTestCaseIds(): array
    {
        return $this->testCaseIds;
    }

    /**
     * @return list<QametaTestCaseId>
     */
    public function convert(): array
    {
        return array_map(
            fn (string $id) => new QametaTestCaseId($id),
            $this->testCaseIds,
        );
    }
}
