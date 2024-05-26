<?php

namespace App\Core\SharedKernel\Common\ValueObject;

use App\Core\SharedKernel\Abstract\ValueObject\AbstractValueObject;

final class Requisites extends AbstractValueObject
{
    const SCALAR_STRING_DELIMITER = '|';

    /**
     * @var string|null
     */
    private ?string $legalName;

    /**
     * @var string|null
     */
    private ?string $address;

    /**
     * @var string|null
     */
    private ?string $INN;

    /**
     * @var string|null
     */
    private ?string $OGRN;

    /**
     * @var string|null
     */
    private ?string $KPP;

    /**
     * @var string|null
     */
    private ?string $OKPO;

    /**
     * @var string|null
     */
    private ?string $BIK;

    private function __construct(
      ?string $legalName,
      ?string $address,
      ?string $INN,
      ?string $OGRN,
      ?string $KPP,
      ?string $OKPO,
      ?string $BIK,
    ) {
        $this->legalName = $legalName;
        $this->address = $address;
        $this->INN = $INN;
        $this->OGRN = $OGRN;
        $this->KPP = $KPP;
        $this->OKPO = $OKPO;
        $this->BIK = $BIK;
    }

    protected function toScalar(): string
    {
        $format = '%2$s %1$s %3$s %1$s %4$s %1$s %5$s %1$s %6$s %1$s %7$s %1$s %8$s';
        return sprintf(
            $format,
            self::SCALAR_STRING_DELIMITER,
            $this->legalName,
            $this->address,
            $this->INN,
            $this->OGRN,
            $this->KPP,
            $this->OKPO,
            $this->BIK,
        );
    }
}
