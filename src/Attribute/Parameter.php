<?php

declare(strict_types=1);

namespace Qameta\Allure\Attribute;

use Attribute;
use JetBrains\PhpStorm\ExpectedValues;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION | Attribute::IS_REPEATABLE)]
class Parameter extends AbstractParameter
{

    public function __construct(
        string $name,
        ?string $value,
        ?bool $excluded = null,
        #[ExpectedValues(flagsFromClass: ParameterMode::class)]
        ?string $mode = null,
    ) {
        parent::__construct($name, $value, $excluded, $mode);
    }
}
