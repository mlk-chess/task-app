<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ListTaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Controller\GetListsController;


#[ORM\Entity(repositoryClass: ListTaskRepository::class)]
#[ApiResource(
    security: "is_granted('ROLE_USER')",
    routePrefix: "api",
    operations: [
        new GetCollection(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Get(
            security: "object.owner == user",
            securityMessage: 'Sorry, but you are not the list owner.'
        ),
        // new Put(
        //     securityPostDenormalize: "is_granted('ROLE_ADMIN') or (object.owner == user and previous_object.owner == user)", 
        //     securityPostDenormalizeMessage: 'Sorry, but you are not the actual book owner.'
        // ),
        new Post(),
        new Get(
            routePrefix: 'api',
            name: 'get-lists',
            uriTemplate: '/get-lists',
            controller: GetListsController::class,
            read: false
        )
    ]
)]
#[UniqueEntity('name')]
class ListTask
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'listTasks')]
    private Collection $contributors;

    #[ORM\OneToMany(mappedBy: 'belongsToList', targetEntity: Task::class)]
    private Collection $tasks;

    #[ORM\ManyToOne(inversedBy: 'ListTasksOwner')]
    public ?User $owner;

    public function __construct()
    {
        $this->contributors = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getContributors(): Collection
    {
        return $this->contributors;
    }

    public function addContributor(User $contributor): static
    {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors->add($contributor);
        }

        return $this;
    }

    public function removeContributor(User $contributor): static
    {
        $this->contributors->removeElement($contributor);

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setBelongsToList($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getBelongsToList() === $this) {
                $task->setBelongsToList(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}