<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Task::class, cascade: ['remove'])]
    private Collection $tasks;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: UserProjectRate::class, cascade: ['remove'])]
    private Collection $userProjectRates;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->userProjectRates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setProject($this);
        }
        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            if ($task->getProject() === $this) {
                $task->setProject(null);
            }
        }
        return $this;
    }

    public function getUserProjectRates(): Collection
    {
        return $this->userProjectRates;
    }

    public function addUserProjectRate(UserProjectRate $rate): self
    {
        if (!$this->userProjectRates->contains($rate)) {
            $this->userProjectRates[] = $rate;
            $rate->setProject($this);
        }
        return $this;
    }

    public function removeUserProjectRate(UserProjectRate $rate): self
    {
        if ($this->userProjectRates->removeElement($rate)) {
            if ($rate->getProject() === $this) {
                $rate->setProject(null);
            }
        }
        return $this;
    }
}
