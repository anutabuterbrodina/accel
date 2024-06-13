<?php

namespace Accel\App\Core\Component\User\Domain\Account;

use Accel\Extension\Entity\AbstractEntity;

class Account extends AbstractEntity
{
    public function __construct(
        private readonly AccountId $id,
    ) {}


    /** Публичные методы */


    /** Приватные методы */


    /** Immutable getters */

    public function getId(): AccountId
    {
        return $this->id;
    }
}
