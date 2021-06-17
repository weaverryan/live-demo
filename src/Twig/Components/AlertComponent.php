<?php

namespace App\Twig\Components;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\TwigComponent\ComponentInterface;

/**
 * Renders an "alert" message of different types.
 */
final class AlertComponent implements ComponentInterface
{
    /**
     * @LiveProp
     */
    public string $type = 'success';

    /**
     * @LiveProp
     */
    public string $message;

    public static function getComponentName(): string
    {
        return 'alert';
    }
}
