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

// 収入源のIDを取得
$id = isset($_GET['id']) ? $_GET['id'] : '';

 // 収入源のデータを取得
$sql = 'SELECT name FROM income_sources WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$income_source = $statement->fetch(PDO::FETCH_ASSOC);

if ($income_source) {
  $income_source_name = $income_source['name'];
} else {
  header('Location: ./index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>収入源編集</title>
</head>
<body>
  <div class="navi">
    <ul>
      <li><a href="../../index.php">HOME</a></li>
      <li><a href="../../incomes/index.php">収入TOP</a></li>
      <li><a href="../../spendings/index.php">支出TOP</a></li>
      <li><a href="../../user/logout.php">ログアウト</a></li>
    </ul>
  </div>

  <section class="add-income_source">
    <h2 class="section-title">編集</h2>
    <!-- エラーメッセージの表示 -->
    <?php if (!empty($errors)): ?>
      <ul>
        <?php foreach($errors as $error): ?>
          <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <!-- 収入源登録フォームの表示 -->
    <form action="./update.php" method="post">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
      <label>収入源:
        <input type="text" name="income_source" value="<?php echo htmlspecialchars($income_source_name, ENT_QUOTES, 'UTF-8')?>">
      </label>
      <button type="submit">更新</button>
    </form>
    <a href="./index.php">戻る</a>
  </section>