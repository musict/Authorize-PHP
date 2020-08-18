<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/main.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="js/signup.js"></script>
</head>
<body>
  </form>
  <form method="post" id="signup_form" action="" >
    <label>Ваше имя*</label>
    <input type="text" name="name" placeholder="Введите свое имя" required>
    <label>Логин*</label>
    <input type="text" name="login" placeholder="Введите свой логин" required>
    <label>E-mail*</label>
    <input type="email" name="email" placeholder="Введите адрес своей почты" required>
    <label>Пароль*</label>
    <input type="password" name="password" placeholder="Введите пароль" required>
    <label>Подтверждение пароля*</label>
    <input type="password" name="password_confirm" placeholder="Подтвердите пароль" required>
    <input type="button" id="btn" value="Зарегистрироваться" />
    <p>
        У Вас уже есть аккаунт? - <a href="index.php">Войти</a>
    </p>
    <br>
    <div id="result_form"></div>
  </form>
</body>
</html>
