<?php
  // ここにDBに登録する処理を記述する
  $nickname = htmlspecialchars($_POST['nickname']);
  $comment = htmlspecialchars($_POST['comment']);

  // データベースへの接続
  $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
  $user = 'root';
  $password='';

  $dbh = new PDO($dsn, $user, $password);
  $dbh->query('SET NAMES utf8'); 
  
  // SQl文の実行
  $sql = 'INSERT INTO `posts`(`nickname`, `comment`) VALUES ("'.$nickname.'", "'.$comment.'")';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  
  // データベースを切断する
  $dbh = null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>
</head>
<body>
    <form method="post" action="">
      <p><input type="text" name="nickname" placeholder="nickname"></p>
      <p><textarea type="text" name="comment" placeholder="comment"></textarea></p>
      <p><button type="submit" >つぶやく</button></p>
    </form>
    <!-- ここにニックネーム、つぶやいた内容、日付を表示する -->
    

</body>
</html>