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
$income_source_id = isset($_GET['income_source_id']) ? $_GET['income_source_id'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$sql = 'SELECT incomes.id, income_sources.name as income_source, incomes.amount, incomes.accrual_date FROM incomes JOIN income_sources ON incomes.income_source_id = income_sources.id';

$params = [];

// 収入源での絞り込み機能
if (!empty($income_source_id)) {
  $sql .= ' AND incomes.income_source_id = :income_source_id';
  $params[':income_source_id'] = $income_source_id;
}

// 年月日期間の絞り込み機能
if (!empty($start_date)) {
  $sql .= ' AND incomes.accrual_date >= :start_date';
  $params[':start_date'] = $start_date;
}
if (!empty($end_date)) {
  $sql .= ' AND incomes.accrual_date >= :end_date';
  $params[':end_date'] = $end_date;
}

$statement = $pdo->prepare($sql);
$statement->execute($params); 
$incomes = $statement->fetchAll(PDO::FETCH_ASSOC);

// 収入額の合計
$totalAmount = 0;
foreach ($incomes as $income) {
  $totalAmount += $income['amount'];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>収入一覧ページ</title>
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

  <section class="incomes_top">
    <h2 class="section-title">収入</h2>
    <!-- 収入額の合計 -->
    <p>合計額:<?php echo htmlspecialchars($totalAmount, ENT_QUOTES, 'UTF-8'); ?>円</p>
    <a href="./create.php">収入を登録する</a>

    <!-- 絞り込み機能 -->
    <div class="filter">
      <p>絞り込み検索</p>
      <form action="" method="get">
        <label>収入源:
          <select name="income_source_id" id="">
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
        </label>
        <label>日付:
          <input type="date" name="start_date" value="<?php echo htmlspecialchars($start_date, ENT_QUOTES,'UTF-8'); ?>">
        </label>
        <label>～
          <input type="date" name="end_date" value="<?php echo htmlspecialchars($end_date, ENT_QUOTES,'UTF-8'); ?>">
        </label>
          <button type="submit">検索</button>
      </form>
    </div>
    
    <div class="incomes-table">
      <table border="1">
        <tr>
          <th>収入名</th>
          <th>金額</th>
          <th>日付</th>
          <th>編集</th>
          <th>削除</th>
        </tr>
        <?php foreach ($incomes as $income): ?>
          <tr>
            <td><?php echo htmlspecialchars($income['income_source'] , ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($income['amount'] , ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($income['accrual_date'] , ENT_QUOTES, 'UTF-8'); ?></td>
            <td><a href="./edit.php?id=<?php echo htmlspecialchars($income['id'], ENT_QUOTES, 'UTF-8'); ?>">編集</a></td>
            <td><a href="./delete.php?id=<?php echo htmlspecialchars($income['id'], ENT_QUOTES, 'UTF-8'); ?>">削除</a></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </section>
</body>
</html>