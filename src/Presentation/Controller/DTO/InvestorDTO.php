<?php

namespace Accel\App\Presentation\Controller\DTO;

use Accel\Extension\Helpers\ConstructableFromArrayInterface;
use Accel\Extension\Helpers\ConstructableFromArrayTrait;

class InvestorDTO implements ConstructableFromArrayInterface
{
    use ConstructableFromArrayTrait;

    /** @var string[] */
    public readonly array $interestsList;

    /** @var string[] */
    public readonly array $membersList;

    public readonly array $requisites;

    public function __construct(
        private readonly string  $interests,
        private readonly string  $members,
        public  readonly string  $id,
        public  readonly bool    $isActive,
        public  readonly string  $type,
        public  readonly string  $name,
        public  readonly int     $createdAt,
        public  readonly ?string $description = null,
        private readonly ?string $legalName = null,
        private readonly ?string $address = null,
        private readonly ?string $inn = null,
        private readonly ?string $ogrn = null,
        private readonly ?string $kpp = null,
        private readonly ?string $okpo = null,
        private readonly ?string $bik = null,
    ) {
        $this->interestsList = json_decode($interests);
        $this->membersList = json_decode($this->members);
        $this->requisites = [
            'legalName' => $this->legalName ?? '',
            'address' => $this->address ?? '',
            'INN' => $this->inn ?? '',
            'OGRN' => $this->ogrn ?? '',
            'KPP' => $this->kpp ?? '',
            'OKPO' => $this->okpo ?? '',
            'BIK' => $this->bik ?? '',
        ];
    }
}