<?php

session_start();
require('dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] +3600 > time()) {
  $_SESSION['time'] = time();

  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();
} else {
  header('Location: login.php');
  exit();
}


const MSG_EMPTY = '入力してください';
const MSG_EMPTY2 = '選択してください';

//投稿ボタンがクリックされたとき
if(!empty($_POST)) {

  $error = array();
  //ゲレンデ名がからの場合、エラーを表示する
  if(empty($_POST['gelande_name'])) {
    $error['gelande_name'] = MSG_EMPTY;
  }
  //エリアがからの場合、エラーを表示する
  if(empty($_POST['area'])) {
    $error['area'] = MSG_EMPTY2;
  }
  //星がからの場合、エラーを表示する
  if(empty($_POST['star'])) {
    $error['star'] = MSG_EMPTY2;
  }
  //コメントがからの場合、エラーを表示する
  if(empty($_POST['comment'])) {
    $error['comment'] = MSG_EMPTY;
  }
  
  // エラーがない場合、次に進む
  if (empty($error)) {
    $message = $db->prepare('INSERT INTO posts SET member_id=?,gelande_name=?,area=?,star=?,comment=?,created=NOW()');
    $message->execute(array(
      $member['id'],
      $_POST['gelande_name'],
      $_POST['area'],
      $_POST['star'],
      $_POST['comment'],
    ));
    header('Location: review.php');
    exit();
  }

}

if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
  $page = $_REQUEST['page'];

} else {
  $page = 1;
}

$start = 5 * ($page - 1);


$posts = $db->prepare('SELECT m.username,p.* FROM members m,posts p WHERE m.id=p.member_id ORDER BY p.created DESC LIMIT ?,5');
$posts->bindParam(1, $start, PDO::PARAM_INT);
$posts->execute()



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ゲレンデミシュラン - レビュー</title>
</head>
<link href="https://fonts.googleapis.com/css?family=M+PLUS+1p|Oxanium&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Baloo+Bhai+2:800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<style>
  body a {
    text-decoration: none;
    color: rgba(1,1,1,1);
  }
</style>
<body>
  <div class="wrap">
    <header>
      <div class="header_title">
        <h1>Gelande-Michelin.com</h1>
      </div>
      <div class="header_menu2">
        <ul>
          <li>こんにちは、<?php echo $member['username'] ?>さん</li>
          <a href="logout.php"><li>Logout</li></a>
        </ul>
      </div>
    </header>
    <main>
      <div class="main2">
        <h2>レビューを投稿する</h2>
          <div class="form-container">
            <form action="" method="post">
              <div class="form_g">
                <label><span class="help-block">
                </span><p>名前： <?php echo $member['username'] ?> さん</p>

                </label>
              </div>
              <div class="form_g">
                <label><p>ゲレンデ名：<span class="help-block <?php if(!empty($error['gelande_name'])) echo 'has-error' ?>">
                <?php if(!empty($error['gelande_name'])) echo $error['gelande_name'] ?>
                </span></p>
                <input type="text" name="gelande_name" class="" placeholder="" value="">
                </label>
              </div>
              <div class="form_g">
                <label>
                <p>エリア：<span class="help-block <?php if(!empty($error['area'])) echo 'has-error' ?>">
                <?php if(!empty($error['area'])) echo $error['area'] ?>
                </span></p>
                <select name="area">
                  <option value="">選択してください</opction>
                  <option value="1">北海道</option>
                  <option value="2">東北</option>
                  <option value="3">関東甲信越</option>
                  <option value="4">北陸東海</option>
                  <option value="5">近畿</option>
                  <option value="6">中四国九州</option>
                </select>
                </label>
              </div>
              <div class="form_g">
                <label><span class="help-block <?php if(!empty($error['star'])) echo 'has-error' ?>"><?php if(!empty($error['star'])) echo $error['star'] ?></span><br>
                  <p>星：
                  <input type="hidden" name="star" value="">
                  <input type="radio" name="star" value="5"><img src="star.png"> 5
                  <input type="radio" name="star" value="4"><img src="star.png"> 4
                  <input type="radio" name="star" value="3"><img src="star.png"> 3
                  <input type="radio" name="star" value="2"><img src="star.png"> 2
                  <input type="radio" name="star" value="1"><img src="star.png"> 1
                </p>
                </label>
              <div class="form_g">
                <label>
                <p>コメント：<span class="help-block <?php if(!empty($error['comment'])) echo 'has-error' ?>"><?php if(!empty($error['comment'])) echo $error['comment'] ?></span></p>
                <textarea name="comment"></textarea>
                </label>
              </div> 
              <button type="submit" value="signup" class="send">投稿する</button>
            </form>
          </div>
      </div>
    </main>
  </div>

  <div class="msg" id="anker">
    <h1>投稿一覧</h1>
  <?php foreach($posts as $post): ?>
    <div class="msg_repeat">
      <h2><?php echo $post['gelande_name'] ?>
      <span>（
        <?php if($post['area'] === '1') echo '北海道' ?>
        <?php if($post['area'] === '2') echo '東北' ?>
        <?php if($post['area'] === '3') echo '関東甲信越' ?>
        <?php if($post['area'] === '4') echo '北陸東海' ?>
        <?php if($post['area'] === '5') echo '近畿' ?>
        <?php if($post['area'] === '6') echo '中四国九州' ?>
      エリア）</span>
      </h2>
      <p>
        <?php if($post['star'] === '5') echo '<img src="star.png"><img src="star.png"><img src="star.png"><img src="star.png"><img src="star.png">' ?>
        <?php if($post['star'] === '4') echo '<img src="star.png"><img src="star.png"><img src="star.png"><img src="star.png">' ?>
        <?php if($post['star'] === '3') echo '<img src="star.png"><img src="star.png"><img src="star.png">' ?>
        <?php if($post['star'] === '2') echo '<img src="star.png"><img src="star.png">' ?>
        <?php if($post['star'] === '1') echo '<img src="star.png">' ?>
      </p>
      <p class="cmt"><?php echo $post['comment'] ?><p>
      <p class="comment_table">
      <span><?php echo $post['username'] ?></span>
      <span><?php echo $post['created'] ?></span>

      <?php if ($_SESSION['id'] === $post['member_id']): ?>
      [<a href="delete.php?id=<?php echo $post['id'] ?>">削除</a>]
      <?php endif; ?>

      </p>
    </div>
  <?php endforeach; ?>
  </div>
  <div class="pages">
      <ul class="paging">
      <?php if($page >= 2): ?>
      <li><a href="review.php?page=<?php echo ($page-1) ?>#anker">前のページへ</a></li>
      <?php endif; ?>
      <?php 
      //COUNTで件数をとってきて、cntに代入する
      $counts = $db->query('SELECT COUNT(*) as cnt FROM posts');
      //fetchでデータを受け取る。受け取ったcntは配列になっている。
      $count = $counts->fetch();
      //ceilは切り上げ　
      $max_page = ceil($count['cnt'] / 5);
      //$pageの上限下限を決める
      $page = min($page, $max_page);
      if ($page < $max_page):
      ?>
      <li><a href="review.php?page=<?php echo ($page+1) ?>#anker">次のページへ</a></li>
      <?php endif; ?>
      </ul>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="gelande.js"></script>
</body>
</html>