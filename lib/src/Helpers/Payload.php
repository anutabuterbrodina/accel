<?php

namespace Accel\Extension\Helpers;

class Payload
{
    private const ISSUER = 'localhost';
    private const EXPIRATION = 36000;

    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $surname,
        private readonly string $email,
        private readonly string $phone,
    ) {}

    public function toArray(): array {
        return [
            "id"        => $this->id,
            "name"      => $this->name,
            "surname"   => $this->surname,
            "email"     => $this->email,
            "phone"     => $this->phone,
            "issuer"    => self::ISSUER,
            "createAt"  => time(),
            "expiresIn" => time() + self::EXPIRATION,
        ];
    }
}