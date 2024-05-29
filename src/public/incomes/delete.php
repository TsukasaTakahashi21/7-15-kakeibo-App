<?php
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

if (!isset($_GET['id'])) {
  echo "IDが指定されていません。";
  exit;
}

$id = $_GET['id'];

$sql = 'DELETE FROM incomes WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);

if ($statement->execute()) {
  header('Location: ./index.php');
  exit();
} else {
  echo "削除に失敗しました。";
}
?>