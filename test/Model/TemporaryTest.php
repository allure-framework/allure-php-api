<?php

namespace Qameta\Allure\Model;

use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Qameta\Allure\Allure;
use Qameta\Allure\AllureFactory;
use Qameta\Allure\Annotation\Title;
use Qameta\Allure\ClockInterface;
use Qameta\Allure\StepContextInterface;
use RuntimeException;

class TemporaryTest extends TestCase
{

    public static function setUpBeforeClass(): void
    {
        Allure::setOutputDirectory(__DIR__ . '/../../../../build/allure');
    }

    public function testLifecycle(): void
    {
        $this->expectNotToPerformAssertions();
        $factory = new AllureFactory();

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->method('error')
            ->willReturnCallback(
                fn (string $message) => throw new RuntimeException($message),
            );
        $factory->setLogger($logger);

        $clock = $this->createMock(ClockInterface::class);
        $time = new DateTime('@0');
        $clock
            ->method('now')
            ->willReturnCallback(
                fn (): DateTimeImmutable => DateTimeImmutable::createFromMutable(
                    $time->modify('+1 second')->modify('+1 millisecond'),
                ),
            );
        $factory->setClock($clock);
        $resultFactory = $factory->getResultFactory();

        Allure::setFactory($factory);
        Allure::cleanOutputDirectory();
        $lifecycle = Allure::getLifecycle();
        $container = $resultFactory->createContainer();
        $lifecycle->startTestContainer($container);

        $setupFixture = $resultFactory
            ->createFixture()
            ->setName('Setup fixture')
            ->setStatus(Status::failed());
        $lifecycle->startSetUpFixture($container->getUuid(), $setupFixture);
        $lifecycle->stopFixture($setupFixture->getUuid());
        $test = $resultFactory
            ->createTest()
            ->setHistoryId('history-id')
            ->setTestCaseId('C123')
            ->setName('Test name')
            ->setFullName('Full test name')
            ->setStatus(Status::failed())
            ->setStatusDetails(
                (new StatusDetails())
                    ->makeFlaky(true)
                    ->makeKnown(true)
                    ->makeMuted(false)
                    ->setMessage('Test status details message')
                    ->setTrace('Test status details trace')
            )
            ->addLabels(
                Label::id('allure-id'),
                Label::thread('Thread label'),
                Label::testMethod('testMethod'),
            );
        $lifecycle->scheduleTestCase($test, $container->getUuid());
        $lifecycle->startTestCase($test->getUuid());

        Allure::owner('Owner label');
        Allure::lead('Lead label');
        Allure::label('Label name', 'Label value');
        Allure::host('Host label');
        Allure::severity(Severity::critical());
        Allure::parameter('Test param1 name', 'Test param1 value');
        Allure::parameter('Test param2 name');
        Allure::suite('Suite label');
        Allure::parentSuite('Parent suite label');
        Allure::subSuite('Sub-suite label');
        Allure::tag('Tag label');
        Allure::package('Package label');
        Allure::framework('Framework label');
        Allure::language('Language label');
        Allure::epic('Epic label');
        Allure::feature('Feature label');
        Allure::feature('Another feature label');
        Allure::story('Story label');
        Allure::issue('Issue', 'https://example.com');
        Allure::tms('TMS', 'https://example.com');
        Allure::link('Custom', 'https://example.com');
        Allure::description('Test description');
        Allure::descriptionHtml('<a href="#">Test HTML description</a>');
        Allure::attachmentFile('Attachment1 name', __FILE__);
        Allure::attachmentFile('Attachment2 name', __FILE__, 'text/plain', 'txt');

        Allure::runStep(
            #[Title("xxx")]
            function (StepContextInterface $step): void {
                $step->parameter('Step 1 param', 'xxx');
                Allure::descriptionHtml('<a href="#">Step HTML description</a>');
                Allure::attachment(
                    'Attachment3 name',
                    'foo',
                    'text/plain',
                    'txt',
                );
            },
            'Step 1 name',
        );

        $secondStep = $resultFactory
            ->createStep()
            ->setName('Step 2 name')
            ->setStatus(Status::passed())
            ->setDescriptionHtml('<a href="#">Step description</a>')
            ->setParameters(
                (new Parameter('Step parameter'))->setValue('Step parameter value'),
            );
        $lifecycle->startStep($secondStep);
        $nestedStep = $resultFactory
            ->createStep()
            ->setName('Nested step')
            ->setStatus(Status::skipped())
            ->setParameters(
                (new Parameter('Nested step parameter'))->setValue('value'),
            );
        $lifecycle->startStep($nestedStep);
        $lifecycle->stopStep($nestedStep->getUuid());
        $lifecycle->stopStep($secondStep->getUuid());
        $lifecycle->stopTestCase($test->getUuid());
        $lifecycle->writeTestCase($test->getUuid());
        $lifecycle->stopTestContainer($container->getUuid());
        $lifecycle->writeTestContainer($container->getUuid());
    }
}
