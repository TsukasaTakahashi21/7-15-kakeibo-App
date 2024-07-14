<?php
namespace App\UseCase\Input\Income;

use InvalidArgumentException; 

class UpdateIncomeInput
{
  private int $id;
  private int $incomeSourceId;
  private int $amount;
  private string $accrualDate;

  public function __construct(int $id, int $incomeSourceId, int $amount, string $accrualDate)
    {
      if (empty($amount) || $amount <= 0) {
        throw new InvalidArgumentException('金額を入力してください');
      }

      $this->id = $id;
      $this->incomeSourceId = $incomeSourceId;
      $this->amount = $amount;
      $this->accrualDate = $accrualDate;
    }

    public function getId(): int
    {
      return $this->id;
    }

    public function getIncomeSourceId(): int
    {
      return $this->incomeSourceId;
    }

    public function getAmount(): int
    {
      return $this->amount;
    }

    public function getAccrualDate(): string
    {
      return $this->accrualDate;
    }
}