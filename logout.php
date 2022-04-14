<?php
    session_start();
    if (!isset($_SESSION['account'])) {
      header('Location: login.php');
      exit();
    }

    if (isset($_COOKIE['CookieUser'])){
      setcookie('CookieUser','',time() - (1000));
      setcookie('CookiePass','',time() - (1000));
    }

    session_destroy();
    header('Location: login.php');
?>