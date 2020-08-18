<?php

$login = $_POST['login'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

//Проверяем поля на основные возможные ошибки

if (!isset($name) || empty($name)) {
  $result = ['type' => 'noName'];
  echo json_encode($result);
  exit();
}

if (!isset($login) || empty($login)) {
  $result = ['type' => 'noLogin'];
  echo json_encode($result);
  exit();
}

if (!isset($email) || strlen($email) == 0) {
  $result = ['type' => 'noEmail'];
  echo json_encode($result);
  exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $result = ['type' => 'filterEmail'];
  echo json_encode($result);
  exit();
}
if (strlen($email) < 4) {
  $result = ['type' => 'shotEmail'];
  echo json_encode($result);
  exit();
}

if (!isset($password) || empty($password)) {
  $result = ['type' => 'noPassword'];
  echo json_encode($result);
  exit();
}

if (!isset($password_confirm) || empty($password_confirm)) {
  $result = ['type' => 'noConfirm'];
  echo json_encode($result);
  exit();
} elseif ((isset($password) && isset($password_confirm)) && ($password != $password_confirm)) {
  $result = ['type' => 'passNoConfirm'];
  echo json_encode($result);
  exit();
}

//Подключаем БД

$xmlString = file_get_contents('database/db.xml');
$xml = simplexml_load_string($xmlString);
$json = json_encode($xml);
$array = json_decode($json,TRUE);

// Проверяем существет ли логин или почта

if ($xml->count() != 0) {
  if(isset($xml->$login)) {
    $result = ['type' => 'loginExist'];
    echo json_encode($result);
    exit();
  }
  foreach ($array as $key => $value) {
    if ($value['email'] === $email) {
      $result = ['type' => 'emailExist'];
      echo json_encode($result);
      exit();
    }
  }
}

//  Добавляем нового пользователя в БД

$xmldoc = new DomDocument( '1.0' );
$xmldoc->preserveWhiteSpace = FALSE;
$xmldoc->formatOutput = TRUE;
$hash = password_hash($password, PASSWORD_DEFAULT);
$xmldoc->loadXML($xmlString, LIBXML_NOBLANKS);

$root = $xmldoc->getElementsByTagName('users')->item(0);
$user = $xmldoc->createElement($login);
$root->insertBefore( $user, $root->firstChild );

$nameElement = $xmldoc->createElement('login');
$user->appendChild($nameElement);
$value = $xmldoc->createTextNode($login);
$nameElement->appendChild($value);

$nameElement = $xmldoc->createElement('name');
$user->appendChild($nameElement);
$value = $xmldoc->createTextNode($name);
$nameElement->appendChild($value);

$nameElement = $xmldoc->createElement('email');
$user->appendChild($nameElement);
$value = $xmldoc->createTextNode($email);
$nameElement->appendChild($value);

$nameElement = $xmldoc->createElement('password');
$user->appendChild($nameElement);
$value = $xmldoc->createTextNode($hash);
$nameElement->appendChild($value);

$xmldoc->save('database/db.xml');

//Возвращаем результат

$result = ['type' => 'success'];
echo json_encode($result);
exit();

?>
