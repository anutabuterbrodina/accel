<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine\Mapper;

use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Tag as TagORM;
use Doctrine\ORM\EntityManager;

class TagMapper
{
    public function __construct(
        private readonly EntityManager $em,
    ) {}

    public function mapToOrm(Tag $tag): TagORM {
        /** @var TagORM $tagORM */
        $tagORM = $this->em->getRepository(TagORM::class)->findOneBy(['name' => $tag->toScalar()]);
        return $tagORM;
    }
}