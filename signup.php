<?php

session_start();
require('dbconnect.php');

const ERROR_NAME = '１０文字以内で入力';
const ERROR_EMPTY = '入力してください';
const ERROR_MAIL = '正しい形式で入力';
const ERROR_MAIL2 = '登録済のアドレスです';
const ERROR_COMMENT = '４文字以上で入力';

if (!empty($_POST)) {
  $error = array();

  $username = $_POST['username'];
  $usermail = $_POST['usermail'];
  $userpass = $_POST['userpass'];

  if(empty($username)) {
    $error['error_name'] = ERROR_EMPTY;
  }
  if(!empty($username)) {
    if(strlen($username) > 10) {
      $error['error_name2'] = ERROR_NAME;
    }
  }

  if(empty($usermail)) {
    $error['error_mail'] = ERROR_EMPTY;
  }
  if(!empty($usermail)) {
    $reg_str = '/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/';

    if (!preg_match($reg_str, $usermail)) {
      $error['error_mail2'] = ERROR_MAIL;
    }
  }

  if(empty($userpass)) {
    $error['error_pass'] = ERROR_EMPTY;
  }
  if(!empty($userpass)) {
    if(strlen($userpass) < 4) {
      $error['error_pass'] = ERROR_COMMENT;
    }
  }

  //アカウント重複チェック
  if(empty($error)) {
    $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE usermail=?');
    $member->execute(array($_POST['usermail']));
    $record = $member->fetch();
    
    if($record['cnt'] > 0) {
      $error['error_mail3'] = ERROR_MAIL2;
    }
  }

  if(empty($error)) {
    $_SESSION['join'] = $_POST;
    header('Location: check.php');
    exit();
  }
}

if (!empty($_GET)) {
  if($_GET['action'] === 'rewrite' && isset($_SESSION['join'])) {
    $_POST = $_SESSION['join'];
  }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ゲレンデミシュラン - 新規登録</title>
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
        <h2>新規登録</h2>
          <div class="form-container">
            <form action="" method="post">
              <div class="form_g <?php if(!empty($error['error_name'] || $error['error_name2'])) echo 'has-error' ?>">
                <label><p>お名前</p><span class="help-block">
                  <?php if(!empty($error['error_name'])) echo $error['error_name'] ?>
                  <?php if(!empty($error['error_name2'])) echo $error['error_name2'] ?>
                </span>
                <input type="text" name="username" class="username" placeholder="" value="<?php if(!empty($_POST['username'])) echo $_POST['username'] ?>">
                </label>
              </div>
              <div class="form_g <?php if(!empty($error['error_mail'] || $error['error_mail2'] || $error['error_mail3'])) echo 'has-error' ?>">
                <label><p>メールアドレス：</p><span class="help-block">
                  <?php if(!empty($error['error_mail'])) echo $error['error_mail'] ?>
                  <?php if(!empty($error['error_mail2'])) echo $error['error_mail2'] ?>
                  <?php if(!empty($error['error_mail3'])) echo $error['error_mail3'] ?>
                </span>
                <input type="text" name="usermail" class="usermail" placeholder="" value="<?php if(!empty($_POST['usermail'])) echo $_POST['usermail'] ?>">
                </label>
              </div>
              <div class="form_g <?php if(!empty($error['error_pass'] || $error['error_pass2'])) echo 'has-error' ?>">
                <label><p>パスワード：</p><span class="help-block">
                  <?php if(!empty($error['error_pass'])) echo $error['error_pass'] ?>
                  <?php if(!empty($error['error_pass2'])) echo $error['error_pass2'] ?>
                </span>
                <input type="password" name="userpass" class="userpass" placeholder="" value="<?php if(!empty($_POST['userpass'])) echo $_POST['userpass'] ?>">
                </label>
              </div> 
              <button type="submit" value="signup" class="send">内容を確認</button>
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