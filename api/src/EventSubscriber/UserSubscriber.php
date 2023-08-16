<?php
namespace App\EventSubscriber;

use AllowDynamicProperties;
use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Service\ApiMailerService;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
#[AllowDynamicProperties] final class UserSubscriber implements EventSubscriberInterface
{


    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private MailerInterface $mailer,
    )
    {}

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW =>   ['confirmEmail', EventPriorities::PRE_WRITE]

        ];
    }

    public function confirmEmail(ViewEvent $event)
    {
        $user =  $event ->getControllerResult();
        $method = $event ->getRequest()->getMethod();
        if ($user instanceof User && $method === "POST")
        {
            $token = bin2hex(random_bytes(64));
            $user->setToken($token);

            $email = ApiMailerService::send_email(
                                $user->getEmail(),
                                "Création de votre compte",
                                'Bonjour, voici le lien pour valider votre compte : https://localhost:8081/confirm-account?token=' . $token,
                            );

            $this->mailer->send($email);
        }
    }
}
