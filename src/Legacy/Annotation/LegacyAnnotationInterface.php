<?php

declare(strict_types=1);

namespace Qameta\Allure\Legacy\Annotation;

interface LegacyAnnotationInterface
{

    /**
     * @return list<object>|object
     */
    public function convert(): array|object;
}
