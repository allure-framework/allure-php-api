<?php

declare(strict_types=1);

namespace Qameta\Allure;

interface StreamFactory
{

    /**
     * @return resource
     */
    public function createStream();
}
