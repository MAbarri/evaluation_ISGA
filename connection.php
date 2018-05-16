<?php
require "config.php";

try{
  $connection = new PDO("mysql:host=$host", $username, $password, $options);
} catch (PDOException $e){
  echo "Error!".$e->getMessage();
}

?>
