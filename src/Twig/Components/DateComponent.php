<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\LiveComponentInterface;

/**
 * A simple component that shows how DateTime objects are dehydrated.
 */
final class DateComponent implements LiveComponentInterface
{
    /**
     * A built-in hydrator handles converting this object into
     * a date "string" for the frontend, then back into a DateTime
     * object in the component.
     *
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
