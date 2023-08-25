<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ApiResource]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $due_date = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?ListTask $belongsToList = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'tasks')]
    private Collection $assignTo;

    public function __construct()
    {
        $this->assignTo = new ArrayCollection();
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

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->due_date;
    }

    public function setDueDate(?\DateTimeInterface $due_date): static
    {
        $this->due_date = $due_date;

        return $this;
    }

    public function getBelongsToList(): ?ListTask
    {
        return $this->belongsToList;
    }

    public function setBelongsToList(?ListTask $belongsToList): static
    {
        $this->belongsToList = $belongsToList;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAssignTo(): Collection
    {
        return $this->assignTo;
    }

    public function addAssignTo(User $assignTo): static
    {
        if (!$this->assignTo->contains($assignTo)) {
            $this->assignTo->add($assignTo);
        }

        return $this;
    }

    public function removeAssignTo(User $assignTo): static
    {
        $this->assignTo->removeElement($assignTo);

        return $this;
    }
}