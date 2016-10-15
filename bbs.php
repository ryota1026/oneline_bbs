<?php
  // ここにDBに登録する処理を記述する
  
  // データベースへの接続
  $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
  $user = 'root';
  $password='';
  // ※以下はサンプルなので、自身のサーバー情報を設定してください。

  // dbnameをロリポップのデータベース名に、hostをロリポップのサーバーに変更
  // $dsn = 'mysql:dbname=LAA0793008-onelinebbs;host=mysql103.phy.lolipop.lan';
  // // userをロリポップのユーザー名に変更
  // $user = 'LAA0793008';
  // // passwordをロリポップのパスワードに変更
  // $password = 'JKPuhh7583';

  $dbh = new PDO($dsn, $user, $password);
  $dbh->query('SET NAMES utf8'); 
  
  
  //POST送信が行われた時
    if (!empty ($_POST)) {
    $nickname = $_POST['nickname'];
    $comment = $_POST['comment'];
  
    $sql = "INSERT INTO `posts`(`id`,`nickname`,`comment`,`created`) VALUES (null,'".$nickname."','".$comment."',now())";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    }
   
   //action = deleteがGET送信で送られてきた時
    if (!empty($_GET) && ($_GET['action'] == 'delete')) {
    $sql = "DELETE FROM `posts` WHERE `id`= ".$_GET['id'];
    var_dump($sql);
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    }
   
   // //二重に実行されないように。最初のURLへリダイレクト
   // header('Location: bbs.php');

  //SQL文の作成(SELECT文)
  $sql = 'SELECT * FROM `posts` ORDER BY `created` DESC';

  //SELECT文の実行
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  //変数にDBから取得したデータを格納
  
  //格納する変数の初期化
  $posts = array();

  //繰り返し文でデータの取得(arrayの中身(MySQlのデータ)を連想配列の形で一つ一つ$postsにぶち込んでいる)
   while(1){
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
      break; //whileをやめさせるための処理
    }
    //取得したデータを配列に格納しておく
    $posts[] = $rec;
    
   }
  // データベースを切断する
  $dbh = null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Thanks 2 Slang</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/form.css">
  <link rel="stylesheet" href="assets/css/timeline.css">
  <link rel="stylesheet" href="assets/css/main.css">
  <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
  <link href="assets2/css/main.css" rel="stylesheet">
    
  <link rel="stylesheet" href="assets2/css/font-awesome.min.css">
    
  <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    
   <script src="assets2/js/jquery.min.js"></script>
   <script type="text/javascript" src="assets2/js/smoothscroll.js"></script> 
   <script src="assets2/js/Chart.js"></script>
</head>

<body>

  <div id="section-topbar">
    <div id="topbar-inner">
      <div class="container">
        <div class="row">
          <div class="dropdown">
            <ul id="nav" class="nav">
              <li class="menu-item"><a class="smoothScroll" href="#about" title="About"><i class="icon-user"></i></a></li>
              <li class="menu-item"><a class="smoothScroll" href="#fovorite" title="favorite"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
              <li class="menu-item"><a class="smoothScroll" href="#chat" title="chat"><i class="fa fa-comments" aria-hidden="true"></i></a></li>
              <li class="menu-item"><a class="smoothScroll" href="#check" title="Check"><i class="fa fa-check" aria-hidden="true"></i></a></li>
            </ul><!--/ uL#nav -->
          </div><!-- /.dropdown -->

          <div class="clear"></div>
        </div><!--/.row -->
      </div><!--/.container -->

      <div class="clear"></div>
    </div><!--/ #topbar-inner -->
  </div><!--/ #section-topbar -->


  <!-- Bootstrapのcontainer -->
  <div class="container">
    <!-- Bootstrapのrow -->
    <div class="row">

      <!-- 画面左側 -->
      <div class="col-md-4 content-margin-top">
        <!-- form部分 -->
        <form action="bbs.php" method="post">
          <!-- nickname -->
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="nickname" class="form-control" id="validate-text" placeholder="nickname" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- comment -->
          <div class="form-group">
            <div class="input-group" data-validate="length" data-length="4">
              <textarea type="text" class="form-control" name="comment" id="validate-length" placeholder="comment" required></textarea>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- つぶやくボタン -->
          <button type="submit" class="btn btn-primary col-xs-12" disabled>Correct,please!</button>
        </form>
      </div>

      <!-- 画面右側 -->
      <div class="col-md-8 content-margin-top">
        <div class="timeline-centered">
          <?php  
         foreach ($posts as $post_each) { ?>

          <article class="timeline-entry">
              <div class="timeline-entry-inner">
                  <div class="timeline-icon bg-success">
                      <i class="fa fa-spinner" aria-hidden="true"></i>
                      <i class="fa fa-chain-broken" aria-hidden="true"></i>
                  </div>
                  <div class="timeline-label">
                      
                      <h2><a href="#">
                        <?php echo $post_each['nickname'] . ' ';?></a> 
                      <span>
                        <?php $created = strtotime($post_each['created']);
                          $created = date('Y/m/d',$created);
                          echo $created;
                        ?>
                      </span>
                      
                      </h2>
                        <p><?php echo $post_each['comment'] . ' ';?></p><br>
                        <a href="bbs.php?id=<?php echo $post_each['id']?>&action=delete">
                        <i class="fa fa-trash" aria-hidden="true"></i></a>
                  </div>
              </div>
          </article>
            
           <?php } ?>

          <article class="timeline-entry begin">
              <div class="timeline-entry-inner">
                  <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
                      <i class="entypo-flight"></i> +
                  </div>
              </div>
          </article>
        </div>
      </div>

    </div>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/form.js"></script>
</body>
</html>



