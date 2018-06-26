<?php
  $periodnumberlog=$_GET['periodnumber'];
  $_SESSION['period'] = $periodnumberlog;
  header("Location:http://localhost:8080/#books");
  exit;
?>
