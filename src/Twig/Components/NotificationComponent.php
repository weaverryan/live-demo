<?php

namespace App\Twig\Components;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

/**
 * Polls the server to look for new notifications.
 *
 * Add new notifications by running <code>bin/console create:notification "You're message"</code>
 * or by using the <code>AddNotificationComponent</code> below.
 */
#[AsLiveComponent('notification')]
final class NotificationComponent
{
    private NotificationRepository $repo;

    #[LiveProp]
    public bool $expanded = false;

    public function __construct(NotificationRepository $repo)
    {
        $this->repo = $repo;
    }

    #[LiveAction]
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
}
