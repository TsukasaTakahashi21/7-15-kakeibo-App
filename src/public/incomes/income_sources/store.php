<?php 
session_start();
require_once '../../../vendor/autoload.php';
require_once '../../../Config/db.php';

use App\Infrastructure\Repository\IncomeSourceRepository;
use App\UseCase\Interactor\IncomeSource\CreateIncomeSourceInteractor;
use App\Presentation\Controller\IncomeSource\CreateIncomeSourceController;
use App\Presentation\Presenter\IncomeSource\CreateIncomeSourcePresenter;
use App\UseCase\Input\IncomeSource\CreateIncomeSourceInput;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['income_source'];
  $userId = $_SESSION['user_id'];
  $pdo = getPdo();
  $repository = new IncomeSourceRepository($pdo);
  $presenter = new CreateIncomeSourcePresenter();
  $interactor = new CreateIncomeSourceInteractor($repository, $presenter);
  $input = new CreateIncomeSourceInput($name, $userId);
  $controller = new CreateIncomeSourceController($interactor);
}

try {
  $controller->store($input);

  $_SESSION['success'] = '収入源が登録されました。'
;
header('Location: Create.php');
exit();
} catch (Exception $e) {
  var_dump($e);
  $_SESSION['errors'] = ['収入源の登録に失敗しました。'];
  header('Location: create.php');
  exit();
}
