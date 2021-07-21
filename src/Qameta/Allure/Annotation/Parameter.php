<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Parameter extends AbstractParameter
{
}
