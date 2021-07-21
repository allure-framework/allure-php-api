<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class Title extends AbstractTitle
{
}
