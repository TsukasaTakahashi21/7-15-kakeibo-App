<?php
session_start();
require_once '../../../vendor/autoload.php';
require_once '../../../Config/db.php';

use App\Presentation\Controller\IncomeSource\EditIncomeSourceController;
use App\UseCase\Input\IncomeSource\EditIncomeSourceInput;

$id = isset($_POST['id']) ? $_POST['id'] : '';
$name = isset($_POST['income_source'] )? $_POST['income_source'] : '';
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

$pdo = getPdo();
$controller = new EditIncomeSourceController($pdo);

$errors = [];
if (empty($name)) {
  var_dump($name);
  $errors[] = '収入源名が入力されていません';
  $_SESSION['errors'] = $errors;
  header('Location: ./edit.php?id=' . $id);
  exit();
}

$input = new EditIncomeSourceInput($id, $name, $userId);
$controller->update($input);

header('Location: ./index.php');
exit();
