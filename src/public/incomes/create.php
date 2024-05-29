<?php
session_start();
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
  <title>TOPページ</title>
</head>
<body>
  <header>
    <div class="navi">
      <ul>
        <li><a href="../index.php">HOME</a></li>
        <li><a href="index.php">収入TOP</a></li>
        <li><a href="../spendings/index.php">支出TOP</a></li>
        <li><a href="../user/logout.php">ログアウト</a></li>
      </ul>
    </div>
  </header>

  <section class="add-income">
    <h2 class="section-title">収入登録</h2>
    <!-- エラーメッセージ表示 -->
    <?php if (!empty($errors)): ?>
      <ul>
        <?php foreach($errors as $error): ?>
          <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form action="./store.php" method="post">
      <label>収入源:
        <!-- 収入源の選択フォーム -->
        <select name="income_source" id="">
          <option value="">収入源を選んでください</option>
          <?php 
            $sql = 'SELECT id, name FROM income_sources';
            $statement = $pdo->prepare($sql);
            $statement->execute(); 
            while ( $row = $statement->fetch(PDO::FETCH_ASSOC)) {
              echo '<option value="'.htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8').'">'. $row['name'].'</option>';
            }
          ?>
        </select>
        <a href="income_sources/index.php">収入源一覧へ</a>
      </label><br>
      <label>金額
        <input type="text" name="amount" value="">円
      </label><br>
      <label>日付
        <input type="date" name="date" value="">
      </label><br>
      <button type="submit">登録</button>
    </form>
    <a href="index.php">戻る</a>
  </section>
</body>
</html>

