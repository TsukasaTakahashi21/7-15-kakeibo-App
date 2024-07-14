<?php
session_start();
require_once '../../Config/db.php';
require_once '../../vendor/autoload.php';

use App\Infrastructure\Repository\IncomeRepository;
use App\UseCase\Interactor\Income\EditIncomeInteractor;
use App\Presentation\Controller\Income\EditIncomeController;
use App\Presentation\Controller\IncomeSource\IncomeSourceController;

$controller = new IncomeSourceController();
$incomeSources = $controller->index();

$pdo = getPdo();
$incomeRepository = new IncomeRepository($pdo);
$editIncomeInteractor = new EditIncomeInteractor($incomeRepository);
$controller = new EditIncomeController($editIncomeInteractor);

$id = $_GET['id'] ?? null;
$income = $incomeRepository->findById($id);
$incomeAmount = $income->getAmount()->getValue();
$incomeDate = $income->getAccrualDate()->getValue();
$incomeSourceId = $income->getIncomeSourceId()->getValue(); 

$errors = isset($_SESSION['errors']) ?? '';
unset($_SESSION['errors']);

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
      <?php if (!empty($_SESSION['errors'])): ?>
        <ul>
          <?php foreach($_SESSION['errors'] as $error): ?>
            <li><?php echo htmlentities($error, ENT_QUOTES, 'UTF-8'); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php unset($_SESSION['errors']);
            endif; ?>

      <!-- 編集フォーム -->
      <form action="./update.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
        <label>収入源:
        <select name="income_source" id="">
          <?php foreach ($incomeSources as $source): ?>
              <option value="<?php echo $source['id']; ?>" <?php echo ($source['id'] == $incomeSourceId) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($source['name'], ENT_QUOTES, 'UTF-8'); ?>
              </option>
          <?php endforeach; ?>
      </select>
          <a href="income_sources/index.php">収入源一覧へ</a>
        </label><br>
        <label>金額:
          <input type="text" name="amount" value="<?php echo htmlspecialchars($incomeAmount, ENT_QUOTES, 'UTF-8'); ?>">円
        </label><br>
        <label>日付:
          <input type="date" name="date" value="<?php echo htmlspecialchars($incomeDate, ENT_QUOTES, 'UTF-8'); ?>">
        </label><br>
        <button type="submit">編集</button>
      </form>
  </section>
</body>  
</html>
