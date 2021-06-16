<?php

namespace App\Twig\Components;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\LiveComponentInterface;

/**
 * Polls the server to look for new notifications.
 *
 * Add new notifications by running `bin/console create:notification "You're message"`
 */
final class NotificationComponent implements LiveComponentInterface
{
    private NotificationRepository $repo;

    /**
     * @LiveProp
     */
    public bool $expanded = false;

    public function __construct(NotificationRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @LiveAction
     */
    public function toggle(): void
    {
        $this->expanded = !$this->expanded;
    }

    /**
     * @return Notification[]
     */
    public function getNotifications(): array
    {
        return $this->repo->findAll();
    }

    public static function getComponentName(): string
    {
        return 'notification';
    }
}
