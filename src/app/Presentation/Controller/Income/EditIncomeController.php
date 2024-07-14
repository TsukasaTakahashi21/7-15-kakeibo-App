<?php
namespace App\Presentation\Controller\Income;

use App\UseCase\Interactor\Income\EditIncomeInteractor;
use App\UseCase\Input\Income\EditIncomeInput;


class EditIncomeController
{
  private EditIncomeInteractor $interactor;
  public function __construct(EditIncomeInteractor $interactor)
  {
    $this->interactor = $interactor;
  }
  
  public function edit(int $id)
  {
    $input = new EditIncomeInput($id);
    return $this->interactor->handle($input);
  }
}