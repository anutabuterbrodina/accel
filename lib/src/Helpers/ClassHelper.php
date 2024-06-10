<?php

namespace Accel\Extension\Helpers;

use function Accel\Extension\mb_substr;

class ClassHelper
{
    public static function extractClassName(string $classFQCN): string {
        return mb_substr($classFQCN, mb_strrpos($classFQCN, '\\') + 1);
    }
}