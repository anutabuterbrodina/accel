<?php

declare(strict_types=1);

namespace Accel\App\Core\Port;

use Accel\App\Core\Port\Mapper\MapperInterface;
use Accel\Extension\Entity\AbstractEntity;
use Accel\Extension\Entity\EntityInterface;
use Accel\Extension\Helpers\ConstructableFromArrayInterface;

/**
 * This class can be used by an adapter to wrap a result array, or the adapter can have its own collection
 * which must implement the ResultCollectionInterface.
 *
 * @internal this class should not be used for type-hinting, use the ResultCollectionInterface instead
 */
final class ResultCollection implements \JsonSerializable
{
    /**
     * @var array
     */
    private $itemList;

    public function __construct(array $itemList = [])
    {
        $this->itemList = $itemList;
    }

    public function getSingleResult()
    {
        $count = $this->count();

        if ($count > 1) {
            throw new \Exception('NotUniqueQueryResultException');
        }

        if ($count === 0) {
            throw new \Exception('EmptyQueryResultException');
        }

        return \reset($this->itemList);
    }

    public function count(): int
    {
        return \count($this->itemList);
    }


    /** @param string|EntityInterface $fqcn */
    public function mapSingleResultTo(string | EntityInterface $fqcn, MapperInterface $mapper): AbstractEntity {
//        if (!is_subclass_of($fqcn, EntityInterface::class)) {
//            throw new \Exception('Это не сущность: ' . $fqcn);
//        }

        // TODO: Добавить проверку на то, что маппер умеет работать с переданным типом сущности

        $item = $this->getSingleResult();
        if (\is_array($item)) {
            throw new \Exception('Can not map from array');
        }

        return $mapper->mapToDomain($item);
    }

    /** @param string|ConstructableFromArrayInterface $fqcn */
    public function hydrateResultItemsAs(string | ConstructableFromArrayInterface $fqcn): self
    {
        if (!is_subclass_of($fqcn, ConstructableFromArrayInterface::class)) {
            throw new \Exception('NotConstructableFromArrayException: ' . $fqcn);
        }

        $item = reset($this->itemList);
        if (!\is_array($item)) { // we assume all items have the same type
            throw new EmptyListException('CanOnlyHydrateFromArrayException: ' . $item);
        }

        $hydratedItemList = [];
        foreach ($this->itemList as $item) {
            $hydratedItemList[] = $fqcn::fromArray($item);
        }

        return new self($hydratedItemList);
    }

    /**
     * @param string $fqcn
     */
    public function hydrateSingleResultAs(string $fqcn)
    {
        if (!is_subclass_of($fqcn, ConstructableFromArrayInterface::class)) {
            throw new \Exception('NotConstructableFromArrayException: ' . $fqcn);
        }

        $item = $this->getSingleResult();
        if (!\is_array($item)) { // we assume all items have the same type
            throw new \Exception('CanOnlyHydrateFromArrayException: ' . $item);
        }

        return $fqcn::fromArray($item);
    }

    public function toArray(): array
    {
        return $this->itemList;
    }

    private function getFirstElement()
    {

    }

    public function jsonSerialize(): mixed
    {
        return $this->itemList;
    }
}
