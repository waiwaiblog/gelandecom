<?php
$user = 'gelandetarou';
$pass = 'password';

try {
  $db = new PDO('mysql:dbname=gelandecom;host=localhost;charset=utf8', $user, $pass);

} catch (PDOException $e) {
  echo 'エラーです。:' . $e->getMessage();
}

?>