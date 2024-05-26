<?php

namespace App\Core\Component\Investor\Domain\Request;

use App\Core\SharedKernel\Common\ValueObject\Tag;
use App\Core\SharedKernel\Component\Auth\UserId;
use App\Core\SharedKernel\Component\Investor\InvestorId;
use App\Core\SharedKernel\Component\Request\AbstractRequest;
use App\Core\SharedKernel\Component\Request\RejectReasonsEnum;
use App\Core\SharedKernel\Component\Request\RequestId;
use App\Core\SharedKernel\Component\Request\StatusesEnum;
use App\Core\SharedKernel\Component\Request\TypesEnum;
use DateTimeImmutable;

class RegisterInvestorRequest
{
    /**
     * @var string
     */
    private string $investorName;

    /**
     * @var string
     */
    private string $investorDescription;

    /**
     * @var Tag[]
     */
    private array $interests;

    /**
     * @var InvestorId|null
     */
    private ?InvestorId $investor;


    public function __construct(
        RequestId               $id,
        TypesEnum               $type,
        StatusesEnum            $status,
        string                  $description,
        UserId                  $creator,
        DateTimeImmutable       $createdAt,
        ?RejectReasonsEnum      $rejectReason,
        ?string                 $rejectMessage,
        string                  $investorName,
        string                  $investorDescription,
        array                   $interests,
        ?InvestorId             $investor = null,
    ) {
//        parent::__construct($id, $type, $status, $description, $creator, $createdAt, $rejectReason, $rejectMessage);

        $this->investorName = $investorName;
        $this->investorDescription = $investorDescription;
        $this->interests = $interests;
        $this->investor = $investor;
    }


    /** Factory method */

    /**
     * @param Tag[] $interests
     */
    public static function create(
        UserId                  $creator,
        string                  $description,
        string                  $investorName,
        string                  $investorDescription,
        array                   $interests,
    ): self {
        return new self(
            new RequestId(),
            TypesEnum::RegisterInvestor,
            StatusesEnum::OnModeration,
            $description,
            $creator,
            new DateTimeImmutable(),
            null,
            null,
            $investorName,
            $investorDescription,
            $interests,
        );
    }


    /** Public methods */

    public function accept(): void
    {
        $this->status = StatusesEnum::Accepted;
    }


    /** Private methods */


}
