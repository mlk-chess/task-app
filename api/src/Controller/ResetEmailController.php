<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\ApiMailerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mailer\MailerInterface;

#[AsController]
class ResetEmailController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private RequestStack $requestStack,
        private MailerInterface $mailer,
    ) {
    }

    public function __invoke()
    {
        $parameters = json_decode($this->requestStack->getCurrentRequest()->getContent(), true);

        if (!$user = $this->managerRegistry->getRepository(User::class)->findOneBy(['email' => $parameters['email']])) {
            return $this->json(['message' => 'error']);
        }

        $token = bin2hex(random_bytes(64));
        $user->setToken($token);

        $email = ApiMailerService::send_email(
            $user->getEmail(),
            "Réinitialisation de votre compte",
            'Bonjour, voici le lien réinitialiser votre compte : <a href="localhost/reset-password?token=' . $token . '">réinitialiser mon compte</a>',
        );

        $this->mailer->send($email);
        $this->managerRegistry->getManager()->flush();


        return $this->json(['message' => 'Success']);
    }
}
