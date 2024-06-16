<?php

namespace Accel\App\Core\SharedKernel\Common\ValueObject;

use Accel\App\Core\SharedKernel\Abstract\ValueObject\AbstractValueObject;

final class Requisites extends AbstractValueObject implements \JsonSerializable
{
    const SCALAR_STRING_DELIMITER = '|';

    public function __construct(
        private readonly ?string $legalName,
        private readonly ?string $address,
        private readonly ?string $inn,
        private readonly ?string $ogrn,
        private readonly ?string $kpp,
        private readonly ?string $okpo,
        private readonly ?string $bik,
    ) {}

    public function toScalar(): string {
        $format = '%2$s %1$s %3$s %1$s %4$s %1$s %5$s %1$s %6$s %1$s %7$s %1$s %8$s';
        return sprintf(
            $format,
            self::SCALAR_STRING_DELIMITER,
            $this->legalName,
            $this->address,
            $this->inn,
            $this->ogrn,
            $this->kpp,
            $this->okpo,
            $this->bik,
        );
    }

    public function jsonSerialize(): array {
        return [
            "legalName" => $this->legalName,
            "address" => $this->address,
            "INN" => $this->inn,
            "OGRN" => $this->ogrn,
            "KPP" => $this->kpp,
            "OKPO" => $this->okpo,
            "BIK" => $this->bik,
        ];
    }



    public function getLegalName(): ?string {
        return $this->legalName;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function getInn(): ?string {
        return $this->inn;
    }

    public function getOgrn(): ?string {
        return $this->ogrn;
    }

    public function getKpp(): ?string {
        return $this->kpp;
    }

    public function getOkpo(): ?string {
        return $this->okpo;
    }

    public function getBik(): ?string {
        return $this->bik;
    }
}
