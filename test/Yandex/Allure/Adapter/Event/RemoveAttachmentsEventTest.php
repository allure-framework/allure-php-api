<?php

namespace Yandex\Allure\Adapter\Event;


use Yandex\Allure\Adapter\Model\Attachment;
use Yandex\Allure\Adapter\Model\AttachmentType;
use Yandex\Allure\Adapter\Model\Step;

class RemoveAttachmentsEventTest extends \PHPUnit_Framework_TestCase {
    
    public function testLifecycle()
    {
        $attachmentTitle = 'some-title';
        $pattern = 'matching';
        $tmpDirectory = sys_get_temp_dir();
        $matchingFilename = tempnam($tmpDirectory, $pattern);
        touch($matchingFilename);
        $this->assertTrue(file_exists($matchingFilename));
        
        $notMatchingFilename = tempnam($tmpDirectory, 'excluded');

        $step = new Step();
        $step->addAttachment(new Attachment($attachmentTitle, $matchingFilename, AttachmentType::TXT));
        $step->addAttachment(new Attachment($attachmentTitle, $notMatchingFilename, AttachmentType::TXT));
        
        $this->assertEquals(2, sizeof($step->getAttachments()));
        
        $event = new RemoveAttachmentsEvent("/$pattern/i");
        $event->process($step);
        
        $this->assertEquals(1, sizeof($step->getAttachments()));
        $this->assertFalse(file_exists($matchingFilename));
        $attachments = $step->getAttachments();
        $attachment = array_pop($attachments);
        $this->assertTrue(
            ($attachment instanceof Attachment) &&
            ($attachment->getSource() === $notMatchingFilename)
        );
    }
} 