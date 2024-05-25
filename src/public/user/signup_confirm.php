<?php
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=kakeibo; charset=utf8',
    $dbUserName,
    $dbPassword,
);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = isset($_POST['user_name']) ? $_POST['user_name'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

  //  EmailかPasswordに入力がない場合
  if (empty($email) || empty($password)) {
    $errors[] = 'EmailかPasswordの入力がありません';
  }

  // パスワードが一致しない場合
  if ($password !== $confirm_password) {
    $errors[] = 'パスワードが一致しません';
  }
  
  // 同一のemailがすでに保存されている場合
  $sql = 'SELECT count(*) as count FROM users WHERE email = :email';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':email', $email, PDO::PARAM_STR);
  $statement->execute();
  $result = $statement->fetch(PDO::FETCH_ASSOC);

  if ($result['count'] > 0) {
    $errors[] = 'すでに保存されているメールアドレスです';
  }

  if(!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: signup.php');
    exit();
  }
}
// POSTでのリクエストでない場合やエラーがない場合は、空の値で初期化
$username = '';
$email = '';
$password = '';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録確認画面</title>
</head>
<body>
  <p>こちらの内容で登録してよろしいですか</p>
  <form action="signup_complete.php" method="post">
    <label for="user_name">ユーザー名:</label><br>
    <input type="text" name="user_name" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>"><br>
    <label for="email">メールアドレス:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"><br>
    <label for="user_name">パスワード:</label><br>
    <input type="password" name="password" value="<?php echo htmlspecialchars($password, ENT_QUOTES, 'UTF-8'); ?>"><br>
    <button type="submit">送信</button>
  </form>
</body>
</html>