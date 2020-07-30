<?php
session_start();
include("function.php");
loginCheck();

$pdo = db_connect();

$id = $_SESSION["pass"];

// データ登録SQL作成
$sql = "SELECT * FROM follow_table INNER JOIN g_user_table ON follow_table.you = g_user_table.pass WHERE follow_table.me =  $id";

// SQL準備&実行
// $stmt->bindParam(':id', $id, PDO::PARAM_STR);
$stmt = $pdo->prepare($sql);
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
  // var_dump($result);
  // exit();
  $output = "<table>";
  // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
  // `.=`は後ろに文字列を追加する，の意味
  foreach ($result as $record) {
    $output .= "<tr><br>"; 
    $output .= "<td><a href='user_read.php?id={$record["you"]}'>○{$record["usern"]}</a></td>";
    $output .= "<td><a href='delete.php?id={$record["you"]}'>フォロー外す</a></td>";
    $output .= "</tr>";
  }
  $output .= "</table>";
  // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
  // 今回は以降foreachしないので影響なし
  unset($value);
}
  
  // $id = $_SESSION["user_id"];

  // // データ登録SQL作成
  // $stmt = $pdo->prepare("SELECT * from couple_table where me = :id");
  
  
  // // SQL準備&実行
  // $stmt->bindParam(':id', $id, PDO::PARAM_STR);
  
  // $status = $stmt->execute(); 
  
  // // データ登録処理後
  // if ($status == false) {
  //   // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  //   $error = $stmt->errorInfo();
  //   echo json_encode(["error_msg" => "{$error[2]}"]);
  //   exit();
  // } else {
  //   // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  //   // fetchAll()関数でSQLで取得したレコードを配列で取得できる
  //   $result = $stmt->fetchALL(PDO::FETCH_ASSOC); // データの出力用変数（初期値は空文字）を設定
  //   // var_dump($result);
  //   // exit();
  //   $output = "";
  //   // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
  //   // `.=`は後ろに文字列を追加する，の意味
  //   foreach ($result as $record) {
  //     $output .= "<tr><br>"; 
  //     $output .= "<td>{$record["you"]}</td>";
  //     $output .= "</tr>";
  //   }
  //   // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
  //   // 今回は以降foreachしないので影響なし
  //   unset($value);
  // }

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>フォローページ</title>
</head>
<body>
  <div class="follow">
      <h1>フォローページ</h1>
      <a href="mypage.php">戻る</a>
      <div class="sc"><?php echo $_SESSION['usern'] ?></div>
      <li><label for="">フォローしているユーザー</label></li>
      <tbody>
        <?= $output ?>
      </tbody>
  </div>
</body>
</html>