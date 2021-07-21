<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

interface LinkTemplateInterface
{
   
    public function buildUrl(?string $name): ?string;
}
