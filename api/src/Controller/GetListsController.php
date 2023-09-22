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
        if (!$listTaskRepository = $this->managerRegistry->getRepository(ListTask::class)) {
            throw $this->createNotFoundException();
        }

        $user = $this->getUser();

        $current_user = $this->managerRegistry->getRepository(User::class);

        $current_user = $current_user->findOneBy(['id' => $user->getUserIdentifier()]);

        $listTask = $listTaskRepository->findBy(['owner' => $current_user->getId()]);

        $contributors = [];
        foreach ($listTask as $list) {
            $contributors[] = $list->getContributors();
        }

        $listTasks = $listTaskRepository->findAll();

        // if current user hasn't role "ROLE_ADMIN"
        if (false === in_array('ROLE_ADMIN', $current_user->getRoles())) {

            $filteredLists = [];
            foreach ($listTasks as $list) {
                $contributors2 = $list->getContributors();

                foreach ($contributors2 as $contributor) {
                    if ($contributor->getId() === $current_user->getId()) {
                        $filteredLists[] = $list;
                    }
                }
            }
        } else {
            $filteredLists = $listTasks;
        }

        return [
            'listTask' => $listTask,
            'filteredListTask' => $filteredLists,
            'contributors' => $contributors
        ];
    }
}
