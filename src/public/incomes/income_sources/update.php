<?php
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

// フォームから送信されたデータを取得
$user_id = isset($_POST['id']) ? $_POST['id'] : '';
$income_source = isset($_POST['income_source'] )? $_POST['income_source'] : '';

$errors = [];
// 収入源が入力されていない場合
if (empty($income_source)) {
  $errors[] = '収入源名が入力されていません';
  $_SESSION['errors'] = $errors;
  header('Location: ./edit.php?id=' . $user_id);
  exit();
}

$sql = 'UPDATE income_sources SET name = :name WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':name', $income_source, PDO::PARAM_STR);
$statement->bindValue(':id', $user_id, PDO::PARAM_INT);
$statement->execute();

header('Location: ./index.php');
exit();
?>