<?php

namespace Accel\Extension\Entity;

abstract class AbstractEntity implements EntityInterface
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
