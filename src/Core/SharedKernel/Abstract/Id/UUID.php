<?php

namespace App\Core\SharedKernel\Abstract\Id;

use Ramsey\Uuid\Uuid as RamseyUuid;

class UUID
{
    /**
     * @var string
     */
    private $uuid;

    public function __construct(string $uuid)
    {
        if (!self::isValid($uuid)) {
            throw new \Exception('Неверный UUID: ' . $uuid);
        }

        $this->uuid = $uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

    public static function isValid(string $uuid): bool
    {
        return RamseyUuid::isValid($uuid);
    }
}
