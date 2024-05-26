<?php

namespace App\Core\SharedKernel\Abstract\Id;

use App\Core\SharedKernel\Abstract\ValueObject\AbstractValueObject;

abstract class AbstractId
{
    /**
     * @var mixed
     */
    protected $id;

    public function __construct($id)
{
    $this->validate($id);

    $this->id = $id;
}

    /**
     * This is an example of the Template pattern, where this method is defined (templated) and used here,
     * but implemented in a subclass.
     */
    abstract protected function isValid($value): bool;

    public function __toString(): string
{
    return (string) $this->id;
}

    public function jsonSerialize()
{
    return $this->id;
}

    /**
     * @param self $id
     */
    public function equals($id): bool
{
    return \get_class($this) === \get_class($id)
        && $this->id === $id->id;
}

    protected function validate($id): void
    {
        if ( !$this->isValid( $id ) ) {
            throw new \Exception( 'Невалидный ID: ' . $id );
        }
    }
}
