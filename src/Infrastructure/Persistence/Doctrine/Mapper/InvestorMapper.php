<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine\Mapper;

use Accel\App\Core\Component\Investor\Domain\Investor\DescriptionData;
use Accel\App\Core\Component\Investor\Domain\Investor\Investor;
use Accel\App\Core\Component\Investor\Domain\Investor\TypesEnum;
use Accel\App\Core\Port\Mapper\InvestorMapperInterface;
use Accel\App\Core\SharedKernel\Common\ValueObject\Requisites;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Investor as InvestorORM;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Tag as TagORM;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\User as UserORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class InvestorMapper implements InvestorMapperInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private ?InvestorORM $investorORM = null,
    ) {}

    public function isNew(): bool {
        return $this->investorORM === null;
    }

    /** @param Investor $investor */
    public function mapToORM($investor): InvestorORM {
        $investorORM = $this->investorORM ?? new InvestorORM();

        $investorORM->setId($investor->getId()->toScalar());
        $investorORM->setIsActive($investor->isActive());
        $investorORM->setType($investor->getType()->value);
        $investorORM->setName($investor->getDescriptionData()->getName());
        $investorORM->setDescription($investor->getDescriptionData()->getDescription());
        $investorORM->setLegalName($investor->getRequisites()->getLegalName());
        $investorORM->setAddress($investor->getRequisites()->getAddress());
        $investorORM->setInn($investor->getRequisites()->getInn());
        $investorORM->setOgrn($investor->getRequisites()->getOgrn());
        $investorORM->setKpp($investor->getRequisites()->getKpp());
        $investorORM->setOkpo($investor->getRequisites()->getOkpo());
        $investorORM->setBik($investor->getRequisites()->getBik());

        $idsList = array_map(fn(UserId $userId) => $userId->toScalar(), $investor->getMembers());
        $investorORM->setUsers(new ArrayCollection($this->findUsersById($idsList)));

        $tagNamesList = array_map(fn(Tag $tag) => $tag->toScalar(), $investor->getInterests());
        $investorORM->setTags(new ArrayCollection($this->findTagsByName($tagNamesList)));

        $investorORM->setOwner($this->findUserById($investor->getOwner()->toScalar()));

        if (null !== $old = $this->investorORM) {
            $investorORM->setUpdatedAt(time());
        } else {
            $investorORM->setId($investor->getId()->toScalar());
            $investorORM->setCreatedAt(time());
        }

        return $investorORM;
    }

    private function findUserById(string $id): UserORM {
        return $this->em->getRepository(UserORM::class)->findOneBy(['id' => $id]);
    }

    /**
     * @param string[] $idList
     * @return UserORM[]
     */
    private function findUsersById(array $idList): array {
        return $this->em->getRepository(UserORM::class)->findBy(['id' => $idList]);
    }

    /**
     * @param string[] $tagNameList
     * @return TagORM[]
     */
    private function findTagsByName(array $tagNameList): array {
        return $this->em->getRepository(TagORM::class)->findBy(['name' => $tagNameList]);
    }

    /** @param InvestorORM $investorORM */
    public function mapToDomain($investorORM): Investor {
        $this->investorORM = $investorORM;

        $interests = [];
        foreach ($investorORM->getTags() as $tag) {
            $interests[] = Tag::of($tag->getName());
        }

        $members = [];
        foreach ($investorORM->getUsers() as $member) {
            $members[] = new UserId($member->getId());
        }

        $owner = new UserId($investorORM->getOwner()->getId());

        return new Investor(
            new InvestorId($investorORM->getId()),
            $investorORM->isActive(),
            TypesEnum::from($investorORM->getType()),
            new DescriptionData(
                $investorORM->getName(),
                $investorORM->getDescription(),
            ),
            new Requisites(
                $investorORM->getLegalName(),
                $investorORM->getAddress(),
                $investorORM->getInn(),
                $investorORM->getOgrn(),
                $investorORM->getKpp(),
                $investorORM->getOkpo(),
                $investorORM->getBik(),
            ),
            $owner,
            $members,
            $interests,
        );
    }
}