<?php
session_start();
// エラー情報をセッションで受け取る
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : '';
unset($_SESSION['errors']);

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>カテゴリ追加ページ</title>
</head>
<body>
  <header>
    <div class="navi">
      <ul>
        <li><a href="../../index.php">HOME</a></li>
        <li><a href="../../incomes/index.php">収入TOP</a></li>
        <li><a href="../../spendings/index.php">支出TOP</a></li>
        <li><a href="../../user/logout.php">ログアウト</a></li>
      </ul>
    </div>
  </header>

  <section class="add_spending_source">
    <h2 class="section-title">カテゴリ追加</h2>
    <!-- エラーメッセージの表示 -->
    <?php if (!empty($errors)): ?>
        <ul>
          <?php foreach($errors as $error): ?>
            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
          <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- カテゴリ登録フォーム -->
    <form action="./store.php" method="post">
      <input type="hidden" name="user_id" value="<?php echo htmlspecialchars(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '', ENT_QUOTES, 'UTF-8'); ?>">
      <label>カテゴリ名:
        <input type="text" name="spending_source" placeholder="カテゴリ名">
      </label><br>
      <button type="submit">登録</button>
    </form>
    <a href="./index.php">戻る</a>
  </section>
</body>
</html>