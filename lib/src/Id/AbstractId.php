<?php

namespace Accel\Extension\Id;

abstract class AbstractId
{
    /** @var mixed $id */
    protected $id;

    public function __construct($id) {
        $this->validate($id);
        $this->id = $id;
    }

    abstract protected function isValid($value): bool;

    public function __toString(): string {
        return (string) $this->id;
    }

    public function jsonSerialize() {
        return $this->id;
    }

    public function equals($id): bool {
        return \get_class($this) === \get_class($id) && $this->id === $id->id;
    }

    protected function validate($id): void {
        if (!$this->isValid($id) ) {
            throw new \Exception( 'Невалидный ID: ' . $id );
        }
    }
}
