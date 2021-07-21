<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class TestCaseId extends AbstractLabel
{

    public function __construct(string $value)
    {
        parent::__construct(Label::TEST_ID, $value);
    }
}
