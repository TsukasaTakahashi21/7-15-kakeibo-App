<?php
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // フォームからのデータを取得
  $email = isset($_POST['email']) ? trim($_POST['email']) : '';
  $password = isset($_POST['password']) ? trim($_POST['password']) : '';
  $username = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
  
  // パスワードのハッシュ化
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // DBにユーザー情報を保存
  $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':name', $username, PDO::PARAM_STR);
  $statement->bindValue(':email', $email, PDO::PARAM_STR);
  $statement->bindValue(':password', $hashed_password, PDO::PARAM_STR);

  if ($statement->execute()) {
    header('Location: ./signin.php');
    exit();
  }
} 
?>
