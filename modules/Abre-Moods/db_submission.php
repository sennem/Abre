<?php
  $servername = "localhost";
  $username = "root";
  $password = "killerm111";
  $dbname = "abredb";
  $emojimood = $_GET['moodval'];
  //Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
  //^^^ALL ABOVE WORKS^^

  //$userid=finduseridcore($_SESSION['useremail']);
  $sql="INSERT INTO mood_table (Email, Date, Feeling) VALUES ('$userid','2018-11-11','3')";
  $conn->close();

?>
