<?php

namespace Accel\App\Presentation\Controller\DTO;

use Accel\Extension\Helpers\ConstructableFromArrayInterface;
use Accel\Extension\Helpers\ConstructableFromArrayTrait;

class RequestDTO implements ConstructableFromArrayInterface
{
    use ConstructableFromArrayTrait;

    /** @var \stdClass */
    public readonly \stdClass $requestContent;

    public function __construct(
        private readonly string  $content,
        public  readonly string  $id,
        public  readonly string  $status,
        public  readonly string  $type,
        public  readonly string  $creatorId,
        public  readonly string  $contactEmail,
        public  readonly string  $creatorComment,
        public  readonly int     $createdAt,
        public  readonly ?string $rejectReason = null,
        public  readonly ?string $rejectMessage = null,
        public  readonly ?string $projectId = null,
        public  readonly ?string $investorId = null,
    ) {
        $this->requestContent = json_decode($this->content);
    }
}