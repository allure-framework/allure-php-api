<?php

namespace Qameta\Allure\Model;

interface AttachmentsAwareInterface
{
    /**
     * @return list<Attachment>
     */
    public function getAttachments(): array;

    public function addAttachments(Attachment ...$attachments): static;

    public function setAttachments(Attachment ...$attachments): static;
}
