<?php

namespace App\Infrastructure\Persistence\Doctrine\Mapper;

use App\Core\Component\Project\Domain\Project\BusinessData;
use App\Core\Component\Project\Domain\Project\DescriptionData;
use App\Core\Component\Project\Domain\Project\Project;
use App\Core\Component\Project\Domain\Project\StatusesEnum;
use App\Core\Port\Mapper\DomainProjectMapperInterface;
use App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use App\Core\SharedKernel\Common\ValueObject\FileObject;
use App\Core\SharedKernel\Common\ValueObject\Tag;
use App\Core\SharedKernel\Component\Auth\UserId;
use App\Core\SharedKernel\Component\Project\ProjectId;
use App\Infrastructure\Persistence\Doctrine\ORMEntity\ProjectORM;
use Doctrine\Common\Collections\ArrayCollection;

class DomainProjectMapper implements DomainProjectMapperInterface
{
    public function mapToORM(Project $entity) {
        $tags = new ArrayCollection();
//        foreach ($entity->getBusinessData()->getTags() as $tag) {
//            $tags->add(TagMapper::mapToOrm($tag));
//        }

        $projectORM = new ProjectORM();

        $projectORM->setProjectId($entity->getId()->toScalar());
        $projectORM->setStatus($entity->getStatus()->value);
        $projectORM->setName($entity->getDescriptionData()->getProjectName());
        $projectORM->setDescription($entity->getDescriptionData()->getDescription());
        $projectORM->setBusinessPlanPath($entity->getBusinessData()->getBusinessPlan()->toScalar());
        $projectORM->setInvestmentMin($entity->getBusinessData()->getRequiredInvestmentMin()->value);
        $projectORM->setInvestmentMax($entity->getBusinessData()->getRequiredInvestmentMax()->value);
        $projectORM->setContactEmail('test@test.com');
        $projectORM->setCreatedAt(time());
        $projectORM->setTags($tags);

        return $projectORM;
    }

    public function mapToDomain(ProjectORM $entityORM): Project {

        $tags = [];
        foreach ($entityORM->getTags() as $tag) {
            $tags = Tag::of($tag->getName());
        }

        $user = new UserId();

        return new Project(
            new ProjectId($entityORM->getProjectId()),
            StatusesEnum::from($entityORM->getStatus()),
            new DescriptionData(
                $entityORM->getName(),
                $entityORM->getDescription(),
            ),
            new BusinessData(
                FileObject::of($entityORM->getBusinessPlanPath()),
                InvestmentRangeEnum::from($entityORM->getInvestmentMin()),
                InvestmentRangeEnum::from($entityORM->getInvestmentMax()),
                $tags,
            ),
            $user,
            $user,
            [$user],
        );
    }
}