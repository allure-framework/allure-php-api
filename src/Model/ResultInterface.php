<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

interface ResultInterface
{

    public function getResultType(): ResultType;
}
