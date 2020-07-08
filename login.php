<?php

session_start();
require('dbconnect.php');

if(!empty($_COOKIE['usermail'])) {
  $usermail = $_COOKIE['usermail'];
}

//POSTが空ではない場合＝送信ボタンを押した時
if (!empty($_POST)) {

  $usermail = $_POST['usermail'];

  // 配列$errorを定義
  $error = array();

  //メール欄が空の場合に、エラーを表示
  if (empty($_POST['usermail'])) {
    $error['usermail'] = '入力してください';
  }
  //パスワードが入力されていない場合にエラーを表示
  if (empty($_POST['userpass'])) {
    $error['userpass'] = '入力してください';
  }
  
  // メール、パスワードが入力されていた場合にDBに接続する
  if (empty($error)) {
    $login = $db->prepare('SELECT * FROM members WHERE usermail=? AND userpass=?');
    $login->execute(array(
      $_POST['usermail'],
      sha1($_POST['userpass']),
    ));
    $member = $login->fetch();

    if ($member) {
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      if ($_POST['check'] === 'on') {
        setcookie('usermail',$_POST['usermail'],time()+60+60*24*14);
      }
      header('Location: review.php');
      exit();
    } else {
      $error['login'] = 'ログインに失敗しました' . "<br>" . 'もう一度入力してください';
    }

  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ゲレンデミシュラン - ログイン</title>
</head>
<link href="https://fonts.googleapis.com/css?family=M+PLUS+1p|Oxanium&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Baloo+Bhai+2:800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<body>
  <div class="wrap">
    <header>
      <div class="header_title">
        <h1>Gelande-Michelin.com</h1>
      </div>
      <div class="header_menu">
        <ul>
          <li>About</li>
          <li>SignUp</li>
          <li>Login</li>
          <li>Review</li>
          <li>Contact</li>
        </ul>
      </div>
    </header>
    <main>
      <div class="main2">
        <h2>ログイン</h2>
        <div class="form-container">
          <p class="signuplogin"><a href="signup.php">新規登録はこちら</a></p>
            <form action="" method="post">
              <div class="form_g 
              <?php if(!empty($_POST)) {
                if(!empty($error['usermail']) || !empty($error['login'])) {
                  echo 'has-error';
                }
              }
              ?>
              ">
                <label><p>メールアドレス：</p><span class="help-block">
                      <?php if(!empty($error['usermail'])) echo $error['usermail'] ?>
                      <?php if(!empty($error['login'])) echo $error['login'] ?>
                    </span>
                <input type="text" name="usermail" placeholder="" value="<?php if(!empty($usermail)) echo $usermail ?>">
                </label>
              </div>
              <div class="form_g <?php if(!empty($error['userpass'])) echo 'has-error' ?>">
                <label><p>パスワード</p><span class="help-block">
                      <?php if(!empty($error['userpass'])) echo $error['userpass'] ?>
                    </span>
                <input type="password" name="userpass" placeholder="" value="<?php if(!empty($_POST['userpass'])) echo $_POST['userpass'] ?>"></label>
              </div>
              <label>
                <input type="checkbox" name="check" value="on" checked>
                <span class="checklogin">アドレスを記憶する</span>
              </label>
              <button type="submit" value="signup" class="send">ログイン</button>
            </form>
          </div>
      </div>
    </main>
  </div>

  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="gelande.js"></script>
</body>
</html>