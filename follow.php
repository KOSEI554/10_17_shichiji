<?php
// var_dump($_GET);
// exit();

session_start();

// 関数ファイルの読み込み
include("function.php");

// $user_id = $_GET["id"];
$you = $_GET["id"];
$me = $_SESSION["pass"];


$pdo = db_connect();

// データ取得SQL作成
$sql = 'INSERT INTO follow_table (id,me,you) VALUES (NULL,:me,:you)';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':me', $me, PDO::PARAM_INT);
$stmt->bindValue(':you', $you, PDO::PARAM_INT);
$status = $stmt->execute();

  // データ登録処理後
  if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
  } else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    // fetchAll()関数でSQLで取得したレコードを配列で取得できる
    $result = $stmt->fetchALL(PDO::FETCH_ASSOC); // データの出力用変数（初期値は空文字）を設定
    $output = "";
    // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
    // `.=`は後ろに文字列を追加する，の意味
    // foreach ($result as $record) {
    //   $output .= "<tr><br>"; 
    //   $output .= "<td>{$record["you"]}</td>";
    //   $output .= "</tr>";
    // }
    // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($value);
    header("Location:my_follow.php?id=".$you);
  }

  $sql = 'INSERT INTO follow_table (id,me,you) VALUES (NULL,:you,:me)';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':me', $me, PDO::PARAM_INT);
$stmt->bindValue(':you', $you, PDO::PARAM_INT);
$status = $stmt->execute();

  // データ登録処理後
  if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
  } else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    // fetchAll()関数でSQLで取得したレコードを配列で取得できる
    $result = $stmt->fetchALL(PDO::FETCH_ASSOC); // データの出力用変数（初期値は空文字）を設定
    $output = "";
    // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
    // `.=`は後ろに文字列を追加する，の意味
    // foreach ($result as $record) {
    //   $output .= "<tr><br>"; 
    //   $output .= "<td>{$record["you"]}</td>";
    //   $output .= "</tr>";
    // }
    // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($value);
    header("Location:my_follow.php?id=".$you);
  }

?>

<!-- <!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <li><label for="">パートナー</label></li>
  <tbody>
    <?= $output ?>
  </tbody>
</body>
</html> -->