<?php

namespace App;

use App\Twig\Components\AddNotificationComponent;
use App\Twig\Components\AlertComponent;
use App\Twig\Components\ChangeableEditPostNoFormComponent;
use App\Twig\Components\CollectionTypeFormComponent;
use App\Twig\Components\ComplexInputComponent;
use App\Twig\Components\DateComponent;
use App\Twig\Components\EditPostNoFormComponent;
use App\Twig\Components\InputComponent;
use App\Twig\Components\MarkdownInputComponent;
use App\Twig\Components\NotificationComponent;
use App\Twig\Components\RegistrationFormComponent;
use Highlight\Highlighter;
use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\ComponentFactory;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DemoExtension extends AbstractExtension
{
    public function __construct(private Highlighter $highlighter, private ExampleHelper $exampleHelper)
    {
        $this->highlighter = $highlighter;
        $this->exampleHelper = $exampleHelper;
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

    public function getExamples(): array
    {
        return $this->exampleHelper->getExamples();
    }

    public function getComponentSource(string $componentClass): string
    {
        $reflection = new \ReflectionClass($componentClass);
        $source = file_get_contents($reflection->getFileName());

        return $this->highlighter->highlight('php', $source)->value;
    }

    public function getComponentTemplate(string $name): string
    {
        $source = file_get_contents(sprintf(__DIR__.'/../templates/components/%s.html.twig', $name));

        return $this->highlighter->highlight('twig', $source)->value;
    }

    public function renderComponentExampleSource(string $name): string
    {
        $source = file_get_contents(sprintf(__DIR__.'/../templates/examples/example_%s.html.twig', $name));

        return $this->highlighter->highlight('twig', $source)->value;
    }
}
