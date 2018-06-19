<?php
  $servername = "localhost";
  $username = "root";
  $password = "killerm111";
  $dbname = "abredb";
  $emojivaluetest = $_GET['moodval'];
  echo $emojivaluetest;
  /*// Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $userid=finduseridcore($_SESSION['useremail']);
  $emojimood=$_GET['moodval'];
  $sql="INSERT INTO mood_table (Email, Date, Feeling) VALUES ('$userid','2018-11-11','$emojimood')";
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

  //Required configuration files
	//require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	//require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	//require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
*/
echo 'ok it links';
?>
