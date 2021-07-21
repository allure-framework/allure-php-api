<?php

declare(strict_types=1);

namespace Qameta\Allure\Exception;

use RuntimeException;
use Throwable;

final class AttachmentNotAddedException extends RuntimeException
{

    public function __construct(
        private string $name,
        ?Throwable $previous = null,
    ) {
        parent::__construct("Attachment {$this->name} was not written", 0, $previous);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
