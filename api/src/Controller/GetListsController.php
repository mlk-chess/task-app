<?php

namespace App\Controller;

use App\Entity\ListTask;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetListsController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private RequestStack $requestStack
    ) {
    }

    public function __invoke()
    {
        if (!$listTask = $this->managerRegistry->getRepository(ListTask::class)) {
            throw $this->createNotFoundException();
        }

        // Get list task of current user 
        $user = $this->getUser();

        $current_user = $this->managerRegistry->getRepository(User::class);
        
        // Get Id of current user
        $current_user = $current_user->findOneBy(['id' => $user->getUserIdentifier()]);

        $listTask = $listTask->findBy(['owner' => $current_user->getId()]);

        // Get contributors of list task
        $contributors = [];
        foreach ($listTask as $list) {
            $contributors[] = $list->getContributors();
        }
        return [
            'listTask' => $listTask,
            'contributors' => $contributors
        ];

        // return $this->json($listTask);
    }
}
