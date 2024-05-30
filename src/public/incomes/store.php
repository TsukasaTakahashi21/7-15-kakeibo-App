<?php 
session_start();

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

  $errors = [];
  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
  
  $income_source_id = isset($_POST['income_source']) ? $_POST['income_source'] : '';
  $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
  $date = isset($_POST['date']) ? $_POST['date'] : '';

  if (empty($income_source_id)) {
    $errors[] = '収入源が選択されていません';
  }
  if (empty($amount)) {
    $errors[] = '金額が入力されていません';
  }
  if (empty($date)) {
    $errors[] = '日付が入力されていません';
  }

  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ./create.php');
    exit();
  } else {

  $sql = 'INSERT INTO incomes (user_id, income_source_id, amount, accrual_date, created_at, updated_at) VALUES (:user_id, :income_source_id, :amount, :accrual_date, NOW(), NOW())';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $statement->bindValue(':income_source_id', $income_source_id, PDO::PARAM_INT);
  $statement->bindValue(':amount', $amount, PDO::PARAM_INT);
  $statement->bindValue(':accrual_date', $date, PDO::PARAM_STR);

  if ($statement->execute()) {
    header('Location: ./index.php');
    exit();
  }
}
?>