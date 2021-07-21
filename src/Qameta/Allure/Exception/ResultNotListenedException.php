<?php

declare(strict_types=1);

namespace Qameta\Allure\Exception;

use Qameta\Allure\Listener\LifecycleListener;
use Qameta\Allure\Model\ResultType;
use Throwable;

final class ResultNotListenedException extends ResultException
{

    public function __construct(
        ResultType $resultType,
        private LifecycleListener $listener,
        ?Throwable $previous = null,
    ) {
        parent::__construct($resultType, $previous);
    }

    protected function buildMessage(): string
    {
        $listenerClass = $this->listener::class;

        return "{$this->buildResultName()} was not listened by {$listenerClass}";
    }

    public function getListener(): LifecycleListener
    {
        return $this->listener;
    }
}