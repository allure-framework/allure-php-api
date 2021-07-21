<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use Attribute;
use JetBrains\PhpStorm\Pure;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class Story extends AbstractLabel
{

    #[Pure]
    public function __construct(string $value)
    {
        parent::__construct(Label::STORY, $value);
    }
}
