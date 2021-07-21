<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

interface Result
{

    public function getResultType(): ResultType;
}
