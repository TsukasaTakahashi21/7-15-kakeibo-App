<?php
namespace App\UseCase\Presenter\IncomeSource;

use App\UseCase\Output\IncomeSource\DeleteIncomeSourceOutput;

interface DeleteIncomeSourcePresenterInterface
{
  public function output(DeleteIncomeSourceOutput $output);
}