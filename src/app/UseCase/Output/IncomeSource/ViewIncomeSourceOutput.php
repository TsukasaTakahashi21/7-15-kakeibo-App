<?php
namespace App\UseCase\Output\IncomeSource;

use App\Domain\Entity\IncomeSource;

class ViewIncomeSourceOutput
{
  private $incomeSource;

  public function __construct(IncomeSource $incomeSource)
  {
    $this->incomeSource = $incomeSource;
  }

  public function getIncomeSource(): IncomeSource
  {
    return $this->incomeSource;
  }
}