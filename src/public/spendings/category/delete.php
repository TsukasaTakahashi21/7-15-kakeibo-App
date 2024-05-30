<?php
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

if (!isset($_GET['id']))  {
  header('Location: ./index.php');
  exit();
}

$id = $_GET['id'];

$sql = 'DELETE FROM categories WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();

header('Location: ./index.php');
?>