<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'project')]
class Project
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column]
    private string $status;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private ?string $description = null;

    #[ORM\Column]
    private string $region = '';

    #[ORM\Column]
    private string $businessPlanPath;

    #[ORM\Column]
    private int $investmentMin;

    #[ORM\Column]
    private int $investmentMax;

    #[ORM\Column]
    private int $createdAt;

    #[ORM\Column]
    private ?int $updatedAt;

    /** @var Collection<Bookmark> */
    #[ORM\OneToMany(targetEntity: Bookmark::class, mappedBy: 'project')]
    private Collection $bookmarks;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $owner;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $contact;

    /** @var Collection<Tag> */
    #[ORM\ManyToMany(targetEntity: Tag::class)]
    private Collection $tags;

    /** @var Collection<User> */
    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $users;

    public function __construct() {
        $this->tags = new ArrayCollection();
    }

    public function getOwner(): User {
        return $this->owner;
    }

    public function setOwner(User $owner): void {
        $this->owner = $owner;
    }

    public function getContact(): User {
        return $this->contact;
    }

    public function setContact(User $contact): void {
        $this->contact = $contact;
    }

    /**
     * @return Collection<Bookmark>
     */
    public function getBookmarks(): Collection
    {
        return $this->bookmarks;
    }

    /**
     * @param Collection<Bookmark> $bookmarks
     */
    public function setBookmarks(Collection $bookmarks): void
    {
        $this->bookmarks = $bookmarks;
    }

    /**
     * @return Collection<User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param Collection<User> $users
     */
    public function setUsers(Collection $users): void
    {
        $this->users = $users;
    }

    /**
     * @return Collection<Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @param Collection<Tag> $tags
     */
    public function setTags(Collection $tags): void
    {
        $this->tags = $tags;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param string|null $region
     */
    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getBusinessPlanPath(): string
    {
        return $this->businessPlanPath;
    }

    /**
     * @param string $businessPlanPath
     */
    public function setBusinessPlanPath(string $businessPlanPath): void
    {
        $this->businessPlanPath = $businessPlanPath;
    }

    /**
     * @return string
     */
    public function getInvestmentMin(): string
    {
        return $this->investmentMin;
    }

    /**
     * @param string $investmentMin
     */
    public function setInvestmentMin(string $investmentMin): void
    {
        $this->investmentMin = $investmentMin;
    }

    /**
     * @return string
     */
    public function getInvestmentMax(): string
    {
        return $this->investmentMax;
    }

    /**
     * @param string $investmentMax
     */
    public function setInvestmentMax(string $investmentMax): void
    {
        $this->investmentMax = $investmentMax;
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