<?php
  $servername = "localhost";
  $username = "root";
  $password = "killerm111";
  $dbname = "abredb";
  $emojimood = $_GET['moodval'];//works
  date_default_timezone_set('America/Indiana/Indianapolis');
  $datevar = date('Y-m-d');//works
  $timevar = date("H:i");
  //$datefix = date('Y-m-d H:i:s', strtotime('+3 hours'))
  //$userid=finduseridcore($_SESSION['useremail']);

  //NEED: get session email working && fix hour difference

  //Required configuration files
  require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
  require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
  require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
  $stmt = $db->stmt_init();
  $sessionemail=$_SESSION['useremail'];
  $sql="INSERT INTO mood_table (Email, Daterow, Timerow, Feeling) VALUES ('sessionemail','$datevar', '$timevar', '$emojimood')";
  $stmt->prepare($sql);
  $stmt->execute();
  $stmt->close();
  $db->close();
  header("Location:http://localhost:8080/#books");
  exit;
?>
