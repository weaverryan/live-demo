<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Renders an "alert" message of different types.
 */
#[AsTwigComponent('alert')]
final class AlertComponent
{
    public string $type = 'success';
    public string $message;

    public bool $escape = true;
}
