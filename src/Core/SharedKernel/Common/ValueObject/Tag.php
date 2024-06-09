<?php

namespace Accel\App\Core\SharedKernel\Common\ValueObject;

use Accel\App\Core\SharedKernel\Abstract\ValueObject\AbstractValueObject;

final class Tag extends AbstractValueObject implements \JsonSerializable
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

    public function jsonSerialize(): string
    {
        return $this->name;
    }
}
