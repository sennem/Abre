<?php
  //Required configuration files
  require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
  require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
  require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
  $servername = "localhost";
  $username = "root";
  $password = "killerm111";
  $dbname = "abredb";
  $emojimood = $_GET['moodval'];
  //$date = date('Y-m-d H:i:s');
  //$userid=finduseridcore($_SESSION['useremail']);
  $stmt = $db->stmt_init();
  $sql="INSERT INTO mood_table (Email, Date, Feeling) VALUES ('marksenne000@mgmail.com','2018-10-11','$moodval')";
  $stmt->prepare($sql);
  $stmt->execute();
  $stmt->close();
  $db->close();
  //$conn->close(); <-- ERROR CAUSING

?>
