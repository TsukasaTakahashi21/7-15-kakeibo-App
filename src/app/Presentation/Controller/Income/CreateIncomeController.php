<?php
namespace App\Presentation\Controller\Income;

use App\UseCase\Input\Income\CreateIncomeInput;
use App\UseCase\Interactor\Income\CreateIncomeInteractor;

class CreateIncomeController
{
  private CreateIncomeInteractor $interactor;

  public function __construct(CreateIncomeInteractor $interactor)
  {
    $this->interactor = $interactor;
  }

  public function store()
  {
    try {
      $incomeSourceId = isset($_POST['income_source']) ? (int)$_POST['income_source'] : null; 
        $amount = isset($_POST['amount']) ? (int)$_POST['amount'] : null; 
        $date = isset($_POST['date']) ? $_POST['date'] : '';
        $userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null; 

        if ($incomeSourceId === null || $amount === null || $date === '' || $userId === null) {
            throw new \Exception('すべてのフィールドを正しく入力してください。');
        }

        $input = new CreateIncomeInput($userId, $incomeSourceId, $amount, $date);
        $this->interactor->handle($input);
        
    } catch (\Exception $e) {
        $_SESSION['errors'] = [$e->getMessage()];
        header('Location: ./create.php');
        exit();
    }
  }
}
