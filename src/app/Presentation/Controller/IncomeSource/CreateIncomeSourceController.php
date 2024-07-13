<?php
namespace App\Presentation\Controller\IncomeSource;

use App\UseCase\Input\IncomeSource\CreateIncomeSourceInput;
use App\UseCase\Interactor\IncomeSource\CreateIncomeSourceInteractor;

class CreateIncomeSourceController
{
  private CreateIncomeSourceInteractor $interactor;

  public function __construct(CreateIncomeSourceInteractor $interactor)
  {
    $this->interactor = $interactor;
  }

  public function store(CreateIncomeSourceInput $input): void
  {
      $this->interactor->handle($input);
  }
}