<?php
session_start();
require_once '../../Config/db.php';
require_once '../../vendor/autoload.php';

use App\Infrastructure\Repository\IncomeRepository;
use App\UseCase\Interactor\Income\UpdateIncomeInteractor;
use App\Presentation\Controller\Income\UpdateIncomeController;

$pdo = getPdo();
$incomeRepository = new IncomeRepository($pdo);
$updateIncomeInteractor = new UpdateIncomeInteractor($incomeRepository);
$controller = new UpdateIncomeController($updateIncomeInteractor);

$id = isset($_POST['id']) ? $_POST['id'] : '';
$incomeSourceId = isset($_POST['income_source'] )? $_POST['income_source'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
$accrualDate = isset($_POST['date']) ? $_POST['date'] : '';

$errors = [];

try {
  $controller->update($id, $incomeSourceId, $amount, $accrualDate);
  header('Location: ./index.php');
  exit();
} catch (Exception $e) {
  $errors[] = '更新に失敗しました。' . $e->getMessage();
  $_SESSION['errors'] = $errors;
  header('Location: ./edit.php?id=' . $id);
  exit();
}



