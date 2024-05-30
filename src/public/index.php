<?php
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

// 現在の年を取得
$currentYear = date('Y');

// もし絞り込み用の年が選択されていれば、その値を取得
$filterYear = isset($_GET['filter_year']) ? $_GET['filter_year'] : 

// 月ごとのデータを格納するための配列を準備
$monthly_data = array_fill(1, 12, [
    'income' => 0,
    'spending' => 0,
    'balance' => 0
]);

// 月ごとの収入データを取得するクエリ
$sql = "SELECT MONTH(accrual_date) AS month, SUM(amount) AS total_amount FROM incomes 
        WHERE YEAR(accrual_date) = :year
        GROUP BY MONTH(accrual_date)";
$statement = $pdo->prepare($sql);
$statement->bindValue(':year', $filterYear, PDO::PARAM_INT);
$statement->execute();
$income_data = $statement->fetchAll(PDO::FETCH_ASSOC);

// 月ごとの収入データを配列に格納
foreach ($income_data as $row) {
    $month = $row['month'];
    $monthly_data[$month]['income'] = $row['total_amount'];
}

// 月ごとの支出データを取得するクエリ
$sql = "SELECT MONTH(accrual_date) AS month, SUM(amount) AS total_amount FROM spendings 
        WHERE YEAR(accrual_date) = :year
        GROUP BY MONTH(accrual_date)";
$statement = $pdo->prepare($sql);
$statement->bindValue(':year', $filterYear, PDO::PARAM_INT);
$statement->execute();
$spending_data = $statement->fetchAll(PDO::FETCH_ASSOC);

// 月ごとの支出データを配列に格納
foreach ($spending_data as $row) {
    $month = $row['month'];
    $monthly_data[$month]['spending'] = $row['total_amount'];
}

// 月ごとの収支を計算する
foreach ($monthly_data as $month => &$data) {
    $data['balance'] = $data['income'] - $data['spending'];
}
unset($data); // 参照の解除
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
        <li><a href="">HOME</a></li>
        <li><a href="incomes/index.php">収入TOP</a></li>
        <li><a href="/spendings/index.php">支出TOP</a></li>
        <li><a href="/user/logout.php">ログアウト</a></li>
      </ul>
    </div>
  </header>

  <section class="kakeibo_top">
    <h2 class="section-title">家計簿アプリ</h2>
    
    <!-- 絞り込み機能 -->
    <div class="filter">
    <form action="" method="get">
      <label for="filter_year"></label>
      <select name="filter_year" id="filter_year">
        <?php for ($year = $currentYear - 5; $year <= $currentYear + 5; $year++): ?>
          <option value="<?php echo $year; ?>" <?php if ($year == $filterYear) echo 'selected'; ?>>
            <?php echo $year; ?>年
          </option>
        <?php endfor; ?>
      </select>年を選択：
      <button type="submit">検索</button>
    </form>
    </div>
    
    
    <div class="balance-table">
      <table border="1">
        <tr>
          <th>月</th>
          <th>収入</th>
          <th>支出</th>
          <th>収支</th>
        </tr>
        <?php foreach($monthly_data as $month =>$data): ?>
          <tr>
            <td><?php echo $month; ?>月</td>
            <td><?php echo htmlspecialchars($data['income'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($data['spending'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($data['balance'], ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </section>
</body>
</html>