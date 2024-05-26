<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Core\Port\PersistenceServiceInterface;
use App\Core\Port\QueryServiceInterface;
use App\Core\Port\QueryWrapperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class PersistenceService implements QueryServiceInterface, PersistenceServiceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function query(QueryWrapperInterface $queryWrapper)
    {
        /** @var Query $query */
        $query = $queryWrapper->getQuery();

        if (!($query instanceof Query)) {
            throw new \Exception('Получили инст ' . \get_class($query) . '. Нужен инст ' . Query::class );
        }

//        return $query->execute(hydrationMode: 1);
        return $query->execute();
    }

    public function upsert($entity): void {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete($entity): void {
        $this->entityManager->remove($entity);
    }
}