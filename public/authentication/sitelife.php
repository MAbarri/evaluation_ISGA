
<?php
  // Init session
  session_start();

    // define('__ROOT__', dirname(dirname(__FILE__)));
  // Include db config
  require_once dirname(dirname(dirname(__FILE__))).'\connection.php';

  // Validate login
  if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
    header('location: authentication/login.php');
    exit;
  }
?>
