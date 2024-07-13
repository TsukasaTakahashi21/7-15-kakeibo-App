<?php
namespace App\UseCase\Output\IncomeSource;

class EditIncomeSourceOutput
{
  private $incomeSource;

  public function __construct($incomeSource)
  {
    $this->incomeSource = $incomeSource;
  }

  public function getIncomeSource()
  {
    return $this->incomeSource;
  }
}