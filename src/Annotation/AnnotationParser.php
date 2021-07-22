<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

use Qameta\Allure\Legacy\Annotation\LegacyAnnotationInterface;
use Qameta\Allure\Model;

class AnnotationParser
{

    private ?string $title = null;

    private ?string $description = null;

    private ?string $descriptionHtml = null;

    /**
     * @var list<Model\Label>
     */
    private array $labels = [];

    /**
     * @var list<Model\Link>
     */
    private array $links = [];

    /**
     * @var list<Model\Parameter>
     */
    private array $parameters = [];

    /**
     * @param array<object> $annotations
     * @param array<string, LinkTemplateInterface> $linkTemplates
     */
    public function __construct(
        array $annotations,
        private array $linkTemplates = [],
    ) {
        $this->processAnnotations(...$annotations);
    }

    private function processAnnotations(object ...$annotations)
    {
        foreach ($this->convertLegacyAnnotations(...$annotations) as $annotation) {
            if ($annotation instanceof TitleInterface) {
                $this->title = $annotation->getValue();
            }
            if ($annotation instanceof DescriptionInterface) {
                if ($annotation->isHtml()) {
                    $this->descriptionHtml = $annotation->getValue();
                } else {
                    $this->description = $annotation->getValue();
                }
            }
            if ($annotation instanceof LinkInterface) {
                $this->links[] = $this->createLink($annotation);
            }
            if ($annotation instanceof LabelInterface) {
                $this->labels[] = $this->createLabel($annotation);
            }
            if ($annotation instanceof ParameterInterface) {
                $this->parameters[] = $this->createParameter($annotation);
            }
        }
    }

    /**
     * @return iterable<int, object>
     */
    private function convertLegacyAnnotations(object ...$annotations): iterable
    {
        foreach ($annotations as $annotation) {
            yield from $annotation instanceof LegacyAnnotationInterface
                ? (array) $annotation->convert()
                : [$annotation];
        }
    }

    private function createLink(LinkInterface $link): Model\Link
    {
        return new Model\Link(
            name: $link->getName(),
            url: $link->getUrl() ?? $this->getLinkUrl($link->getName(), $link->getType()),
            type: new Model\LinkType($link->getType()),
        );
    }

    private function getLinkUrl(?string $name, string $type): ?string
    {
        return isset($this->linkTemplates[$type])
            ? $this->linkTemplates[$type]->buildUrl($name)
            : $name;
    }

    /**
     * @return list<Model\Link>
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    private function createLabel(LabelInterface $label): Model\Label
    {
        return new Model\Label(
            name: $label->getName(),
            value: $label->getValue(),
        );
    }

    /**
     * @return list<Model\Label>
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    private function createParameter(ParameterInterface $parameter): Model\Parameter
    {
        return new Model\Parameter(
            name: $parameter->getName(),
            value: $parameter->getValue(),
        );
    }

    /**
     * @return list<Model\Parameter>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDescriptionHtml(): ?string
    {
        return $this->descriptionHtml;
    }
}
