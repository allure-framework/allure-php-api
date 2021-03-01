<?php

namespace Qameta\Allure\Model;

/**
 * Interface AttachmentsAware
 * @package Qameta\Allure\Model
 */
interface AttachmentsAware
{
    /**
     * @return array<Attachment>
     */
    public function getAttachments();
}
