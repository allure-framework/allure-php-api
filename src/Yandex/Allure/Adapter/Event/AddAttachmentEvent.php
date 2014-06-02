<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Event\Event;
use Yandex\Allure\Adapter\Model\Attachment;
use Yandex\Allure\Adapter\Model\Entity;
use Yandex\Allure\Adapter\Model\Provider;
use Yandex\Allure\Adapter\Model\Step;
use Yandex\Allure\Adapter\Model\AttachmentType;
use Yandex\Allure\Adapter\AllureException;

class AddAttachmentEvent implements Event {

    private $filePathOrContents;
    
    private $caption;
    
    private $type;

    function __construct($filePathOrContents, $caption, $type)
    {
        $this->filePathOrContents = $filePathOrContents;
        $this->caption = $caption;
        $this->type = $type;
    }

    function process(Entity $context)
    {
        if ($context instanceof Step){
            $newFileName = self::getAttachmentFileName($this->filePathOrContents, $this->type);
            $attachment = new Attachment($this->caption, $newFileName, $this->type);
            $context->addAttachment($attachment);
        }
    }

    private static function getAttachmentFileName($filePathOrContents, $type)
    {
        if ($type == AttachmentType::OTHER) {
            //Type = other is mainly for attached URLs
            return $filePathOrContents;
        } else if (file_exists($filePathOrContents)) {
            //Trying to attach some file outputted by method
            $fileSha1 = sha1_file($filePathOrContents);
            $outputPath = self::getOutputPath($fileSha1, $type);
            if (!file_exists($outputPath) && !copy($filePathOrContents, $outputPath)) {
                throw new AllureException("Failed to copy attachment from $filePathOrContents to $outputPath.");
            }
            return self::getOutputPath($fileSha1, $type);
        } else {
            //Trying to attach string content outputted by method
            $contentsSha1 = sha1($filePathOrContents);
            $outputPath = self::getOutputPath($contentsSha1, $type);
            if (!file_exists($outputPath) && !file_put_contents($outputPath, $filePathOrContents)) {
                throw new AllureException("Failed to save file data to $outputPath.");
            }
            return self::getOutputFileName($contentsSha1, $type);
        }
    }

    private static function getOutputFileName($sha1, $type)
    {
        return $sha1 . '-attachment.' . $type;
    }

    private static function getOutputPath($sha1, $type)
    {
        return Provider::getOutputDirectory() . DIRECTORY_SEPARATOR . self::getOutputFileName($sha1, $type);
    }

} 