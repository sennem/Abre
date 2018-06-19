<?php

	/*
	* Copyright (C) 2016-2018 Abre.io Inc.
	*
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the Affero General Public License version 3
    * as published by the Free Software Foundation.
	*
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU Affero General Public License for more details.
	*
    * You should have received a copy of the Affero General Public License
    * version 3 along with this program.  If not, see https://www.gnu.org/licenses/agpl-3.0.en.html.
    */

	//Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../configuration.php');
	//require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('permissions.php');

  //$stmt = $db->stmt_init();
	//$stmt->prepare($sql);
	//$stmt->execute();
	//$stmt->close();
	//$db->close()

	$con=mysqli_connect("localhost","root","killerm111","abredb");
	// Check connection
	if (mysqli_connect_errno())
  {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
	$sql = "SELECT COUNT(*) FROM mood_table";
	$result = mysqli_query($con,$sql);
	$rows = mysqli_fetch_row($result);
	echo $rows[0];

	$sql = "SELECT Feeling FROM mood_table WHERE Email=\'marksenne000@gmail.com\'";
	$result = mysqli_query($con, $sql);
	$countervar=0;
	while($row = mysqli_fetch_array($result, MYSQLI_NUM))
	{
	    echo ($row[$countervar]);  // The number
	    echo ($row[$countervar]);  // The customer
			$countervar++;
	}
	//$result2 = mysqli_query($con, $sql2);
	//echo $result2[0];
	$con->close();

echo('reach');
	//$con=mysqli_connect("localhost","root","killerm111","abredb");
	// Check connection
	//if (mysqli_connect_errno())
  //{
  //	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  //}
	//$sql = "SELECT Feeling FROM mood_table WHERE Email='marksenne000@gmail.com'";
	//$result = mysqli_query($con,$sql);
	//echo $result;
	//$con->close();

	//echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>Mood History</span><br><p style='font-size:16px; margin:20px 0 0 0;'>View your modd history here.</p></div>";
	//this if keeps me displaying. (it doesnt pass the if test)
	//if($pagerestrictions=="")
	//{
	//	echo "<div id='displaybooks'>"; include "inventory_display.php"; echo "</div>";
	//}

?>
