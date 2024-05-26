<?php

namespace App\Core\SharedKernel\Abstract\ValueObject;

abstract class AbstractValueObject
{
    abstract protected function toScalar(): string|int|bool;

    private function equals($valueObject): bool {
        // TODO: Make structure equivalence checker with ReflectionAPI
        return true;
    }
}
