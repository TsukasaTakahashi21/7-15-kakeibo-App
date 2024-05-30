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

// 支出データのIDを取得
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) {
  echo "編集するIDが指定されていません。";
  exit;
}

$sql = 'SELECT categories.id as category_id, categories.name as category_name, spendings.id as spending_id, spendings.name, spendings.amount, spendings.accrual_date 
        FROM categories 
        JOIN spendings ON categories.id = spendings.category_id 
        WHERE spendings.id = :id';
        
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$spending = $statement->fetch(PDO::FETCH_ASSOC);

if (!$spending) {
  echo "支出データが見つかりません。";
  exit;
}

// 収入データの各値を変数に格納
$spending_name = $spending['name'];
$category_id = $spending['category_id'];
$spending_amount = $spending['amount'];
$accrual_date = $spending['accrual_date'];
$category_name = $spending['category_name'];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>支出編集ページ</title>
</head>
<body>
  <div class="navi">
    <ul>
      <li><a href="../index.php">HOME</a></li>
      <li><a href="../incomes/index.php">収入TOP</a></li>
      <li><a href="./index.php">支出TOP</a></li>
      <li><a href="../user/logout.php">ログアウト</a></li>
    </ul>
  </div>
  <section class="spending_edit">
    <h2>支出編集</h2>

    <!-- エラーメッセージの表示 -->
    <?php if (!empty($errors)): ?>
      <ul>
        <?php foreach($errors as $error): ?>
          <li><?php echo $error; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <!-- 編集フォーム -->
    <form action="./update.php" method="post">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
      <label>支出名
        <input type="text" name="spending_name" value="<?php echo htmlspecialchars($spending_name, ENT_QUOTES, 'UTF-8'); ?>">
      </label>
      <label>カテゴリー:
        <select name="category_id" id="">
          <?php 
              $sql = 'SELECT id, name FROM categories';
              $statement = $pdo->prepare($sql);
              $statement ->execute();
              while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($row['id'] == $category_id) ? 'selected' : '';
                echo '<option value="'.htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8').'">'.$row['name'].'</option>';

                $selected = ($row['id'] == $category_id) ? 'selected' : ''; // URLパラメータで渡されたカテゴリーIDと一致する場合にselected属性を追加
                echo '<option value="'.htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8').'" '.$selected.'>'.$row['name'].'</option>';
              }
            ?>
        </select>
      </label>
      <label>金額:
        <input type="text" name="amount" value="<?php echo htmlspecialchars($spending_amount , ENT_QUOTES, 'UTF-8'); ?>">円
      </label>
      <label>日付:
        <input type="date" name="date" value="<?php echo htmlspecialchars($accrual_date, ENT_QUOTES, 'UTF-8'); ?>">
      </label>
      <button type="submit">編集</button>
    </form>
  </section>
</body>
</html>

