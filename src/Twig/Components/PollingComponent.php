<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\LiveComponentInterface;

class PollingComponent implements LiveComponentInterface
{
    public $pollLength;

    public function getNow(): string
    {
        $now = \DateTimeImmutable::createFromFormat('U.u', microtime(true));

        return $now->format("m-d-Y H:i:s.u");
    }

    public static function getComponentName(): string
    {
        return 'polling';
    }
}
