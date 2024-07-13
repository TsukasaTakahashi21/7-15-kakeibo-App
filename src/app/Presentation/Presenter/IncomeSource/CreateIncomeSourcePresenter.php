<?php
namespace App\Presentation\Presenter\IncomeSource;

use App\UseCase\Presenter\IncomeSource\CreateIncomeSourcePresenterInterface;
use App\UseCase\Output\IncomeSource\CreateIncomeSourceOutput;

class CreateIncomeSourcePresenter implements CreateIncomeSourcePresenterInterface
{
  public function output(CreateIncomeSourceOutput $output): void
  {
    $incomeSource = $output->getIncomeSource();
    echo '収入源が作成されました:'.htmlspecialchars($incomeSource->getName()->getValue(), ENT_QUOTES, 'UTF-8');
  }
}
