<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

/**
 * A simple component that shows how DateTime objects are dehydrated.
 */
#[AsLiveComponent('date')]
final class DateComponent
{
    /**
     * A built-in hydrator handles converting this object into
     * a date "string" for the frontend, then back into a DateTime
     * object in the component.
     */
    #[LiveProp]
    private \DateTimeInterface $created;

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
