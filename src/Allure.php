<?php

declare(strict_types=1);

namespace Qameta\Allure;

use Exception as SystemException;
use Qameta\Allure\Exception\OutputDirectorySetFailureException;
use Qameta\Allure\Internal\DefaultStepContext;
use Qameta\Allure\Model\Label;
use Qameta\Allure\Model\Link;
use Qameta\Allure\Model\LinkType;
use Qameta\Allure\Model\Parameter;
use Qameta\Allure\Model\Severity;
use Qameta\Allure\Model\Status;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\TestResult;
use Throwable;

final class Allure
{

    private const DEFAULT_STEP_NAME = 'step';

    private static ?self $instance = null;

    private ?AllureFactoryInterface $factory = null;

    private ?string $outputDirectory = null;

    private ?AllureLifecycleInterface $lifecycle = null;

    private string $defaultStepName = self::DEFAULT_STEP_NAME;

    private ?ResultFactoryInterface $resultFactory = null;

    private ?AllureResultsWriterInterface $resultsWriter = null;

    private function __construct()
    {
    }

    public static function setOutputDirectory(string $outputDirectory): void
    {
        self::getInstance()->doSetOutputDirectory($outputDirectory);
    }

    /**
     * Adds passed step with provided name and status in current test or step (or test fixture). Takes no effect
     * if no test run at the moment.
     *
     * @param string      $name
     * @param Status|null $status Sets passed status by default.
     * @throws SystemException
     */
    public static function addStep(string $name, ?Status $status = null): void
    {
        self::getInstance()->doAddStep($name, $status);
    }

    /**
     * Runs provided callable as step with given name, if any, or default name that can be modified
     * using {@see setDefaultStepName()} method. On success returns callable result, or null on failure.
     *
     * @param callable(StepContextInterface):mixed $callable
     * @param string|null $name
     * @return mixed
     * @throws SystemException
     */
    public static function runStep(callable $callable, ?string $name = null): mixed
    {
        return self::getInstance()->doRunStep($callable, $name);
    }

    public static function attachment(
        string $name,
        string $content,
        ?string $type = null,
        ?string $fileExtension = null
    ): void {
        $attachment = self::getInstance()
            ->getResultFactory()
            ->createAttachment()
            ->setName($name)
            ->setType($type)
            ->setFileExtension($fileExtension);
        self::getLifecycle()->addAttachment(
            $attachment,
            AttachmentFactory::fromString($content),
        );
    }

    public static function attachmentFile(
        string $name,
        string $file,
        ?string $type = null,
        ?string $fileExtension = null
    ): void {
        $attachment = self::getInstance()
            ->getResultFactory()
            ->createAttachment()
            ->setName($name)
            ->setType($type)
            ->setFileExtension($fileExtension);
        self::getLifecycle()->addAttachment(
            $attachment,
            AttachmentFactory::fromFile($file),
        );
    }

    public static function epic(string $value): void
    {
        self::getInstance()->doLabel(Label::epic($value));
    }

    public static function feature(string $value): void
    {
        self::getInstance()->doLabel(Label::feature($value));
    }

    public static function story(string $value): void
    {
        self::getInstance()->doLabel(Label::story($value));
    }

    public static function suite(string $value): void
    {
        self::getInstance()->doLabel(Label::suite($value));
    }

    public static function parentSuite(string $value): void
    {
        self::getInstance()->doLabel(Label::parentSuite($value));
    }

    public static function subSuite(string $value): void
    {
        self::getInstance()->doLabel(Label::subSuite($value));
    }

    public static function severity(Severity $value): void
    {
        self::getInstance()->doLabel(Label::severity($value));
    }

    public static function tag(string $value): void
    {
        self::getInstance()->doLabel(Label::tag($value));
    }

    public static function owner(string $value): void
    {
        self::getInstance()->doLabel(Label::owner($value));
    }

    public static function lead(string $value): void
    {
        self::getInstance()->doLabel(Label::lead($value));
    }

    public static function host(string $value): void
    {
        self::getInstance()->doLabel(Label::host($value));
    }

    public static function package(string $value): void
    {
        self::getInstance()->doLabel(Label::package($value));
    }

    public static function framework(string $value): void
    {
        self::getInstance()->doLabel(Label::framework($value));
    }

    public static function language(string $value): void
    {
        self::getInstance()->doLabel(Label::language($value));
    }

    public static function label(string $name, string $value): void
    {
        self::getInstance()->doLabel(
            new Label(
                name: $name,
                value: $value,
            ),
        );
    }

