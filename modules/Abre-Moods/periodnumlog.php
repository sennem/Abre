<?php
  $periodnum = $_GET['periodurl'];
  $email = $_GET['emailurl'];
  $room = $_GET['roomurl'];

  //Required configuration files
  require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
  require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
  require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
  // Create connection
  $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

  // sql to delete a record
  /*$sql = "DELETE FROM temp_hold_periodnum";
  $conn->query($sql);
  $sql = "INSERT INTO temp_hold_periodnum (periodnum) VALUES ('$periodnumget')";
  $conn->query($sql);*/

  $sql="UPDATE teacher_data SET PeriodSelection='$periodnum' WHERE Email='$email' AND Roomnum='$room'";
  $conn->query($sql);
  $conn->close();
  header("Location:http://localhost:8080/#moods");

?>
