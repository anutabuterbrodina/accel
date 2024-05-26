<?php

namespace App\Core\Component\Investor\Domain\Investor;

class DescriptionData
{
    public function __construct(
        private readonly string $name,
        private readonly string $description,
    ) {}

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }
}
