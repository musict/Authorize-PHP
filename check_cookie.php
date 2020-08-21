<?php

function checkCookie() {
    session_start();

    $login = $_COOKIE['login'];
    $hash = $_COOKIE['key'];

    $xmlString = file_get_contents('database/db.xml');
    $xml = simplexml_load_string($xmlString);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);

    foreach ($array as $key => $value) {
      if ($value['login'] === $login && $value['hash'] === $hash) {
        $_SESSION['auth'] = TRUE;
        $_SESSION['name'] = $value['name'];
        header('Location: profile.php');
        exit();
      }
    }
}


?>
