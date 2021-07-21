<?php

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;

/**
 * Interface AttachmentsAware
 *
 * @package Qameta\Allure\Model
 */
interface AttachmentsAware
{
    /**
     * @return list<Attachment>
     */
    #[Pure]
    public function getAttachments(): array;

    public function addAttachments(Attachment ...$attachments): static;

    public function setAttachments(Attachment ...$attachments): static;
}
