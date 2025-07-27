<?php

// src/Entity/User.php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column(length: 100, unique: true)]
    private string $email;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Task::class, cascade: ['remove'])]
    private Collection $tasks;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserProjectRate::class, cascade: ['remove'])]
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
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
            $task->setUser($this);
        }
        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            if ($task->getUser() === $this) {
                $task->setUser(null);
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
            $rate->setUser($this);
        }
        return $this;
    }

    public function removeUserProjectRate(UserProjectRate $rate): self
    {
        if ($this->userProjectRates->removeElement($rate)) {
            if ($rate->getUser() === $this) {
                $rate->setUser(null);
            }
        }
        return $this;
    }
}
