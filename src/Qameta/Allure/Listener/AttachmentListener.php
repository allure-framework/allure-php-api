<?php

declare(strict_types=1);

namespace Qameta\Allure\Listener;

use Qameta\Allure\Model\Attachment;

interface AttachmentListener
{

    public function beforeAttachmentWrite(Attachment $attachment): void;

    public function afterAttachmentWrite(Attachment $attachment): void;
}