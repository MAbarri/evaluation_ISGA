<?php
require "config.php";

try{
  $connection = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e){
  echo "Error!".$e->getMessage();
}

?>
