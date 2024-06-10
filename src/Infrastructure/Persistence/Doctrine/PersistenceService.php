<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine;

use Accel\App\Core\Port\MapperInterface;
use Accel\App\Core\Port\PersistenceServiceInterface;
use Accel\App\Core\Port\QueryInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class PersistenceService implements QueryServiceInterface, PersistenceServiceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {}

    public function query(QueryInterface $queryWrapper): ResultCollection
    {
        /** @var Query $query */
        $query = $queryWrapper->getQuery();

        if (!($query instanceof Query)) {
            throw new \Exception('Получили инст ' . \get_class($query) . '. Нужен инст ' . Query::class );
        }

//        var_dump($query->getDQL());die;
//        var_dump($query->getParameters());die;
//        var_dump($query->getSQL());die;
//        var_dump($query->execute());die;

        return new ResultCollection($query->execute());
    }

    public function upsert($entity, MapperInterface $mapper = null): void {
        $entityORM = $mapper === null ? $entity : $mapper->mapToORM($entity);
        $this->em->persist($entityORM);
        $this->em->flush();
    }
}