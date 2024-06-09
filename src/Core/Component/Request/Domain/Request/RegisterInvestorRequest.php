<?php

namespace Accel\App\Core\Component\Request\Domain\Request;

use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Auth\UserId;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;
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
