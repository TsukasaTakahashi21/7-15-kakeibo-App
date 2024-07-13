<?php
namespace App\UseCase\Input\Income;


class CreateIncomeInput
{
  private int $userId;
  private int $incomeSourceId;
  private int $amount;
  private string $accrualDate;

  public function __construct(int $userId, int $incomeSourceId, int $amount, string $accrualDate)
  {
    $this->userId = $userId;
    $this->incomeSourceId = $incomeSourceId;
    $this->amount = $amount;
    $this->accrualDate = $accrualDate;
  }
  

  public function getUserId(): int
  {
    return $this->userId;
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