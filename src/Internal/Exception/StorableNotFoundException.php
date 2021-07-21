<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal\Exception;

use JetBrains\PhpStorm\Pure;
use LogicException;
use Throwable;

abstract class StorableNotFoundException extends LogicException
{

    #[Pure]
    public function __construct(private string $uuid, ?Throwable $previous = null)
    {
        parent::__construct(
            $this->buildMessage(),
            0,
            $previous,
        );
    }

    #[Pure]
    abstract protected function buildMessage(): string;

    #[Pure]
    protected function buildStandardMessage(string $item, ?string $action = null): string
    {
        $action ??= 'is not found';

        return "{$item} with UUID {$this->uuid} {$action}";
    }

    #[Pure]
    final public function getUuid(): string
    {
        return $this->uuid;
    }
}
