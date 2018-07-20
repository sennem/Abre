<?php
  $servername = "localhost";
  $username = "root";
  $password = "password";
  $dbname = "abredb";
  $periodnumget = $_GET['periodurlj'];//works
  $emailget = $_GET['emailurlj'];//works
  $roomget = $_GET['roomurlj'];//works
  //Required configuration files
  ?>
  <!--<script>
    var testpnum="<?php //echo $periodnumget; ?>";
    var testemail="<?php //echo $emailget; ?>";
    var testroom="<?php //echo $roomget; ?>";
    alert(testpnum);
    alert(testemail);
    alert(testroom);

  </script>-->
  <?php
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
?>
