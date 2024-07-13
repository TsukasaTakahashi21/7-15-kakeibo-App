<?php
namespace App\Presentation\Presenter\IncomeSource;

use App\UseCase\Output\IncomeSource\ViewIncomeSourceOutput;
use App\UseCase\Presenter\IncomeSource\IncomeSourcePresenterInterface;

class IncomeSourcePresenter implements IncomeSourcePresenterInterface
{
  public function output(ViewIncomeSourceOutput $output)
  {
    return $output->getIncomeSource();
  }

  public function outputAll(array $outputs)
  {
    $incomeSources = [];
    foreach ($outputs as $output) {
      $incomeSource = $output->getIncomeSource();
      $incomeSources[] = [
        'id' => $incomeSource->getId(),
        'name' => $incomeSource->getName()->getValue(), 
        'userId' => $incomeSource->getUserId(),
      ];
    }
    return $incomeSources;
  }
}