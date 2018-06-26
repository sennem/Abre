<?php
  $periodnumberlog=$_GET['periodnumber']; //works
  echo $periodnumberlog;
  header("Location:http://localhost:8080/#books/?periodurl=".$periodnumberlog);
  echo '---';
?>
