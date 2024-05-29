<?php
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

$sql = 'SELECT * FROM categories';
$statement = $pdo->prepare($sql);
$statement->execute(); 
$spending_sources = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>カテゴリ一覧</title>
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
  
  <h2>カテゴリ一覧</h2>
  <section>
    <a href="./create.php">カテゴリを追加する</a>
    <div class="spendings_table">
      <table border="1">
        <tr>
          <th>カテゴリ</th>
          <th>編集</th>
          <th>削除</th>
        </tr>
        <?php foreach ($spending_sources as $spending_source): ?>
          <tr>
            <td><?php echo htmlspecialchars($spending_source['name'] , ENT_QUOTES, 'UTF-8'); ?></td>
            <td><a href="./edit.php?id=<?php echo htmlspecialchars($spending_source['id'], ENT_QUOTES, 'UTF-8'); ?>">編集</a></td>
            <td><a href="./delete.php?id=<?php echo htmlspecialchars($spending_source['id'], ENT_QUOTES, 'UTF-8'); ?>">削除</a></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <a href="../create.php">戻る</a>
  </section>
</body>
</html>