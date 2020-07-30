<?php
session_start();
include("function.php");
loginCheck();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

      <header class="page-header wrapper">
        <h1>GOMI</h1>
        <nav>
          <ul class="main-nav">
            <li><div><?php echo $_SESSION['usern'] ?></div></li>
            <li><a href="my_follow.php">フォロー</a></li>
            <li><a href="file_read.php">ファイル</a></li>
            <li><form action="toko.php" method="POST" >
                <input type="text" value="" name="toko">
                <div>
                  <input type="file" name="upfile" accept="image/*" capture="camera">
                </div>
                <input type="submit" value="投稿"></li>       
            <li>
              <a href="search.php">検索</a>    
              <!-- <form action="search_act.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="search" value="ユーザー検索">
                <input type="submit" value="検索">
              </form> -->
            </li>
            <li><a href="logout.php">ログアウト</a></li>
          </ul>
        </nav>
      </header>
  </div>
  
</body>
</html>