<?php
require('dbconnect.php');
session_start();

if (!isset($_SESSION['join'])) {
  header('Location: login.php');
  exit();
}

if (!empty($_POST)) {
  $statement = $db->prepare('INSERT INTO members SET username=?, usermail=?, userpass=?, created=NOW()');
  $statement->execute(array(
    $_SESSION['join']['username'],
    $_SESSION['join']['usermail'],
    sha1($_SESSION['join']['userpass']),

  ));
  unset($_SESSION['join']);

  header('Location: thanks.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ゲレンデミシュラン - 登録内容確認</title>
</head>
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
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
        <h2>新規登録</h2>
          <div class="form-container">
            <h3>登録内容は下記でよろしいですか？<i class="fas fa-angle-double-left"></i><span class="rewrite"><a href="signup.php?action=rewrite"">書き直す</a></span></h3>

            <form action="" method="post">
              <input type="hidden" name="action" value="submit">
              <dl>
                <dt>ユーザー名</dt>
                <dd><?php echo $_SESSION['join']['username'] ?></dd>
                <dt>メールアドレス</dt>
                <dd><?php echo $_SESSION['join']['usermail'] ?></dd>
                <dt>パスワード</dt>
                <dd>【表示されません】</dd>
              </dl>
              <button type="submit" value="signup" class="send">登録する</button>
              <span class="rewrite"></span>
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