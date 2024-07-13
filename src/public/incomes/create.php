<?php
session_start();
require_once '../../Config/db.php'; 
require_once '../../vendor/autoload.php';

use App\Presentation\Controller\IncomeSource\IncomeSourceController;

$controller = new IncomeSourceController();
$incomeSources = $controller->index();

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : '';
unset($_SESSION['errors']);
$pdo = getPdo();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TOPページ</title>
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

  <section class="add-income">
    <h2 class="section-title">収入登録</h2>
    <!-- エラーメッセージ表示 -->
    <?php if (!empty($errors)): ?>
      <ul>
        <?php foreach($errors as $error): ?>
          <li><?php echo htmlspecialchars($error ?? '', ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form action="./store.php" method="post">
      <label>収入源:
        <!-- 収入源の選択フォーム -->
        <select name="income_source" id="">
          <option value="">収入源を選んでください</option>
          <?php foreach ($incomeSources as $source): ?>
              <option value="<?php echo $source['id']; ?>"><?php echo $source['name']; ?></option>
          <?php endforeach; ?>
        </select>
        
        <a href="income_sources/index.php">収入源一覧へ</a>
      </label><br>
      <label>金額
        <input type="text" name="amount" value="">円
      </label><br>
      <label>日付
        <input type="date" name="date" value="">
      </label><br>
      <button type="submit">登録</button>
    </form>
    <a href="index.php">戻る</a>
  </section>
</body>
</html>

