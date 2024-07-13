<?php
session_start();

require_once '../../../vendor/autoload.php';
require_once '../../../Config/db.php';

use App\Presentation\Controller\IncomeSource\DeleteIncomeSourceController;


$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!isset($_GET['id'])) {
  header('Location: ./index.php');
  exit();
}

$controller = new DeleteIncomeSourceController();
$controller->delete($id);
