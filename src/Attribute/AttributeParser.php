<?php

declare(strict_types=1);

namespace Qameta\Allure\Attribute;

use Qameta\Allure\Model;

class AttributeParser
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
     * @param array<AttributeInterface>            $attributes
     * @param array<string, LinkTemplateInterface> $linkTemplates
     */
    public function __construct(
        array $attributes,
        private array $linkTemplates = [],
    ) {
        $this->processAnnotations(...$attributes);
    }

    private function processAnnotations(AttributeInterface ...$attributes): void
    {
        foreach ($attributes as $attribute) {
            if ($attribute instanceof TitleInterface) {
                $this->title = $attribute->getValue();
            }
            if ($attribute instanceof DescriptionInterface) {
                if ($attribute->isHtml()) {
                    $this->descriptionHtml = $attribute->getValue();
                } else {
                    $this->description = $attribute->getValue();
                }
            }
            if ($attribute instanceof LinkInterface) {
                $this->links[] = $this->createLink($attribute);
            }
            if ($attribute instanceof LabelInterface) {
                $this->labels[] = $this->createLabel($attribute);
            }
            if ($attribute instanceof ParameterInterface) {
                $this->parameters[] = $this->createParameter($attribute);
            }
        }
    }

    private function createLink(LinkInterface $link): Model\Link
    {
        $linkType = $link->getType();

        return new Model\Link(
            name: $link->getName(),
            url: $link->getUrl() ?? $this->getLinkUrl($link->getName(), $linkType),
            type: isset($linkType)
                ? new Model\LinkType($linkType)
                : null,
        );
    }

    private function getLinkUrl(?string $name, ?string $type): ?string
    {
        return isset($type, $this->linkTemplates[$type])
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