    public static function parameter(string $name, ?string $value = null): void
    {
        self::getInstance()
            ->doGetLifecycle()
            ->updateTestCase(
                fn (TestResult $test) => $test->addParameters(
                    new Parameter(
                        name: $name,
                        value: $value,
                    ),
                ),
            );
    }

    public static function issue(string $name, string $url): void
    {
        self::getInstance()->doLink(Link::issue($name, $url));
    }

    public static function tms(string $name, string $url): void
    {
        self::getInstance()->doLink(Link::tms($name, $url));
    }

    public static function link(string $url, ?string $name = null, ?LinkType $type = null): void
    {
        $link = new Link(
            name: $name,
            url: $url,
            type: $type ?? LinkType::custom(),
        );
        self::getInstance()->doLink($link);
    }

    public static function description(string $description): void
    {
        self::getLifecycle()->updateTestCase(
            fn (TestResult $test) => $test->setDescription($description),
        );
    }

    public static function descriptionHtml(string $descriptionHtml): void
    {
        self::getLifecycle()->updateTestCase(
            fn (TestResult $test) => $test->setDescriptionHtml($descriptionHtml),
        );
    }

    public static function getLifecycle(): AllureLifecycleInterface
    {
        return self::getInstance()->doGetLifecycle();
    }

    public static function setDefaultStepName(string $name): void
    {
        self::getInstance()->doSetDefaultStepName($name);
    }

    public static function cleanOutputDirectory(): void
    {
        self::getInstance()->getResultsWriter()->cleanOutputDirectory();
    }

    public static function setFactory(AllureFactoryInterface $factory): void
    {
        self::getInstance()->factory = $factory;
    }

    private function doSetOutputDirectory(string $outputDirectory): void
    {
        if (isset($this->resultsWriter)) {
            throw new OutputDirectorySetFailureException();
        }
        $this->outputDirectory = $outputDirectory;
    }

    private function doGetLifecycle(): AllureLifecycleInterface
    {
        return $this->lifecycle ??= $this->getFactory()->createLifecycle($this->getResultsWriter());
    }

    private function doSetDefaultStepName(string $name): void
    {
        $this->defaultStepName = '' == $name ? self::DEFAULT_STEP_NAME : $name;
    }

    private static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    private function getFactory(): AllureFactoryInterface
    {
        return $this->factory ??= new AllureFactory();
    }

    private function getOutputDirectory(): string
    {
        return $this->outputDirectory ?? throw new Exception\OutputDirectoryUndefinedException();
    }

    private function getResultsWriter(): AllureResultsWriterInterface
    {
        return $this->resultsWriter ??= $this
            ->getFactory()
            ->createResultsWriter($this->getOutputDirectory());
    }
    private function getResultFactory(): ResultFactoryInterface
    {
        return $this->resultFactory ??= $this
            ->getFactory()
            ->getResultFactory();
    }

    private function doAddStep(string $name, ?Status $status = null): void
    {
        $step = $this
            ->getResultFactory()
            ->createStep()
            ->setName($name)
            ->setStatus($status ?? Status::passed());
        $this
            ->doGetLifecycle()
            ->startStep($step)
            ->stopStep($step->getUuid());
    }

    /**
     * @param callable(StepContextInterface):mixed $callable
     * @param string|null $name
     * @return mixed
     */
    private function doRunStep(callable $callable, ?string $name = null): mixed
    {
        $step = $this
            ->getResultFactory()
            ->createStep()
            ->setName($name ?? $this->defaultStepName);
        $this->doGetLifecycle()->startStep($step);
        try {
            /** @var mixed $result */
            $result = $callable(new DefaultStepContext($this->doGetLifecycle(), $step->getUuid()));
            $this->doGetLifecycle()->updateStep(
                fn (StepResult $step) => $step->setStatus(Status::passed()),
                $step->getUuid(),
            );

            return $result;
        } catch (Throwable $e) {
            $statusDetector = $this->getFactory()->getStatusDetector();
            $this->doGetLifecycle()->updateStep(
                fn (StepResult $step) => $step
                    ->setStatus($statusDetector->getStatus($e) ?? Status::broken())
                    ->setStatusDetails($statusDetector->getStatusDetails($e)),
                $step->getUuid(),
            );

            return null;
        } finally {
            $this->doGetLifecycle()->stopStep($step->getUuid());
        }
    }

    private function doLabel(Label $label): void
    {
        $this
            ->doGetLifecycle()
            ->updateTestCase(
                fn (TestResult $test) => $test->addLabels($label),
            );
    }

    private function doLink(Link $link): void
    {
        $this
            ->doGetLifecycle()
            ->updateTestCase(
                fn (TestResult $test) => $test->addLinks($link),
            );
    }
}
