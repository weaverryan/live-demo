<?php

namespace App\Twig\Components;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

/**
 * A reusable component to render a <code>textarea</code> and Markdown preview.
 *
 * The component also has (A) real-time validation (if you make the textarea
 * blank) (B) loading indicators for the preview and (C) the <code>textarea</code>
 * will expand if you type more text into it.
 */
#[AsLiveComponent('markdown_input')]
final class MarkdownInputComponent
{
    use DefaultActionTrait;
    use ValidatableComponentTrait;

    #[LiveProp]
    public string $name;

    #[LiveProp]
    public string $label;

    #[LiveProp(writable: true)]
    #[Assert\NotBlank]
    public string $value = '';

    public function mount(string $name): void
    {
        $this->name = $name;
        $this->label = ucfirst($name);
    }

    public function getRows(): int
    {
        return max(3, floor(strlen($this->value) / 10));
    }
}
