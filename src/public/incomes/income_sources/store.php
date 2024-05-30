<?php 
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

$user_id = $_SESSION['user_id'];
$errors = [];

// バリデーションチェック
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $income_source = isset($_POST['income_source']) ? ($_POST['income_source']) : '';
  $user_id = isset($_POST['user_id']) ? ($_POST['user_id']) : '';

  if (empty($income_source)) {
    $errors[] = '収入源が入力されていません。';
    $_SESSION['errors'] = $errors;
    header('Location: ./create.php');
    exit();
  }

  // 収入源の登録処理
  $sql = 'INSERT INTO income_sources (name, user_id) VALUES (:name, :user_id)';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':name', $income_source, PDO::PARAM_STR);
  $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $statement->execute();

  header('Location: ./index.php');
  exit();
}
?>