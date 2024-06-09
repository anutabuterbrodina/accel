<?php

namespace Accel\Extension\Id;

use Ramsey\Uuid\Uuid;

abstract class AbstractUUID extends AbstractId
{
    /** @var string */
    protected $id;

    public function __construct(string $uuidString = null) {
        parent::__construct($uuidString ?? Uuid::uuid4()->toString());
    }

    public function toScalar(): string {
        return $this->id;
    }

    protected function isValid($value): bool {
        return \is_string($value) && Uuid::isValid($value);
    }
}
