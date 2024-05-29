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
$spending_name = isset($_POST['spending_name'] )? $_POST['spending_name'] : '';
$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';


// バリデーション
if (empty($spending_name)) {
    $errors[] = '支出名が入力されていません';
}

if (empty($category_id)) {
    $errors[] = 'カテゴリが入力されていません';
}
if (empty($amount)) {
    $errors[] = '金額が入力されていません';
}
if (empty($date)) {
    $errors[] = '日付が入力されていません';
}

// エラーがなければ更新処理を実行
if (empty($errors)) {
    $sql = 'UPDATE spendings SET category_id = :category_id, name = :spending_name, amount = :amount, accrual_date = :accrual_date WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
    $statement->bindValue(':spending_name', $spending_name, PDO::PARAM_STR);
    $statement->bindValue(':amount', $amount);
    $statement->bindValue(':accrual_date', $date, PDO::PARAM_STR);
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

