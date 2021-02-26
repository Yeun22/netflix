<?php
  $host_name = 'db5001335798.hosting-data.io';
  $database = 'dbs1135262';
  $user_name = 'dbu1534695';
  $password = 'Netflix-Project2020';
  $db = null;



  try {
    $db = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
  } catch (PDOException $e) {
    echo "Erreur!: " . $e->getMessage() . "<br/>";
    die();
  }
?>
