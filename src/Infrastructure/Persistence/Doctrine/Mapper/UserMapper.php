<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine\Mapper;

use Accel\App\Core\Component\Auth\Domain\User\User;
use Accel\App\Core\Port\MapperInterface;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\User as UserORM;
use Doctrine\ORM\EntityManager;

class UserMapper implements MapperInterface
{
    public function __construct(
        private readonly EntityManager $em,
    ) {}

    /** @param User $user */
    public function mapToORM($user): UserORM {
        $userORM = new UserORM();

        $userORM->setId();
        $userORM->setAccount();
        $userORM->setName();
        $userORM->setSurname();
        $userORM->setEmail();
        $userORM->setPhone();
        $userORM->setPassword();
        $userORM->setCreatedAt(time());

        return $userORM;
    }

    /** @param ProjectORM $projectORM */
    public function mapToDomain($projectORM): Project {

        $tags = [];
        foreach ($projectORM->getTags() as $tag) {
            $tags = Tag::of($tag->getName());
        }

        $user = new UserId();

        return new Project(
            new ProjectId($projectORM->getId()),
            StatusesEnum::from($projectORM->getStatus()),
            new DescriptionData(
                $projectORM->getName(),
                $projectORM->getDescription(),
            ),
            new BusinessData(
                FileObject::of($projectORM->getBusinessPlanPath()),
                InvestmentRangeEnum::from($projectORM->getInvestmentMin()),
                InvestmentRangeEnum::from($projectORM->getInvestmentMax()),
                $tags,
            ),
            $user,
            $user,
            [$user],
        );
    }

    public function isNew(): bool
    {
        // TODO: Implement isNew() method.
    }
}