<?php
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=kakeibo;charset=utf8',
    $dbUserName,
    $dbPassword
);

$errors = [];

// フォームから送信されたデータを取得
$id = isset($_POST['id']) ? $_POST['id'] : '';
$income_source_id = isset($_POST['income_source'] )? $_POST['income_source'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';

// 入力値のバリデーション
if (empty($amount)) {
  $errors[] = '金額を入力してください。';
}
if (empty($date)) {
  $errors[] = '日付を入力してください。';
}

// エラーがなければ更新処理を実行
if (empty($errors)) {
  $sql = 'UPDATE incomes SET income_source_id = :income_source_id, amount = :amount, accrual_date = :accrual_date WHERE id = :id';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':income_source_id', $income_source_id, PDO::PARAM_INT);
  $statement->bindValue(':amount', $amount, PDO::PARAM_INT);
  $statement->bindValue(':accrual_date', $date);
  $statement->bindValue(':id', $id, PDO::PARAM_INT);

  if ($statement->execute()) {
    header('Location: ./index.php');
    exit();
  } else {
    $errors[] = '更新に失敗しました。';
}
}

// エラーがある場合はセッションにエラーメッセージを保存
if (!empty($errors)) {
  $_SESSION['errors'] = $errors;
  header('Location: ./edit.php?id=' . $id); 
  exit();
}
?>
