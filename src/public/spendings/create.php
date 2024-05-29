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
  <title>支出一覧ページ</title>
</head>
<body>
  <header>
    <div class="navi">
      <ul>
        <li><a href="../index.php">HOME</a></li>
        <li><a href="../incomes/index.php">収入TOP</a></li>
        <li><a href="./index.php">支出TOP</a></li>
        <li><a href="../user/logout.php">ログアウト</a></li>
      </ul>
    </div>
  </header>

  <section class="spendings-top">
    <h2>支出登録</h2>
    <!-- エラーメッセージの表示 -->
    <?php if (!empty($errors)): ?>
      <ul>
        <?php foreach($errors as $error): ?>
          <li><?php echo $error; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <!-- 支出登録フォーム -->
    <form action="./store.php" method="post">
      <input type="hidden" name="user_id" value="<?php echo htmlspecialchars(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '', ENT_QUOTES, 'UTF-8'); ?>">
        <label for="">支出名:
          <input type="text" name="spending_name" placeholder="支出名">
        </label><br>
        <label for="">カテゴリー:
          <select name="category_id" id="">
            <option value=""></option>
            <?php 
              $sql = 'SELECT id, name FROM categories';
              $statement = $pdo->prepare($sql);
              $statement ->execute();
              while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="'.htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8').'">'.$row['name'].'</option>';
              }
            ?>
          </select>
          <a href="../spendings/category/index.php">カテゴリー一覧へ</a>
        </label><br>
        <label>金額:
          <input type="text" name="amount" placeholder="金額">円
        </label><br>
        <label>日付:
          <input type="date" name="date">
        </label><br>
        <button type="submit">登録</button>
    </form>
    <a href="./index.php">戻る</a>
    
  </section>
</body>
</html>