<?php

namespace Accel\App\Core\SharedKernel\Common\ValueObject;

use Accel\App\Core\SharedKernel\Abstract\ValueObject\AbstractValueObject;

final class FileObject extends AbstractValueObject implements \JsonSerializable
{
    /**
     * @var string
     */
    private string $path;

    private function __construct(string $path)
    {
        $this->path = $path;
    }

    public static function of(string $value): self {
        return new FileObject($value);
    }

    public function toScalar(): string
    {
        return $this->path;
    }

    public function jsonSerialize(): mixed
    {
        return $this->path;
    }
}
