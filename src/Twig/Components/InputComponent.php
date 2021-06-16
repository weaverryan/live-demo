<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\ComponentInterface;

/**
 * A reusable component to render <code>input</code> elements.
 */
final class InputComponent implements ComponentInterface
{
    public ?string $label = null;
    public ?string $value = null;
    public string $type = 'text';
    public array $errors = [];

    public static function getComponentName(): string
    {
        return 'input';
    }

    public function setErrors($errors): void
    {
        // demonstrate that setting properties can be done via a setter if some logic is required
        $this->errors = (array) $errors;
    }

    public function hasErrors(): bool
    {
        // can call methods from the twig template
        return \count($this->errors);
    }
}
