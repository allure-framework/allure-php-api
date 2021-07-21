<?php

declare(strict_types=1);

namespace Qameta\Allure\Exception;

use LogicException;
use Throwable;

final class OutputDirectorySetFailureException extends LogicException
{

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(
            "Output directory cannot be set: Allure lifecycle has already started",
            0,
            $previous,
        );
    }
}