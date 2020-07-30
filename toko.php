<?php
session_start();
include("function.php");
loginCheck();

if (
  !isset($_POST['toko']) || $_POST['toko'] == '' 
) {
  // 項目が入力されていない場合はここでエラーを出力し，以降の処理を中止する
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

// 受け取ったデータを変数に入れる
$toko = $_POST['toko'];


// ここからファイルアップロード&DB登録の処理を追加しよう！！！
// var_dump($_FILES);
// exit();
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  // 送信が正常に行われたときの処理 
  $uploadedFileName = $_FILES['upfile']['name'];//ファイル名の取得 
  $tempPathName = $_FILES['upfile']['tmp_name']; //tmpフォルダの場所 
  $fileDirectoryPath = 'upload/'; //アップロード先フォルダ

  $extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION); 
  $uniqueName = date('YmdHis').md5(session_id()) . "." . $extension; 
  $fileNameToSave = $fileDirectoryPath.$uniqueName;
  // var_dump($fileNameToSave);
  // exit();

  if (is_uploaded_file($tempPathName)) {
      if (move_uploaded_file($tempPathName, $fileNameToSave)) {
        chmod($fileNameToSave, 0644);  // 権限の変更
      $img = '<img src="'. $fileNameToSave . '" >'; // imgタグを設定
        } else { 
          exit('アップロードできませんでした'); // 画像の保存に失敗 
        }
      } else {
        exit('画像がありません');
      }
} else {
  // 送られていない，エラーが発生，などの場合
  // exit('画像が送信されていません'); 
}


  // DB接続
$pdo = db_connect();

// データ登録SQL作成
// `created_at`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
$sql = 'INSERT INTO toko_table(id, todo, image, created_at, updated_at) VALUES(NULL, :todo, :image,  sysdate(), sysdate())';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
$stmt->bindValue(':image', $fileNameToSave, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  header("Location:file_read.php.php");
  exit();
}
