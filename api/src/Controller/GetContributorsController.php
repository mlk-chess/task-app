<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetContributorsController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private RequestStack $requestStack
    ) {
    }

    public function __invoke()
    {
        if (!$users = $this->managerRegistry->getRepository(User::class)) {
            throw $this->createNotFoundException();
        }

        $users = $users->findBy([
            'status' => 1,
        ]);

        return $users;
    }
}
