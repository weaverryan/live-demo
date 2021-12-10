<?php

namespace App\Twig\Components;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

/**
 * Adds a notification message.
 *
 * After submitting the message, check the <code>NotificationComponent</code>
 * above to see it!
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 */
#[AsLiveComponent('add_notification')]
final class AddNotificationComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $message = '';

    public bool $messageAdded = false;

    #[LiveAction]
    public function add(EntityManagerInterface $em): void
    {
        $notification = new Notification();
        $notification->setMessage($this->message);

        $em->persist($notification);
        $em->flush();

        $this->message = '';
        $this->messageAdded = true;
    }
}
