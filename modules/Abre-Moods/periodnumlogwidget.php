<?php
  $periodnum = $_POST['periodurl'];
  $email = $_POST['emailurl'];
  $room = $_POST['roomurl'];

  $servername = "localhost";
  $username = "root";
  $password = "password";
  $dbname = "abredb";

  //Required configuration files
  require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
  require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
  require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // sql to delete a record
  /*$sql = "DELETE FROM temp_hold_periodnum";
  $conn->query($sql);
  $sql = "INSERT INTO temp_hold_periodnum (periodnum) VALUES ('$periodnumget')";
  $conn->query($sql);*/

  $sql="UPDATE teacher_data SET PeriodSelection='$periodnum' WHERE Email='$email' AND Roomnum='$room'";
  $conn->query($sql);
  $conn->close();

?>
