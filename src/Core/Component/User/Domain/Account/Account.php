<?php

namespace Accel\App\Core\Component\User\Domain\Account;

use Accel\Extension\Entity\AbstractEntity;

class Account extends AbstractEntity
{
    public function __construct(
        private readonly AccountId $id,
        private readonly TypesEnum $type,
    ) {}


    /** Публичные методы */


    /** Приватные методы */


    /** Immutable getters */

    public function getId(): AccountId
    {
        return $this->id;
    }

    public function getType(): TypesEnum
    {
        return $this->type;
    }
}
