<?php

namespace App;

use App\Twig\Components\AddNotificationComponent;
use App\Twig\Components\AlertComponent;
use App\Twig\Components\ChangeableEditPostNoFormComponent;
use App\Twig\Components\ComplexInputComponent;
use App\Twig\Components\DateComponent;
use App\Twig\Components\EditPostNoFormComponent;
use App\Twig\Components\EditPostWithEmbeddedComponent;
use App\Twig\Components\InputComponent;
use App\Twig\Components\MarkdownInputComponent;
use App\Twig\Components\NotificationComponent;
use App\Twig\Components\RegistrationFormComponent;
use Highlight\Highlighter;
use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DemoExtension extends AbstractExtension
{
    private Highlighter $highlighter;

    public function __construct(Highlighter $highlighter)
    {
        $this->highlighter = $highlighter;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('example_component_source', [$this, 'getComponentSource'], ['is_safe' => ['html']]),
            new TwigFunction('example_component_template', [$this, 'getComponentTemplate'], ['is_safe' => ['html']]),
            new TwigFunction('example_include_example_source', [$this, 'renderComponentExampleSource'], ['is_safe' => ['html']]),
            new TwigFunction('get_examples', [$this, 'getExamples']),
        ];
    }

    public function getComponentSource(string $componentClass)
    {
        $reflection = new \ReflectionClass($componentClass);
        $source = file_get_contents($reflection->getFileName());

        return $this->highlighter->highlight('php', $source)->value;
    }

    public function getComponentTemplate(string $name)
    {
        $source = file_get_contents(sprintf(__DIR__.'/../templates/components/%s.html.twig', $name));

        return $this->highlighter->highlight('twig', $source)->value;
    }

    public function renderComponentExampleSource(string $name)
    {
        $source = file_get_contents(sprintf(__DIR__.'/../templates/examples/example_%s.html.twig', $name));

        return $this->highlighter->highlight('twig', $source)->value;
    }

    public function getExamples(): array
    {
        $examples = [
            AlertComponent::class,
            InputComponent::class,
            RegistrationFormComponent::class,
            ComplexInputComponent::class,
            EditPostNoFormComponent::class,
            ChangeableEditPostNoFormComponent::class,
            AddNotificationComponent::class,
            DateComponent::class,
            MarkdownInputComponent::class,
            EditPostWithEmbeddedComponent::class,
        ];

        return $this->prepareExamples($examples);
    }

    private function prepareExamples(array $examples)
    {
        $docBlockFactory = DocBlockFactory::createInstance();

        $finalExamples = [];
        foreach ($examples as $example) {
            $reflectionClass = new \ReflectionClass($example);
            $docBlock = $reflectionClass->getDocComment() ? $docBlockFactory->create($reflectionClass->getDocComment()) : null;
            $classDescription = $docBlock ? $docBlock->getDescription() : '';
            $classDescription = str_replace("\n\n", '<br><br>', $classDescription);

            $finalExamples[] = [
                'class' => $example,
                'componentName' => AsTwigComponent::forClass($example)->getName(),
                'shortClass' => $reflectionClass->getShortName(),
                'classSummary' => $docBlock ? $docBlock->getSummary() : '',
                'classDescription' => $classDescription,
                'isLive' => !empty($reflectionClass->getAttributes(AsLiveComponent::class)),
            ];
        }

        return $finalExamples;
    }
}
