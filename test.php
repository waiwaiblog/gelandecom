<?php

const ERROR_NAME = '１０文字以内で入力';
const ERROR_EMPTY = '入力してください';
const ERROR_MAIL = '正しい形式で入力';
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

  if(empty($error)) {
    header('Location: index.html');
    exit();
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
                <label><span class="help-block">
                  <?php if(!empty($error['error_name'])) echo $error['error_name'] ?>
                  <?php if(!empty($error['error_name2'])) echo $error['error_name2'] ?>
                </span>
                <input type="text" name="username" class="username" placeholder="ユーザー名" value="<?php if(!empty($username)) echo $username ?>">
                </label>
              </div>
              <div class="form_g <?php if(!empty($error['error_mail'] || $error['error_mail2'])) echo 'has-error' ?>">
                <label><span class="help-block">
                  <?php if(!empty($error['error_mail'])) echo $error['error_mail'] ?>
                  <?php if(!empty($error['error_mail2'])) echo $error['error_mail2'] ?>
                </span>
                <input type="text" name="usermail" class="usermail" placeholder="メールアドレス" value="<?php if(!empty($usermail)) echo $usermail ?>">
                </label>
              </div>
              <div class="form_g <?php if(!empty($error['error_pass'] || $error['error_pass2'])) echo 'has-error' ?>">
                <label><span class="help-block">
                  <?php if(!empty($error['error_pass'])) echo $error['error_pass'] ?>
                  <?php if(!empty($error['error_pass2'])) echo $error['error_pass2'] ?>
                </span>
                <input type="password" name="userpass" class="serpassu" placeholder="パスワード" value="<?php if(!empty($userpass)) echo $userpass ?>">
                </label>
              </div> 
              <button type="submit" value="signup" class="send">新規登録</button>
            </form>
          </div>
      </div>
    </main>
  </div>

  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="test.js"></script>
</body>
</html>