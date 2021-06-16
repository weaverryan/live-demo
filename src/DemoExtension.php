<?php

namespace App;

use Highlight\Highlighter;
use Twig\Environment;
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
}
