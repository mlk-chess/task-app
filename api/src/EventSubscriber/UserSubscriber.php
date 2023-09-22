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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AllowDynamicProperties] final class UserSubscriber implements EventSubscriberInterface
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private MailerInterface $mailer
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW =>   ['sendMailToUsers', EventPriorities::PRE_WRITE],
        ];
    }

    public function sendMailToUsers(ViewEvent $event)
    {
        $user =  $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if ($user instanceof User && $method === "POST") {
            $token = bin2hex(random_bytes(64));
            $user->setToken($token);

            $currentUser = $this->tokenStorage->getToken();

            if ($currentUser !== NULL) {
                if (in_array("ROLE_ADMIN", $user->getRoles()) && !in_array("ROLE_ADMIN", $currentUser->getUser()->getRoles())) {
                    throw new \Exception("Error (#1)");
                }

                if ($user->getStatus() > 0 && !in_array("ROLE_ADMIN", $currentUser->getUser()->getRoles())) {
                    throw new \Exception("Error (#3)");
                }
            } else {
                if (in_array("ROLE_ADMIN", $user->getRoles())) {
                    throw new \Exception("Error (#2)");
                }
                if ($user->getStatus() > 0) {
                    throw new \Exception("Error (#4)");
                }
            }


            $email = ApiMailerService::send_email(
                $user->getEmail(),
                "Création de votre compte",
                'Bonjour, voici le lien pour valider votre compte : <a href="https://task-app-sigma-ten.vercel.app/confirm-account?token=' . $token . '">valider mon compte</a>',
            );

            $this->mailer->send($email);
        }
    }
}
