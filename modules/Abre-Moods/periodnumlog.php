<?php
  $servername = "localhost";
  $username = "root";
  $password = "password";
  $dbname = "abredb";
  $periodnumget = $_GET['periodurl'];//works
  $emailget = $_GET['emailurl'];//works
  $roomget = $_GET['roomurl'];//works
  $iswidget= $_GET['fromwidget'];
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

  $sql="UPDATE teacher_data SET PeriodSelection='$periodnumget' WHERE Email='$emailget' AND Roomnum='$roomget'";
  $conn->query($sql);
  $conn->close();
  if($iswidget==0)
  {
    header("Location:http://localhost:8080/#moods");
  }
  elseif($iswidget==1)
  {
    header("Location:http://localhost:8080/");
  }

  exit;
  //all works
?>
