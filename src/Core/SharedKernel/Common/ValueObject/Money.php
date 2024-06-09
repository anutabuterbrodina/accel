<?php

namespace Accel\App\Core\SharedKernel\Common\ValueObject;

use Accel\App\Core\SharedKernel\Abstract\ValueObject\AbstractValueObject;

final class Money extends AbstractValueObject
{
    /**
     * @var int
     */
    private int $amount;

    private function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    public static function of(int $value): self {
        return new Money($value);
    }

    public function toScalar(): int
    {
        return $this->amount;
    }
}
