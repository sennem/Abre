<?php
  $servername = "localhost";
  $username = "root";
  $password = "killerm111";
  $dbname = "abredb";
  $periodnum = $_GET['periodurl'];//works
  //Required configuration files
  require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
  require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
  require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
  $stmt = $db->stmt_init();
  $sql="INSERT INTO temp_hold_periodnum (periodnum) VALUES ('$periodnum')";
  $stmt->prepare($sql);
  $stmt->execute();
  $stmt->close();
  $db->close();
  header("Location:http://localhost:8080/#books");
  exit;
?>
