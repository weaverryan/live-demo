<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

/**
 * A simple component that shows how DateTime objects are dehydrated.
 */
#[AsLiveComponent('date')]
final class DateComponent
{
    use DefaultActionTrait;

    /**
     * A built-in hydrator handles converting this object into
     * a date "string" for the frontend, then back into a DateTime
     * object in the component.
     */
    #[LiveProp]
    public \DateTimeInterface $created;

    public function mount(\DateTimeInterface $created = null): void
    {
        $this->created = $created ?? new \DateTime('now');
    }
}
