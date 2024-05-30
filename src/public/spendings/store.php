<?php
session_start();
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : '';
unset($_SESSION['errors']);

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

$errors= [];
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';


$spending_name = isset($_POST['spending_name']) ? $_POST['spending_name'] : '';
$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';

if (empty($spending_name)) {
  $errors[] = '支出名が入力されていません';
}
if (empty($category_id)) {
  $errors[] = 'カテゴリーが選択されていません';
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
  // バリデーションに問題がない場合
  $sql = 'INSERT INTO spendings (user_id, name, category_id, amount, accrual_date, created_at, updated_at) VALUES (:user_id, :name, :category_id, :amount, :accrual_date, NOW(), NOW())';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $statement->bindValue(':name', $spending_name, PDO::PARAM_STR);
  $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
  $statement->bindValue(':amount', $amount, PDO::PARAM_INT);
  $statement->bindValue(':accrual_date', $date, PDO::PARAM_STR);
  if ($statement->execute()) {
    header('Location: ./index.php');
    exit();
  }
}
?>
