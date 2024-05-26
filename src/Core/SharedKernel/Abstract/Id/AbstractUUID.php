<?php

namespace App\Core\SharedKernel\Abstract\Id;

abstract class AbstractUUID extends AbstractId
{
    /**
     * @var string
     */
    protected $id;

    public function __construct(string $uuidString = null)
    {
        parent::__construct($uuidString ?? UuidGenerator::generateAsString());
    }

    public function toScalar(): string
    {
        return $this->id;
    }

    protected function isValid($value): bool
    {
        return \is_string($value) && UUID::isValid($value);
    }
}
