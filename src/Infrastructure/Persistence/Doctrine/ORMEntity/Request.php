<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'request')]
class Request
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column]
    private string $status;

    #[ORM\Column]
    private string $type;

    #[ORM\Column]
    private ?string $creatorComment = null;

    #[ORM\Column]
    private ?string $rejectReason = null;

    #[ORM\Column]
    private ?string $rejectMessage = null;

    #[ORM\Column]
    private string $content;

    #[ORM\Column]
    private int $createdAt;

    #[ORM\Column]
    private ?int $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $creator;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $moderator = null;

    #[ORM\ManyToOne(targetEntity: Project::class)]
    private ?Project $project = null;

    #[ORM\ManyToOne(targetEntity: Investor::class)]
    private ?Investor $investor = null;

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getCreatorComment(): ?string
    {
        return $this->creatorComment;
    }

    /**
     * @param string|null $creatorComment
     */
    public function setCreatorComment(?string $creatorComment): void
    {
        $this->creatorComment = $creatorComment;
    }

    /**
     * @return string|null
     */
    public function getRejectReason(): ?string
    {
        return $this->rejectReason;
    }

    /**
     * @param string|null $rejectReason
     */
    public function setRejectReason(?string $rejectReason): void
    {
        $this->rejectReason = $rejectReason;
    }

    /**
     * @return string|null
     */
    public function getRejectMessage(): ?string
    {
        return $this->rejectMessage;
    }

    /**
     * @param string|null $rejectMessage
     */
    public function setRejectMessage(?string $rejectMessage): void
    {
        $this->rejectMessage = $rejectMessage;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
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

    /**
     * @return User
     */
    public function getCreator(): User
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     */
    public function setCreator(User $creator): void
    {
        $this->creator = $creator;
    }

    /**
     * @return User|null
     */
    public function getModerator(): ?User {
        return $this->moderator;
    }

    /**
     * @param User|null $moderator
     */
    public function setModerator(?User $moderator): void {
        $this->moderator = $moderator;
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
     * @return Investor|null
     */
    public function getInvestor(): ?Investor
    {
        return $this->investor;
    }

    /**
     * @param Investor|null $investor
     */
    public function setInvestor(?Investor $investor): void
    {
        $this->investor = $investor;
    }


}