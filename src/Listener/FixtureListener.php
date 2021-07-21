<?php

declare(strict_types=1);

namespace Qameta\Allure\Listener;

use Qameta\Allure\Model\FixtureResult;

interface FixtureListener extends LifecycleListener
{

    public function beforeFixtureStart(FixtureResult $fixture): void;

    public function afterFixtureStart(FixtureResult $fixture): void;

    public function beforeFixtureUpdate(FixtureResult $fixture): void;

    public function afterFixtureUpdate(FixtureResult $fixture): void;

    public function beforeFixtureStop(FixtureResult $fixture): void;

    public function afterFixtureStop(FixtureResult $fixture): void;
}
