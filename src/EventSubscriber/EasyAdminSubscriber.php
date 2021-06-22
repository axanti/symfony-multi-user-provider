<?php
namespace App\EventSubscriber;

use App\Entity\User;
use App\Entity\Client;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setClientPassword'],
            BeforeEntityUpdatedEvent::class => ['setClientPassword'],
        ];
    }

    public function setClientPassword($event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Client) || !($entity instanceof User))
        {
            return;
        }

        $entity->setPassword($this->passwordHasher->hashPassword($entity, $entity->getPassword()));
    }
}