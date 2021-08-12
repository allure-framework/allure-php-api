<?php

declare(strict_types=1);

namespace Qameta\Allure;

use Closure;
use Qameta\Allure\Attribute\AttributeParser;
use Qameta\Allure\Attribute\AttributeReader;
use Qameta\Allure\Exception\OutputDirectorySetFailureException;
use Qameta\Allure\Internal\DefaultStepContext;
use Qameta\Allure\Internal\LifecycleBuilder;
use Qameta\Allure\Io\DataSourceFactory;
use Qameta\Allure\Io\DataSourceInterface;
use Qameta\Allure\Io\ResultsWriterInterface;
use Qameta\Allure\Model\ExecutionContextInterface;
use Qameta\Allure\Model\Label;
use Qameta\Allure\Model\Link;
use Qameta\Allure\Model\LinkType;
use Qameta\Allure\Model\Parameter;
use Qameta\Allure\Model\ResultFactoryInterface;
use Qameta\Allure\Model\Severity;
use Qameta\Allure\Model\Status;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Setup\LifecycleBuilderInterface;
use Qameta\Allure\Setup\LifecycleConfigInterface;
use Qameta\Allure\Setup\LifecycleConfiguratorInterface;
use Qameta\Allure\Setup\LifecycleFactoryInterface;
use Qameta\Allure\Setup\StatusDetectorInterface;
use ReflectionException;
use ReflectionFunction;
use ReflectionMethod;
use Throwable;

use function count;
use function is_array;

final class Allure
{

    private const DEFAULT_STEP_NAME = 'step';

    private static ?self $instance = null;

    private ?LifecycleBuilderInterface $lifecycleBuilder = null;

    private ?string $outputDirectory = null;

    private ?AllureLifecycleInterface $lifecycle = null;

    private string $defaultStepName = self::DEFAULT_STEP_NAME;

    private ?ResultsWriterInterface $resultsWriter = null;

    private function __construct()
    {
    }

    public static function reset(): void
    {
        self::$instance = null;
    }

    public static function setOutputDirectory(string $outputDirectory): void
    {
        self::getInstance()->doSetOutputDirectory($outputDirectory);
    }

    public static function getLifecycleConfigurator(): LifecycleConfiguratorInterface
    {
        return self::getInstance()->getLifecycleBuilder();
    }

    public static function getResultFactory(): ResultFactoryInterface
    {
        return self::getInstance()->getLifecycleConfig()->getResultFactory();
    }

    public static function getStatusDetector(): StatusDetectorInterface
    {
        return self::getInstance()->getLifecycleConfig()->getStatusDetector();
    }

    /**
     * Adds passed step with provided name and status in current test or step (or test fixture). Takes no effect
     * if no test run at the moment.
     *
     * @param string      $name
     * @param Status|null $status Sets passed status by default.
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
     * @return mixed
     */
    public static function runStep(callable $callable): mixed
    {
        return self::getInstance()->doRunStep($callable);
    }

    public static function attachment(
        string $name,
        string $content,
        ?string $type = null,
        ?string $fileExtension = null,
    ): void {
        self::getInstance()->doAddAttachment(
            DataSourceFactory::fromString($content),
            $name,
            $type,
            $fileExtension,
        );
    }

    public static function attachmentFile(
        string $name,
        string $file,
        ?string $type = null,
        ?string $fileExtension = null
    ): void {
        self::getInstance()->doAddAttachment(
            DataSourceFactory::fromFile($file),
            $name,
            $type,
            $fileExtension,
        );
    }

