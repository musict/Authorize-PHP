<?php
session_start();
require_once "check_cookie.php";
if (empty($_SESSION['auth']) or $_SESSION['auth'] == FALSE) {
  checkCookie();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="js/signin.js"></script>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <form method="post" id="signin_form" action="" >
      <input type="text" name="login" placeholder="Введите свой логин*" required><br>
      <input type="password" name="password" placeholder="Введите пароль*" required><br>
      <input type="button" id="btn" value="Войти" />
      <p>
          У Вас нет аккаунта? - <a href="register.php">Зарегистрируйтесь</a>
      </p>
      <br>
      <div id="result_form"></div>
  </form>
</body>
</html>
