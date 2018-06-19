<?php
  $servername = "localhost";
  $username = "root";
  $password = "killerm111";
  $dbname = "abredb";
  $emojimood = $_GET['moodval'];//works
  //$datevar = date('Y-m-d H:i:s');//works
  //$userid=finduseridcore($_SESSION['useremail']);
  //Required configuration files
  require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
  require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
  require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
  $stmt = $db->stmt_init();
  $sql="INSERT INTO mood_table (Email, Date, Feeling) VALUES ('marksenne000@gmail.com,'$date','$emojimood')";
  $stmt->prepare($sql);
  $stmt->execute();
  $stmt->close();
  $db->close();
  //$conn->close(); <-- ERROR CAUSING

?>
