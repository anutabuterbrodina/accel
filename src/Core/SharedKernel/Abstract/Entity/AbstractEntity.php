<?php

namespace App\Core\SharedKernel\Abstract\Entity;

abstract class AbstractEntity
{
    protected function contains($item, $list): bool
    {
        return \in_array($item, (array) $list, true);
    }

    protected function getKey($item, $list): false | int | string
    {
        return \array_search($item, (array) $list, true);
    }
}
