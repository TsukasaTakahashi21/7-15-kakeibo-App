<?php
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

$sql = 'SELECT id, name FROM income_sources';
$statement = $pdo->prepare($sql);
$statement->execute(); 
$income_sources = $statement->fetchAll(PDO::FETCH_ASSOC);
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

  <!-- 収入源一覧の表示 -->
  <section class="income_sources">
    <h2 class="subsection-title">収入源一覧</h2>
    <a href="./create.php">収入源を追加する</a>
    <table border="1">
      <tr>
        <th>収入源</th>
        <th>編集</th>
        <th>削除</th>
      </tr>
      <?php foreach($income_sources as $income_source): ?>
        <tr>
          <td><?php echo $income_source['name']; ?></td>
          <td><a href="./edit.php?id=<?php echo htmlspecialchars($income_source['id'], ENT_QUOTES, 'UTF-8'); ?>">編集</a></td>
          <td><a href="../income_sources/delete.php?id=<?php echo htmlspecialchars($income_source['id'], ENT_QUOTES, 'UTF-8'); ?>">削除</a></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <a href="../income_sources/create.php">戻る</a>
  </section>
</body>
</html>