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
  $sql = 'INSERT INTO `posts`(`id`,`nickname`, `comment`,`created`) VALUES (null,"'.$nickname.'", "'.$comment.'",now())';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  
  while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
      break;
  }
  echo $rec['id'] . '<br>'; 
  echo $rec['nickname'] . '<br>';
  echo $rec['comment'] . '<br>';
  echo '<hr>';
 }
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
  $sql = 'SELECT * FROM `posts`';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  
  while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
      break;
  }
  echo $rec['id'] . '<br>'; 
  echo $rec['nickname'] . '<br>';
  echo $rec['comment'] . '<br>';
  echo $rec['created'] . '<br>';
  echo '<hr>';
 }
  // データベースを切断する
  $dbh = null;
?>

