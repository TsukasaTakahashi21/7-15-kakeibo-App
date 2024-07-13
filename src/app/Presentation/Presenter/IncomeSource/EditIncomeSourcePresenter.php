<?php
namespace App\Presentation\Presenter\IncomeSource;

use App\UseCase\Output\IncomeSource\EditIncomeSourceOutput;
use App\UseCase\Presenter\IncomeSource\EditIncomeSourcePresenterInterface;

class EditIncomeSourcePresenter implements EditIncomeSourcePresenterInterface
{
  public function output(EditIncomeSourceOutput $output)
  {
    return $output->getIncomeSource();
  }
}