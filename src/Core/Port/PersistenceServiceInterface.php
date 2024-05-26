<?php

namespace App\Core\Port;

interface PersistenceServiceInterface
{
    public function upsert($entity): void;

    public function delete($entity): void;
}