<?php
namespace App\Presentation\Presenter\Income;

use App\Domain\Entity\Income;

class EditIncomePresenter
{
  public function present(Income $income): array
  {
    return [
      'id' => $income->getId(),
      'income_source_id' => $income->getIncomeSourceId()->getValue(),
      'amount' => $income->getAmount()->getValue(),
    ];
  }
}