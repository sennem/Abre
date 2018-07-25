<?php
  $servername = "localhost";
  $username = "root";
  $password = "password";
  $dbname = "abredb";
  //$emojimood = $_GET['moodval'];
  //$widgetbool = $_GET['widget'];
  $emojimood = $_POST['moodval'];
  $widgetbool = $_POST['widget'];
  ?>
  <script>
    alert('<?php echo $widgetbool; ?>');
  </script>
  <?php
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
  $email=$_SESSION['useremail'];

  $stmt1 = $db->stmt_init();
  $sql1="INSERT INTO mood_table (Email, Daterow, Timerow, Feeling) VALUES ('$email','$datevar', '$timevar', '$emojimood')";
  $stmt1->prepare($sql1);
  $stmt1->execute();
  $stmt1->close();

  $stmt2 = $db->stmt_init();
  $sql2="UPDATE students_schedule SET RecentFeeling ='$emojimood' WHERE Email='$email'";
  $stmt2->prepare($sql2);
  $stmt2->execute();
  $stmt2->close();
  $db->close();

  if ($widgetbool==0)
  {
    header("Location:http://localhost:8080/#moods");
  }
  else
  {
    header("Location:http://localhost:8080/");
  }
  echo $widgetbool;
?>
