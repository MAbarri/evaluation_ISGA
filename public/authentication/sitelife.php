
<?php
  // Init session
  session_start();

  // Include db config
  require_once '../connection.php';

  // Validate login
  if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
    header('location: authentication/login.php');
    exit;
  }
?>
