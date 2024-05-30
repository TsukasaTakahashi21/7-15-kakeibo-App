<?php
session_start();
// エラー情報をセッションで受け取る
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : '';
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>収入源追加</title>
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


  <section class="add-income-source">
    <h2 class="section-title">収入源追加</h2>
    <!-- エラーメッセージの表示 -->
    <?php if (!empty($errors)): ?>
      <ul>
        <?php foreach($errors as $error): ?>
          <li><?php echo $error; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    
    <!-- 収入源登録フォームの表示 -->
    <form action="./store.php" method="post">
      <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id'], ENT_QUOTES, 'UTF-8'); ?>">
      <label>収入源:
        <input type="text" name="income_source" placeholder="収入源を入力">
      </label><br>
      <button type="submit">登録</button>
    </form>
    <a href="./index.php">戻る</a>
  </section>
</body>
</html>