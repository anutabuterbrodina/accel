<?php

namespace App\Core\SharedKernel\Common\ValueObject;

use App\Core\SharedKernel\Abstract\ValueObject\AbstractValueObject;

final class Tag extends AbstractValueObject
{
    /**
     * @var string
     */
    private string $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function of(string $value): self {
        return new Tag($value);
    }

    public function toScalar(): string
    {
        return $this->name;
    }
}
