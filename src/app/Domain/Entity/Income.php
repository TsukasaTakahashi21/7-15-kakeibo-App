<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\Income\IncomeSourceId;
use App\Domain\ValueObject\Income\Amount;
use App\Domain\ValueObject\Income\AccrualDate;

class Income
{
    private ?int $id;
    private ?int $userId;
    private ?IncomeSourceId $incomeSourceId; 
    private ?Amount $amount; 
    private ?AccrualDate $accrualDate; 

    public function __construct(?int $userId, ?IncomeSourceId $incomeSourceId, ?Amount $amount, ?AccrualDate $accrualDate, ?int $id)
    {
      $this->id = $id;
      $this->userId = $userId;
      $this->incomeSourceId = $incomeSourceId;
      $this->amount = $amount;
      $this->accrualDate = $accrualDate;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getIncomeSourceId(): ?IncomeSourceId
    {
        return $this->incomeSourceId;
    }

    public function getAmount(): ?Amount
    {
        return $this->amount;
    }

    public function getAccrualDate(): ?AccrualDate
    {
        return $this->accrualDate;
    }

    public function getId(): ?int
    {
      return $this->id;
    }
}
