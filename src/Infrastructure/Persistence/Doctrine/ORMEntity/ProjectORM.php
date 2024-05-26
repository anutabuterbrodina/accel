<?php

namespace App\Infrastructure\Persistence\Doctrine\ORMEntity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'projects')]
class ProjectORM
{
    #[ORM\Id]
    #[ORM\Column]
    private string $projectId;

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
    private string $investmentMin;

    #[ORM\Column]
    private string $investmentMax;

    #[ORM\Column]
    private string $contactEmail;

    #[ORM\Column]
    private int $createdAt;

    #[ORM\Column]
    private ?int $updatedAt;

    /**
     * @var Collection<TagORM>
     */
    #[ORM\ManyToMany(targetEntity: TagORM::class, inversedBy: 'projects')]
    private Collection $tags;

    /**
     * @return Collection<TagORM>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @param Collection<TagORM> $tags
     */
    public function setTags(Collection $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getProjectId(): string
    {
        return $this->projectId;
    }

    /**
     * @param string $projectId
     */
    public function setProjectId(string $projectId): void
    {
        $this->projectId = $projectId;
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
     * @return string
     */
    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    /**
     * @param string $contactEmail
     */
    public function setContactEmail(string $contactEmail): void
    {
        $this->contactEmail = $contactEmail;
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