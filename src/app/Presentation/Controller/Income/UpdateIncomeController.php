<?php
namespace App\Presentation\Controller\Income;

use App\UseCase\Interactor\Income\UpdateIncomeInteractor;
use App\UseCase\Input\Income\UpdateIncomeInput;
use InvalidArgumentException;

class UpdateIncomeController
{
  private UpdateIncomeInteractor $interactor;

  public function __construct(UpdateIncomeInteractor $interactor)
  {
    $this->interactor = $interactor;
  }

  public function update()
  {
    try {
      $input = new UpdateIncomeInput(
        (int)$_POST['id'],
        (int)$_POST['income_source'],
        (int)$_POST['amount'], 
        (string)$_POST['date']
      );
  
      $this->interactor->handle($input);
      header('Location: ./index.php');
      exit();
    } catch (InvalidArgumentException $e) {
      $_SESSION['errors'] = [$e->getMessage()];
      header('Location: ./edit.php?id=' . $_POST['id']);
      exit();
    }
  }
}