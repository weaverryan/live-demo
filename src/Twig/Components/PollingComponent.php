<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('polling')]
class PollingComponent
{
    public $pollLength;

    public function getNow(): string
    {
        $now = \DateTimeImmutable::createFromFormat('U.u', microtime(true));

        return $now->format("m-d-Y H:i:s.u");
    }
}
