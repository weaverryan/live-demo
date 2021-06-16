<?php

namespace App\Twig\Components;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\LiveComponentInterface;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class MarkdownInput implements LiveComponentInterface
{
    use ValidatableComponentTrait;

    /**
     * @LiveProp
     */
    public string $name;

    /**
     * @LiveProp
     */
    public string $label;

    /**
     * @LiveProp(writable=true)
     * @Assert\NotBlank
     */
    public string $value = '';

    public static function getComponentName(): string
    {
        return 'markdown_input';
    }

    public function mount(string $name): void
    {
        $this->name = $name;
        $this->label = ucfirst($name);
    }

    public function getRows(): int
    {
        return max(3, floor(strlen($this->value) / 10));
    }

    /**
     * @LiveAction()
     */
    public function save()
    {
        $this->validate();
    }
}
