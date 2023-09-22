<?php

namespace App\Controller;

use App\Entity\ListTask;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetSpecificList extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private RequestStack $requestStack
    ) {
    }

    public function __invoke()
    {
        if (!$list = $this->managerRegistry->getRepository(ListTask::class)->findOneBy(['id' => $this->requestStack->getCurrentRequest()->get('id')])) {
            throw $this->createNotFoundException();
        }

        $contributors = $list->getContributors();
        $contributors[] = $list->getOwner();

        $ids = [];

        foreach ($contributors as $value) {
            $ids[] = $value->getId();
        }

        $user = $this->getUser()->getUserIdentifier();

        if (false === in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            throw $this->createAccessDeniedException();
        }

        if (!in_array($user, $ids)) {
            throw $this->createAccessDeniedException();
        }

        // Get tasks
        $tasks = $list->getTasks();


        return [
            'list' => $list,
            'contributors' => $contributors,
            'tasks' => $tasks ?? [],
        ];
    }
}
