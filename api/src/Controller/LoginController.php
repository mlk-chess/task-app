<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Service\ApiMailerService;
use Symfony\Component\Mailer\MailerInterface;


#[AsController]
class LoginController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private RequestStack $requestStack,
        private UserPasswordHasherInterface $hasher,
        private JWTTokenManagerInterface $JWTManager,
        private MailerInterface $mailer
    ) {
    }

    public function __invoke()
    {
        $parameters = json_decode($this->requestStack->getCurrentRequest()->getContent(), true);

        if (!$user = $this->managerRegistry->getRepository(User::class)->findOneBy(['email' => $parameters['email']])) {
            return $this->json(['message' => 'Not exist'], 401);
        }

        if (!$this->hasher->isPasswordValid($user, $parameters['password'])) {
            return $this->json(['message' => 'Error login'], 401);
        }
        if ($user->getStatus() !== 1 && $user->getStatus() !== 2 && $user->getStatus() !== 3) {
            return $this->json(['message' => 'Not confirmed'], 401);
        }

        $email = ApiMailerService::send_email(
            $user->getEmail(),
            "[Notification] Nouvelle connexion à votre compte",
            'Bonjour, vous venez de vous connecter.',
        );

        $this->mailer->send($email);

        return $this->json(['token' => $this->JWTManager->create($user)]);
    }
}
