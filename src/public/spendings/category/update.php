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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = isset($_POST['id']) ? $_POST['id'] : '';
  $category_name = isset($_POST['category_name'] )? $_POST['category_name'] : '';
  
  $errors = [];
  
  // カテゴリ名が入力されていない場合
  if (empty($category_name)) {
    $errors[] = '収入源名が入力されていません';
  }

  // カテゴリがすでに登録済みかチェック
  $sql = 'SELECT id FROM categories WHERE name = :category_name AND id = :id';
  $statement=$pdo->prepare($sql);
  $statement->bindValue(':category_name', $category_name, PDO::PARAM_STR);
  $statement->bindValue(':id', $id, PDO::PARAM_INT);
  $statement->execute();
  $check = $statement->fetchColumn();

  if ($check) {
    $errors[] = 'すでに登録済みのカテゴリです';
  }

  
  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ./edit.php?id=' . $id);
    exit();
  }

  $sql = 'UPDATE categories SET name = :category_name WHERE id = :id';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':category_name', $category_name, PDO::PARAM_STR);
  $statement->bindValue(':id', $id, PDO::PARAM_INT);
  $statement->execute();

  header('Location: ./index.php');
  exit();
}




