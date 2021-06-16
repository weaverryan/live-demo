<?php

namespace App\Twig\Components;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class Prefixer
{
    private string $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function prefix(): string
    {
        return $this->prefix;
    }

    public function __invoke(string $value): string
    {
        return $this->prefix.$value;
    }
}
