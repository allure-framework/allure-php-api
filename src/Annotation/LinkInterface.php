<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

interface LinkInterface
{

    public function getName(): ?string;

    public function getUrl(): ?string;

    public function getType(): ?string;
}
