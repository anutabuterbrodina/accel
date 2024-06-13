<?php

declare(strict_types=1);

namespace Accel\Extension\Helpers;

final class TypeHelper
{
    public static function getType($subject): string
    {
        $type = \gettype($subject);

        switch ($type) {
            case 'object':
                return \get_class($subject);
            case 'array':
                return (empty($subject) ? '' : self::getType(\reset($subject))) . '[]';
            default:
                return $type;
        }
    }
}
