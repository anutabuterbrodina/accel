<?php

namespace App\Core\Component\Project\Application\DTO;

use App\Core\SharedKernel\Component\Project\ProjectId;

class UpdateProjectCommonDataDTO
{
    public function __construct(
        private readonly ProjectId $id,
        private readonly string    $name,
        private readonly string    $description,
    ) {}

    public function getId(): ProjectId {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }
}
