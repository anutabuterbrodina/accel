<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'project')]
class Deal
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column]
    private string $status;

    #[ORM\Column]
    private ?int $investment;

    #[ORM\Column]
    private int $createdAt;

    #[ORM\Column]
    private ?int $updatedAt;

    #[ORM\OneToOne(targetEntity: User::class)]
    private User $manager;

    #[ORM\OneToOne(targetEntity: Project::class)]
    private ?Project $project;

    #[ORM\OneToOne(targetEntity: Project::class)]
    private ?Project $investor;

    /**
     * @return User
     */
    public function getManager(): User
    {
        return $this->manager;
    }

    /**
     * @param User $manager
     */
    public function setManager(User $manager): void
    {
        $this->manager = $manager;
    }

    /**
     * @return Project|null
     */
    public function getProject(): ?Project
    {
        return $this->project;
    }

    /**
     * @param Project|null $project
     */
    public function setProject(?Project $project): void
    {
        $this->project = $project;
    }

    /**
     * @return Project|null
     */
    public function getInvestor(): ?Project
    {
        return $this->investor;
    }

    /**
     * @param Project|null $investor
     */
    public function setInvestor(?Project $investor): void
    {
        $this->investor = $investor;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int|null
     */
    public function getInvestment(): ?int
    {
        return $this->investment;
    }

    /**
     * @param int|null $investment
     */
    public function setInvestment(?int $investment): void
    {
        $this->investment = $investment;
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     */
    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int|null
     */
    public function getUpdatedAt(): ?int
    {
        return $this->updatedAt;
    }

    /**
     * @param int|null $updatedAt
     */
    public function setUpdatedAt(?int $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}