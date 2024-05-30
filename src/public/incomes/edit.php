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

// 収入データのIDを取得
if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  echo 'IDが指定されていません';
  exit();
}

$sql = 'SELECT incomes.amount, incomes.accrual_date, income_sources.name as income_source FROM incomes JOIN income_sources ON incomes.income_source_id = income_sources.id WHERE incomes.id = :id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute(); 
$income = $statement->fetch(PDO::FETCH_ASSOC);

if (!$income) {
  echo '該当する収入データが見つかりません。';
  exit();
}
// 収入データの各値を変数に格納
$income_source = $income['income_source'];
$income_amount = $income['amount'];
$accrual_date = $income['accrual_date'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>収入編集ページ</title>
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

  <section class="edit_income">
    <h2 class="section-title">収入編集</h2>
      <!-- エラーメッセージの表示 -->
      <?php if (!empty($errors)): ?>
        <ul>
          <?php foreach($errors as $error): ?>
            <li><?php echo htmlentities($error, ENT_QUOTES, 'UTF-8'); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <!-- 編集フォーム -->
      <form action="./update.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
        <label>収入源:
          <select name="income_source" id="">
            <?php 
              // 収入源の選択肢を作成
              $sql = 'SELECT id, name FROM income_sources';
              $statement = $pdo->prepare($sql);
              $statement->execute(); 
              while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($row['name'] == $income_source) ? 'selected' : '';
                echo '<option value="'.htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8').'" '.$selected.'>'. $row['name'].'</option>';
              }
            ?>
          </select>
        </label><br>
        <label>金額:
          <input type="text" name="amount" value="<?php echo htmlspecialchars($income_amount , ENT_QUOTES, 'UTF-8'); ?>">円
        </label><br>
        <label>日付:
          <input type="date" name="date" value="<?php echo htmlspecialchars($accrual_date, ENT_QUOTES, 'UTF-8'); ?>">
        </label>
        <button type="submit">編集</button>
      </form>
  </section>
</body>  
</html>
