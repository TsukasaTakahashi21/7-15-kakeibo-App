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

// バリデーションチェック
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $category_title = isset($_POST['spending_source']) ? $_POST['spending_source'] : '';
  $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

  // カテゴリ名が未入力
  if (empty($category_title)) {
    $errors[] = 'カテゴリ名が入力されていません';
  }

  // カテゴリがすでに存在済みかチェック
  $sql = 'SELECT id FROM categories WHERE name = :category_title AND user_id = :user_id';
  $statement=$pdo->prepare($sql);
  $statement->bindValue(':category_title', $category_title, PDO::PARAM_STR);
  $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $statement->execute();
  $check = $statement->fetchColumn();

  if ($check) {
    $errors[] = 'このカテゴリ名はすでに存在しています';
  }

  // エラーがない場合はカテゴリを登録
  if (empty($errors)) {
    $sql = 'INSERT INTO categories (name, user_id) VALUES (:name, :user_id)';
    $statement = $pdo->prepare($sql);
    $statement -> bindValue(':name', $category_title, PDO::PARAM_STR);
    $statement -> bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $statement -> execute();

    header('Location: ./index.php');
    exit();
  }
  
  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ./create.php');
    exit();
  }
}
?>
