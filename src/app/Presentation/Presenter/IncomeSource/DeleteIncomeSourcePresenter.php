<?php
namespace App\Presentation\Presenter\IncomeSource;

use App\UseCase\Output\IncomeSource\DeleteIncomeSourceOutput;
use App\UseCase\Presenter\IncomeSource\DeleteIncomeSourcePresenterInterface;


class DeleteIncomeSourcePresenter implements DeleteIncomeSourcePresenterInterface {
  public function output(DeleteIncomeSourceOutput $output) {
    header('Location: ./index.php');
    exit();
  }
}