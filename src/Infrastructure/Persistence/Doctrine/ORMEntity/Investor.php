<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'investor')]
class Investor
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column]
    private bool $isActive;

    #[ORM\Column]
    private string $type;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private ?string $description = null;

    #[ORM\Column]
    private ?string $legalName = null;

    #[ORM\Column]
    private ?string $address = null;

    #[ORM\Column]
    private ?string $inn = null;

    #[ORM\Column]
    private ?string $ogrn = null;

    #[ORM\Column]
    private ?string $kpp = null;

    #[ORM\Column]
    private ?string $okpo = null;

    #[ORM\Column]
    private ?string $bik = null;

    #[ORM\Column]
    private int $createdAt;

    #[ORM\Column]
    private ?int $updatedAt;

    /** @var Collection<Tag> */
    #[ORM\ManyToMany( targetEntity: Tag::class )]
    private Collection $tags;

    /** @var Collection<User> */
    #[ORM\ManyToMany( targetEntity: User::class )]
    private Collection $users;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
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
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
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
    public function getLegalName(): ?string
    {
        return $this->legalName;
    }

    /**
     * @param string|null $legalName
     */
    public function setLegalName(?string $legalName): void
    {
        $this->legalName = $legalName;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getInn(): ?string
    {
        return $this->inn;
    }

    /**
     * @param string|null $inn
     */
    public function setInn(?string $inn): void
    {
        $this->inn = $inn;
    }

    /**
     * @return string|null
     */
    public function getOgrn(): ?string
    {
        return $this->ogrn;
    }

    /**
     * @param string|null $ogrn
     */
    public function setOgrn(?string $ogrn): void
    {
        $this->ogrn = $ogrn;
    }

    /**
     * @return string|null
     */
    public function getKpp(): ?string
    {
        return $this->kpp;
    }

    /**
     * @param string|null $kpp
     */
    public function setKpp(?string $kpp): void
    {
        $this->kpp = $kpp;
    }

    /**
     * @return string|null
     */
    public function getOkpo(): ?string
    {
        return $this->okpo;
    }

    /**
     * @param string|null $okpo
     */
    public function setOkpo(?string $okpo): void
    {
        $this->okpo = $okpo;
    }

    /**
     * @return string|null
     */
    public function getBik(): ?string
    {
        return $this->bik;
    }

    /**
     * @param string|null $bik
     */
    public function setBik(?string $bik): void
    {
        $this->bik = $bik;
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