<?php

namespace App\Core\Port;

interface MapperInterface
{
    public static function mapToORM();

    public static function mapToDomain();
}