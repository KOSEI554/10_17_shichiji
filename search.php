<?php
session_start();
include("function.php");
loginCheck();

if(!empty($_POST)){
    // DB接続の設定
    $dbn = 'mysql:dbname=gsf_d06_db17;charset=utf8;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';
  
  
  try {
    // ここでDB接続処理を実行する
    $pdo = new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    // DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }
  
  $search = $_POST["search"];
  
  // データ登録SQL作成
  $stmt = $pdo->prepare("SELECT * from g_user_table where pass = :search");
  
  
  // SQL準備&実行
  $stmt->bindParam(':search', $search, PDO::PARAM_STR);
  
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
    foreach ($result as $record) {
      $output .= "<tr><br>"; 
      $output .= "<td>{$record["usern"]}</td>";
      $output .= "<td><a href='follow.php?id={$search}'>フォローする</a></td>";
      $output .= "</tr>";
    }
    // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($value);
  }
}else{

}



?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Document</title>
</head>
<body>
  <div class="search">
    <p><a href="mypage.php">戻る</a></p>
    <form action="search.php" method="POST">
        <p>ユーザー検索</p>
        <input type="text" name="search">
        <input type="submit" value="検索">
        <input type="hidden" value="<?=$search?>" name="you">
      </form>

    <?php if(!empty($_POST)){?>
      <tbody>
        <?= $output ?>
      </tbody>
    <?php }?>
  </div>

</body>
</html>