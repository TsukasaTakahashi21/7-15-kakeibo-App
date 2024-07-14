<?php
session_start();
require_once '../../Config/db.php';
require_once '../../vendor/autoload.php';

use App\Infrastructure\Repository\IncomeRepository;
use App\UseCase\Interactor\Income\DeleteIncomeInteractor;
use App\Presentation\Controller\Income\DeleteIncomeController;

$pdo = getPdo();
$incomeRepository = new IncomeRepository($pdo);
$DeleteIncomeInteractor = new DeleteIncomeInteractor($incomeRepository);
$controller = new DeleteIncomeController($DeleteIncomeInteractor);

$id = $_GET['id'];
if (!isset($_GET['id'])) {
  echo "IDが指定されていません。";
  exit;
}

try {
  $controller->delete($id);
  header('Location: ./index.php');
  exit();
} catch (Exception $e) {
  echo '削除に失敗しました' . $e->getMessage();
}

