<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\LiveComponentInterface;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class Date implements LiveComponentInterface
{
    /**
     * @LiveProp
     */
    private \DateTimeInterface $created;

    public static function getComponentName(): string
    {
        return 'date';
    }

    public function mount(\DateTimeInterface $created = null): void
    {
        $this->created = $created ?? new \DateTime('now');
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): void
    {
        $this->created = $created;
    }
}
