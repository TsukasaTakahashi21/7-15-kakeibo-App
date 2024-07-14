<?php
namespace App\UseCase\Output\Income;

use App\Domain\Entity\Income;

class EditIncomeOutput
{
  private Income $income;

  public function __construct(Income $income)
  {
    $this->income = $income;
  }

  public function getIncome(): Income
  {
    return $this->income;
  }
}