<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Attachment;
use Yandex\Allure\Adapter\Model\AttachmentType;
use Yandex\Allure\Adapter\Model\Provider;
use Yandex\Allure\Adapter\Model\Step;

class AddAttachmentEventTest extends \PHPUnit_Framework_TestCase
{
    const ATTACHMENT_CAPTION = 'test-caption';

    public function testEventWithFile()
    {
        $attachmentCaption = self::ATTACHMENT_CAPTION;
        $attachmentType = AttachmentType::TXT;
        $tmpDirectory = sys_get_temp_dir();
        Provider::setOutputDirectory($tmpDirectory);
        $tmpFilename = tempnam($tmpDirectory, 'allure-test');
        file_put_contents($tmpFilename, $this->getTestContents());
        $sha1_sum = sha1_file($tmpFilename);

        $event = new AddAttachmentEvent($tmpFilename, $attachmentCaption, $attachmentType);
        $step = new Step();
        $event->process($step);

        $attachmentFileName = $event->getOutputFileName($sha1_sum, $attachmentType);
        $attachmentOutputPath = $event->getOutputPath($sha1_sum, $attachmentType);
        $this->checkAttachmentIsCorrect(
            $step,
            $attachmentOutputPath,
            $attachmentFileName,
            $attachmentCaption,
            $attachmentType,
            true
        );
    }

    public function testEventWithStringContents()
    {
        $attachmentCaption = self::ATTACHMENT_CAPTION;
        $attachmentType = AttachmentType::JSON;
        $tmpDirectory = sys_get_temp_dir();
        Provider::setOutputDirectory($tmpDirectory);
        $contents = $this->getTestContents();
        $sha1_sum = sha1($contents);

        $event = new AddAttachmentEvent($contents, $attachmentCaption, $attachmentType);
        $step = new Step();
        $event->process($step);

        $attachmentFileName = $event->getOutputFileName($sha1_sum, $attachmentType);
        $attachmentOutputPath = $event->getOutputPath($sha1_sum, $attachmentType);
        $this->checkAttachmentIsCorrect(
            $step,
            $attachmentOutputPath,
            $attachmentFileName,
            $attachmentCaption,
            $attachmentType,
            true
        );
    }

    public function testEventWithUrl()
    {
        $attachmentCaption = self::ATTACHMENT_CAPTION;
        $attachmentType = AttachmentType::OTHER;
        $attachmentUrl = 'some-url';

        $event = new AddAttachmentEvent($attachmentUrl, $attachmentCaption, $attachmentType);
        $step = new Step();
        $event->process($step);

        $this->checkAttachmentIsCorrect($step, '', $attachmentUrl, $attachmentCaption, $attachmentType);
    }

    private function checkAttachmentIsCorrect(
        Step $step,
        $attachmentOutputPath,
        $attachmentFileName,
        $attachmentCaption,
        $attachmentType,
        $checkIfFileExists = false
    ) {
        if ($checkIfFileExists) {
            $this->assertTrue(file_exists($attachmentOutputPath));
        }
        $attachments = $step->getAttachments();
        $this->assertEquals(1, sizeof($attachments));
        $attachment = array_pop($attachments);
        $this->assertTrue(
            ($attachment instanceof Attachment) &&
            ($attachment->getSource() === $attachmentFileName) &&
            ($attachment->getTitle() === $attachmentCaption) &&
            ($attachment->getType() === $attachmentType)
        );
    }

    private function getTestContents()
    {
        return str_shuffle('test-contents');
    }
}
