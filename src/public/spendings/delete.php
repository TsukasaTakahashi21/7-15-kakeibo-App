<?php
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) {
  echo "削除するIDが指定されていません。";
  exit;
}

$sql = 'DELETE FROM spendings WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);

if ($statement->execute()) {
  header('Location: ./index.php');
  exit();
} else {
  echo "削除に失敗しました。";
}
?>