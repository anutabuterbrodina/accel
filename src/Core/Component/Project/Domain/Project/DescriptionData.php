<?php

namespace Accel\App\Core\Component\Project\Domain\Project;

class DescriptionData
{
	public function __construct(
		private readonly string $projectName,
		private readonly string $description,
	) {}

	public function getProjectName(): string {
		return $this->projectName;
	}

	public function getDescription(): string {
		return $this->description;
	}
}