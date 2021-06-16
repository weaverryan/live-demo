<?php

namespace App\Twig\Components;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\LiveComponentInterface;

/**
 * Adds a notification message.
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class AddNotificationComponent implements LiveComponentInterface
{
    /**
     * @LiveProp(writable=true)
     */
    public string $message = '';

    /**
     * @LiveAction
     */
    public function add(EntityManagerInterface $em): void
    {
        $notification = new Notification();
        $notification->setMessage($this->message);

        $em->persist($notification);
        $em->flush();

        $this->message = '';
    }

    public static function getComponentName(): string
    {
        return 'add_notification';
    }
}
