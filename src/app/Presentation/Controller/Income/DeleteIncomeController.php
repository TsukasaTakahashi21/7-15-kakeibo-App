<?php
namespace App\Presentation\Controller\Income;

use App\UseCase\Interactor\Income\DeleteIncomeInteractor;
use App\UseCase\Input\Income\DeleteIncomeInput;

class DeleteIncomeController {

  private DeleteIncomeInteractor $interactor;

  public function __construct(DeleteIncomeInteractor $interactor)
  {
    $this->interactor = $interactor;
  }

  public function delete(int $id): void
  {
    $input = new DeleteIncomeInput($id);
    $this->interactor->handle($input);
  }
}
