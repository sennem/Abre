<?php
  $periodnumberlog=$_GET['periodnumber']; //works
  $_SESSION['periodsession'] = $periodnumberlog;
  header("Location:http://localhost:8080/#books");
?>
