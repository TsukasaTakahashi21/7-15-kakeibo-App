<?php
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

// 絞り込み機能のフォームの値を取得
$category_name = isset($_GET['category_name']) ? $_GET['category_name'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$sql = 'SELECT categories.id, categories.name as category_name, spendings.id as spending_id, spendings.name, spendings.amount, spendings.accrual_date FROM categories JOIN spendings ON categories.id = spendings.category_id';

$params = [];

// カテゴリー名での絞り込み
if (!empty($category_name)) {
  $sql .= ' AND categories.id = :category_id';
  $params['category_id'] = $category_name;
}

// 年月日期間の絞り込み機能
if (!empty($start_date)) {
  $sql .= ' AND spendings.accrual_date >= :start_date';
  $params[':start_date'] = $start_date;
}
if (!empty($end_date)) {
  $sql .= ' AND spendings.accrual_date <= :end_date';
  $params[':end_date'] = $end_date;
}

$statement = $pdo->prepare($sql);
$statement->execute($params);
$spendings = $statement->fetchAll(PDO::FETCH_ASSOC);

// 支出額の合計
$total_amount = 0;
foreach ($spendings as $spending) {
  $total_amount += $spending['amount'];
}
?>

<!DOCTYPE html>
<html lang="ja">

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
        <li><a href="">支出TOP</a></li>
        <li><a href="../user/logout.php">ログアウト</a></li>
      </ul>
    </div>
  </header>

  <section class="spendings-top">
    <h2 class="section-title">支出</h2>
    <!-- 支出額の合計 -->
    <p>合計金額:<?php echo htmlspecialchars($total_amount, ENT_QUOTES, 'UTF-8'); ?>円</p>
    <a href="./create.php">支出を登録する</a>

    <!-- 絞り込み機能 -->
    <div class="filter">
      <p>絞り込み検索</p>
      <form action="" method="get">
        <label>カテゴリー
          <select name="category_name" id="">
            <option value="">カテゴリーを選んでください</option>
            <?php 
              $sql = 'SELECT id, name FROM categories';
              $statement = $pdo->prepare($sql);
              $statement ->execute();
              while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="'.htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8').'">'.$row['name'].'</option>';
              }
            ?>
          </select>
        </label>
        <label>日付:
          <input type="date" name="start_date" value="<?php echo $start_date; ?>">
        </label>
        <label>〜
          <input type="date" name="end_date" value="<?php echo $end_dat; ?>">
        </label>
        <button type="submit">検索</button>
      </form>
    </div>
    
    <div class="spendings_table">
      <table border="1">
          <tr>
            <th>支出名</th>
            <th>カテゴリー</th>
            <th>金額</th>
            <th>日付</th>
            <th>編集</th>
            <th>削除</th>
          </tr>
          <?php foreach ($spendings as $spending): ?>
            <tr>
              <td><?php echo htmlspecialchars($spending['name'] , ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($spending['category_name'] , ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($spending['amount'] , ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($spending['accrual_date'] , ENT_QUOTES, 'UTF-8'); ?></td>
              <td><a href="./edit.php?id=<?php echo htmlspecialchars($spending['spending_id'], ENT_QUOTES, 'UTF-8'); ?>">編集</a></td>
              <td><a href="./delete.php?id=<?php echo htmlspecialchars($spending['spending_id'], ENT_QUOTES, 'UTF-8'); ?>">削除</a></td>
            </tr>
          <?php endforeach; ?>
      </table>
    </div>
  </section>
</body>
</html>