    private function doAddAttachment(
        DataSourceInterface $dataSource,
        string $name,
        ?string $type = null,
        ?string $fileExtension = null,
    ): void {
        $attachment = self::getInstance()
            ->getLifecycleConfig()
            ->getResultFactory()
            ->createAttachment()
            ->setName($name)
            ->setType($type)
            ->setFileExtension($fileExtension);
        $this
            ->doGetLifecycle()
            ->addAttachment($attachment, $dataSource);
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
        self::getLifecycle()->updateTest(
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
        self::getInstance()->doLink(
            new Link(
                name: $name,
                url: $url,
                type: $type ?? LinkType::custom(),
            ),
        );
    }

    public static function description(string $description): void
    {
        self::getLifecycle()->updateExecutionContext(
            fn (ExecutionContextInterface $context) => $context->setDescription($description),
        );
    }

    public static function descriptionHtml(string $descriptionHtml): void
    {
        self::getLifecycle()->updateExecutionContext(
            fn (ExecutionContextInterface $context) => $context->setDescriptionHtml($descriptionHtml),
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

    public static function setLifecycleBuilder(LifecycleBuilderInterface $builder): void
    {
        self::getInstance()->lifecycleBuilder = $builder;
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
        return $this->lifecycle ??= $this->getLifecycleFactory()->createLifecycle($this->getResultsWriter());
    }

    private function doSetDefaultStepName(string $name): void
    {
        $this->defaultStepName = '' == $name ? self::DEFAULT_STEP_NAME : $name;
    }

    private static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    private function getLifecycleBuilder(): LifecycleBuilderInterface
    {
        return $this->lifecycleBuilder ??= new LifecycleBuilder();
    }

    private function getLifecycleConfig(): LifecycleConfigInterface
    {
        return $this->getLifecycleBuilder();
    }

    private function getLifecycleFactory(): LifecycleFactoryInterface
    {
        return $this->getLifecycleBuilder();
    }

    private function getOutputDirectory(): string
    {
        return $this->outputDirectory ?? throw new Exception\OutputDirectoryUndefinedException();
    }

    private function getResultsWriter(): ResultsWriterInterface
    {
        return $this->resultsWriter ??= $this
            ->getLifecycleFactory()
            ->createResultsWriter($this->getOutputDirectory());
    }

    private function doAddStep(string $name, ?Status $status = null): void
    {
        $step = $this
            ->getLifecycleConfig()
            ->getResultFactory()
            ->createStep()
            ->setName($name)
            ->setStatus($status ?? Status::passed());
        $this->doGetLifecycle()->startStep($step);
        $this->doGetLifecycle()->stopStep($step->getUuid());
    }

    /**
     * @param callable(StepContextInterface):mixed $callable
     * @return mixed
     */
    private function doRunStep(callable $callable): mixed
    {
        $step = $this
            ->getLifecycleConfig()
            ->getResultFactory()
            ->createStep();
        $this->doGetLifecycle()->startStep($step);
        try {
            $parser = $this->readCallableAttributes($callable);
            $this->doGetLifecycle()->updateStep(
                fn (StepResult $step) => $step
                    ->setName($parser->getTitle() ?? $this->defaultStepName)
                    ->addParameters(...$parser->getParameters()),
            );

            /** @var mixed $result */
            $result = $callable(new DefaultStepContext($this->doGetLifecycle(), $step->getUuid()));
            $this->doGetLifecycle()->updateStep(
                fn (StepResult $step) => $step->setStatus(Status::passed()),
                $step->getUuid(),
            );

            return $result;
        } catch (Throwable $e) {
            $statusDetector = $this->getLifecycleConfig()->getStatusDetector();
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

    /**
     * @throws ReflectionException
     */
    private function readCallableAttributes(callable $callable): AttributeParser
    {
        $attributeReader = new AttributeReader();
        if (is_array($callable)) {
            [$object, $method] = count($callable) == 2
                ? $callable
                : [null, null];
            $attributes = isset($object, $method)
                ? $attributeReader->getMethodAnnotations(new ReflectionMethod($object, $method))
                : [];
        } else {
            /** @var Closure|callable-string $callable */
            $attributes = $attributeReader->getFunctionAnnotations(new ReflectionFunction($callable));
        }

        return new AttributeParser($attributes);
    }

    private function doLabel(Label $label): void
    {
        $this
            ->doGetLifecycle()
            ->updateTest(
                fn (TestResult $test) => $test->addLabels($label),
            );
    }

    private function doLink(Link $link): void
    {
        $this
            ->doGetLifecycle()
            ->updateTest(
                fn (TestResult $test) => $test->addLinks($link),
            );
    }
}
