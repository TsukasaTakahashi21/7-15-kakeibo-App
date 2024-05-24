<?php
session_start();
// エラーメッセージの取得
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : '';
unset($_SESSION['errors']);

// フォームの初期値
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン</title>
</head>
<body>
  <h2>ログイン</h2>
  <!-- エラーメッセージの表示 -->
  <?php if (!empty($errors)): ?>
    <ul>
      <?php foreach ($errors as $error): ?>
        <li><?php echo $error; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <!-- ログインフォーム -->
  <form action="./signin_complete.php" method="post">
    <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>"><br>
    <input type="password" name="password"  value="<?php echo $password; ?>"><br>
    <button type="submit">ログイン</button>
  </form>
  <a href="./signup.php">アカウントを作る</a>
</body>
</html>