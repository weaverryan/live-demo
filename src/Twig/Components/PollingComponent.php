<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('polling')]
class PollingComponent
{
    use DefaultActionTrait;

    public $pollLength;

    public function getNow(): string
    {
        $now = \DateTimeImmutable::createFromFormat('U.u', microtime(true));

        return $now->format("m-d-Y H:i:s.u");
    }
}
