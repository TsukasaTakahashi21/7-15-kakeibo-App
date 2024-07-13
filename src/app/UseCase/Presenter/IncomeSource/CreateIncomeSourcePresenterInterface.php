<?php
namespace App\UseCase\Presenter\IncomeSource;

use App\UseCase\Output\IncomeSource\CreateIncomeSourceOutput;

interface CreateIncomeSourcePresenterInterface
{
  public function output(CreateIncomeSourceOutput $output): void;
}
