<?php

declare(strict_types=1);

namespace Qameta\Allure\Exception;

use JetBrains\PhpStorm\Pure;
use Qameta\Allure\Model\Attachment;
use RuntimeException;
use Throwable;

final class AttachmentNotAddedException extends RuntimeException
{

    #[Pure]
    public function __construct(
        private Attachment $attachment,
        ?Throwable $previous = null,
    ) {
        parent::__construct("Attachment {$this->buildAttachmentName()} was not written", 0, $previous);
    }

    #[Pure]
    private function buildAttachmentName(): string
    {
        $result = $this->attachment->getUuid();
        $name = $this->attachment->getName();
        if (isset($name)) {
            $result .= " ({$name})";
        }

        return $result;
    }

    public function getAttachment(): Attachment
    {
        return $this->attachment;
    }
}
