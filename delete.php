<?php

// 送信データのチェック
// var_dump($_GET);
// exit();
session_start();
// 関数ファイルの読み込み
include("function.php");
loginCheck();

// 送信データ受け取り
$you = $_GET["id"];
$me = $_SESSION["pass"];
// echo $you;
// echo '<br>';
// echo $me;
// exit();
// DB接続
$pdo = db_connect();

// DELETE文を作成&実行
$sql = "DELETE FROM follow_table WHERE (me=:me && you=:you) OR (me=:you && you=:me)";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':me', $me, PDO::PARAM_STR);
$stmt->bindValue(':you', $you, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は一覧ページファイルに移動し，一覧ページの処理を実行する
  header("Location:my_follow.php");
  exit();
}