<?php

declare(strict_types=1);

namespace Qameta\Allure;

interface StreamFactoryInterface
{

    /**
     * @return resource
     */
    public function createStream();
}
