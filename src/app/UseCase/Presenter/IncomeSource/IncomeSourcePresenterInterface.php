<?php
namespace App\UseCase\Presenter\IncomeSource;

use App\UseCase\Output\IncomeSource\ViewIncomeSourceOutput;

interface IncomeSourcePresenterInterface
{
  public function output(ViewIncomeSourceOutput $output);
  public function outputAll(array $outputs);
}