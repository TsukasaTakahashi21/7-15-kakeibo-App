<?php
  session_start();
  // セッション変数をすべてクリア
  $_SESSION = array();
  // セッションを破棄
  session_destroy();
  header('Location: ../user/signup.php');
  exit();
?>

