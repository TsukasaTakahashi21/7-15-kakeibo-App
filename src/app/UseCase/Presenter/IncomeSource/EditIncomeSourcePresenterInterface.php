<?php
namespace App\UseCase\Presenter\IncomeSource;

use App\UseCase\Output\IncomeSource\EditIncomeSourceOutput;

interface EditIncomeSourcePresenterInterface
{
  public function output(EditIncomeSourceOutput $output);
}