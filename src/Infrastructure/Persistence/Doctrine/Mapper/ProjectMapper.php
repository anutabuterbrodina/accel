<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine\Mapper;

use Accel\App\Core\Component\Project\Domain\Project\BusinessData;
use Accel\App\Core\Component\Project\Domain\Project\DescriptionData;
use Accel\App\Core\Component\Project\Domain\Project\Project;
use Accel\App\Core\Component\Project\Domain\Project\StatusesEnum;
use Accel\App\Core\Port\Mapper\ProjectMapperInterface;
use Accel\App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\FileObject;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Project as ProjectORM;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Tag as TagORM;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\User;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\User as UserORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class ProjectMapper implements ProjectMapperInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private ?ProjectORM $projectORM = null,
    ) {}

    public function isNew(): bool {
        return $this->projectORM === null;
    }

    /** @param Project $project */
    public function mapToORM($project): ProjectORM {
        $projectORM = $this->projectORM ?? new ProjectORM();

        $projectORM->setStatus($project->getStatus()->value);
        $projectORM->setName($project->getDescriptionData()->getProjectName());
        $projectORM->setDescription($project->getDescriptionData()->getDescription());
        $projectORM->setBusinessPlanPath($project->getBusinessData()->getBusinessPlan()->toScalar());
        $projectORM->setInvestmentMin($project->getBusinessData()->getRequiredInvestmentMin()->value);
        $projectORM->setInvestmentMax($project->getBusinessData()->getRequiredInvestmentMax()->value);

        $idsList = array_map(fn(UserId $userId) => $userId->toScalar(), $project->getTeam());
        $projectORM->setUsers(new ArrayCollection($this->findUsersById($idsList)));

        $tagNamesList = array_map(fn(Tag $tag) => $tag->toScalar(), $project->getBusinessData()->getTags());
        $projectORM->setTags(new ArrayCollection($this->findTagsByName($tagNamesList)));


        $projectORM->setContact($this->findUserById($project->getContact()->toScalar()));
        $projectORM->setOwner($this->findUserById($project->getOwner()->toScalar()));

        if (null !== $old = $this->projectORM) {
            $projectORM->setUpdatedAt(time());
        } else {
            $projectORM->setId($project->getId()->toScalar());
            $projectORM->setCreatedAt(time());
        }

        return $projectORM;
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

    /** @param ProjectORM $projectORM */
    public function mapToDomain($projectORM): Project {
        $this->projectORM = $projectORM;

        $tags = [];
        foreach ($projectORM->getTags() as $tag) {
            $tags[] = Tag::of($tag->getName());
        }

        $members = [];
        foreach ($projectORM->getUsers() as $member) {
            $members[] = new UserId($member->getId());
        }

        $contact = new UserId($projectORM->getContact()->getId());
        $owner = new UserId($projectORM->getOwner()->getId());

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
            $contact,
            $owner,
            $members
        );
    }
}