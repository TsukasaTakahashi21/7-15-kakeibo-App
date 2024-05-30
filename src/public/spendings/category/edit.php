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

if (!isset($_GET['id']))  {
  header('Location: ./index.php');
  exit();
} else {
  $id = $_GET['id'];
}

 // 支出源のデータを取得
$sql = "SELECT name FROM categories WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$category = $statement->fetch(PDO::FETCH_ASSOC);

if ($category) {
  $category_name= $category['name'];
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
  <title>カテゴリ編集ページ</title>
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

  <section class="category_edit">
    <h2 class="header-title">編集</h2>
    <!-- エラーメッセージの表示 -->
    <?php if (!empty($errors)): ?>
      <ul>
        <?php foreach($errors as $error): ?>
          <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

      <!-- 支出源変更フォームの表示 -->
    <form action="./update.php" method="post">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
      <label><p>カテゴリ名:</p>
      <input type="text" name="category_name" value="<?php echo htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8'); ?>">
      </label>
      <button type="submit">更新</button>
    </form>
  </section>
</body>
</html>