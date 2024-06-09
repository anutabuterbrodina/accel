<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine\Mapper;

use Accel\App\Core\Component\Request\Domain\Request\ChangeInvestorRequisitesRequest as ChangeInvestorReq;
use Accel\App\Core\Component\Request\Domain\Request\ChangeProjectBusinessDataRequest as ChangeProjectReq;
use Accel\App\Core\Component\Request\Domain\Request\RegisterInvestorRequest as RegisterInvestorReq;
use Accel\App\Core\Component\Request\Domain\Request\RegisterProjectRequest as RegisterProjectReq;
use Accel\App\Core\Component\Request\Domain\Request\StatusesEnum;
use Accel\App\Core\Component\Request\Domain\Request\TypesEnum;
use Accel\App\Core\Port\RequestMapperInterface;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Auth\UserId;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Project as ProjectORM;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Investor as InvestorORM;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Request as RequestORM;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\User;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\User as UserORM;
use Doctrine\ORM\EntityManagerInterface;

class RequestMapper implements RequestMapperInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private ?RequestORM $requestORM = null,

        // TODO: Добавить свойство для сохранения сущностей, с которыми маппер умеет работать
    ) {}

    public function isNew(): bool {
        return $this->requestORM === null;
    }

    /** @param ChangeInvestorReq|ChangeProjectReq|RegisterInvestorReq|RegisterProjectReq $request */
    public function mapToORM($request): RequestORM {
        $requestORM = $this->requestORM ?? new RequestORM();

        $requestORM->setStatus($request->getStatus()->value);

        $targetEntity = $request->getTargetEntityId();

        if (isset($targetEntity) && $targetEntity instanceof ProjectId) {
            $requestORM->setProject($this->findProjectById($targetEntity));
        }

        if (isset($targetEntity) && $targetEntity instanceof InvestorId) {
            $requestORM->setProject($this->findProjectById($targetEntity));
        }

        if ($this->isNew()) {
            $requestORM->setId($request->getId()->toScalar());
            $requestORM->setType($request->getType()->value);
            $requestORM->setCreatorComment($request->getCreatorComment());
            $requestORM->setCreatedAt(time());
            $requestORM->setContent(json_encode($request->getContent()));

            $creatorId = $request->getCreator()->toScalar();
            $requestORM->setCreator($this->findUserById($creatorId));
        } else {
            $requestORM->setUpdatedAt(time());
            $requestORM->setRejectReason($request->getRejectReason()?->value);
            $requestORM->setRejectMessage($request->getRejectMessage());

            $old = $this->requestORM;

            if ($old->getModerator()->getId() !== $newModeratorId = $request->getModerator()->toScalar()) {
                $requestORM->setModerator($this->findUserById($newModeratorId));
            }
        }

        return $requestORM;
    }

    private function findUserById(string $id): UserORM {
        return $this->em->getRepository(UserORM::class)->findOneBy(['id' => $id]);
    }

    private function findProjectById(string $id): ProjectORM {
        return $this->em->getRepository(UserORM::class)->findOneBy(['id' => $id]);
    }

    /**
     * @param string[] $idList
     * @return UserORM[]
     */
    private function findUsersById(array $idList): array {
        return $this->em->getRepository(UserORM::class)->findBy(['id' => $idList]);
    }

    /** @param RequestORM $requestORM */
    public function mapToDomain($requestORM): RegisterProjectReq
                                            | RegisterInvestorReq
                                            | ChangeInvestorReq
                                            | ChangeProjectReq {
        $this->requestORM = $requestORM;

        $creatorId = new UserId($requestORM->getCreator()->getId());
        $moderatorId = new UserId($requestORM->getModerator()?->getId());
        $projectId = new ProjectId($requestORM->getProject()?->getId());
        $investorId = new InvestorId($requestORM->getInvestor()?->getId());

        $content = json_decode($requestORM->getContent(), true);

        switch ($type = $requestORM->getType()) {
            case TypesEnum::RegisterInvestor->value:
                $this->mapToRegisterInvestor($requestORM, $creatorId, $moderatorId, $investorId, $content);

            case TypesEnum::RegisterProject->value:
                $this->mapToRegisterProject($requestORM, $creatorId, $moderatorId, $projectId, $content);

            case TypesEnum::ChangeInvestorRequisites->value:
                throw new \Exception('В процессе...');

            case TypesEnum::ChangeProjectBusinessData->value:
                throw new \Exception('В процессе...');

            default:
                throw new \Exception('Нет класса для такого типа заявки: ' . $type);
        }
    }

    private function mapToRegisterProject(
        RequestORM $requestORM,
        UserId $creatorId,
        UserId $moderatorId,
        ProjectId $projectId,
        array $content,
    ): RegisterProjectReq {
        $tags = [];
        foreach ($content['projectTags'] as $tagName) {
            $tags[] = Tag::of($tagName);
        }

        return new RegisterProjectReq(
            new RequestId($requestORM->getId()),
            TypesEnum::from($requestORM->getType()),
            StatusesEnum::from($requestORM->getStatus()),
            $creatorId,
            $requestORM->getCreatorComment(),
            $moderatorId,
            $requestORM->getRejectReason(),
            $requestORM->getRejectMessage(),
            $projectId,
            $content['projectName'],
            $content['projectDescription'],
            $content['projectBusinessPlan'],
            $content['projectRequiredInvestmentMin'],
            $content['projectRequiredInvestmentMax'],
            $tags
        );
    }

    private function mapToRegisterInvestor(
        RequestORM $requestORM,
        UserId $creatorId,
        UserId $moderatorId,
        InvestorId $investorId,
        array $content,
    ): RegisterInvestorReq {
        $tags = [];
        foreach ($content['interests'] as $tagName) {
            $tags[] = Tag::of($tagName);
        }

        return new RegisterInvestorReq(
            new RequestId($requestORM->getId()),
            TypesEnum::from($requestORM->getType()),
            StatusesEnum::from($requestORM->getStatus()),
            $creatorId,
            $requestORM->getCreatorComment(),
            $moderatorId,
            $requestORM->getRejectReason(),
            $requestORM->getRejectMessage(),
            $content['investorName'],
            $content['investorDescription'],
        );
    }
}