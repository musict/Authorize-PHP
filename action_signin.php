<?php
session_start();

if (isset($_POST["login"]) && isset($_POST["password"]) ) {

  $login = $_POST['login'];
  $password = $_POST['password'];

  $xmlString = file_get_contents('database/db.xml');
  $xml = simplexml_load_string($xmlString);
  $json = json_encode($xml);
  $array = json_decode($json,TRUE);

  // Проверяем логин и пароль в БД
  foreach ($array as $key => $value) {
    if ($value['login'] === $login && password_verify($password, $value['password'])) {

      $_SESSION['auth'] = TRUE;
      $_SESSION['name'] = $value['name'];

      // Добавляем хеш в БД
      $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

      function generateSalt($input, $strength = 16) {
          $input_length = strlen($input);
          $random_string = '';
          for($i = 0; $i < $strength; $i++) {
              $random_character = $input[mt_rand(0, $input_length - 1)];
              $random_string .= $random_character;
          }

          return $random_string;
      }
  		$key = generateSalt($permitted_chars, 20);

  		setcookie('login', $value['login'], time()+3600);
  		setcookie('key', $key, time()+3600);

      $xmldoc = new DomDocument( '1.0' );
      $xmldoc->preserveWhiteSpace = FALSE;
      $xmldoc->formatOutput = TRUE;
      $xml = file_get_contents( 'database/db.xml');
      $xmldoc->loadXML( $xml, LIBXML_NOBLANKS );
      $root = $xmldoc->getElementsByTagName($login)->item(0);
      $hashPath = 'boolean(/users/'.$login.'/hash)';
      $xpath = new DOMXPath($xmldoc);
      $hashNodeExists = $xpath->evaluate($hashPath);

      if($hashNodeExists) {
        $hash = $root->getElementsByTagName('hash')->item(0);
        $root->removeChild($hash);
        $xmldoc->save('database/db.xml');
      }

      $hash = $xmldoc->createElement('hash');
      $root->insertBefore( $hash, $root->firstChild );
      $hashValue = $xmldoc->createTextNode($key);
      $hash->appendChild($hashValue);

      $xmldoc->save('database/db.xml');

      $result = array('status' => TRUE);
      echo json_encode($result);
      exit();
      }
    }
    $result = array('status' => FALSE);
    echo json_encode($result);
}

?>
