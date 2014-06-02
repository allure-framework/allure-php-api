<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Event\Event;
use Yandex\Allure\Adapter\Model\Attachment;
use Yandex\Allure\Adapter\Model\Entity;
use Yandex\Allure\Adapter\Model\Provider;
use Yandex\Allure\Adapter\Model\Step;
use Yandex\Allure\Adapter\Model\AttachmentType;
use Yandex\Allure\Adapter\AllureException;

class RemoveAttachmentEvent implements Event {

    private $pattern;

    function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    function process(Entity $context)
    {
        if ($context instanceof Step){
            $attachments = $context->getAttachments();
            foreach ($attachments as $key => $attachment){
                if ($attachment instanceof Attachment){
                    $path = $attachment->getSource();
                    if (file_exists($path) && is_writable($path)){
                        unlink($path);
                        unset($attachments[$key]);
                    }
                }
            }
        }
    }

} 