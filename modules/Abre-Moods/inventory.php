
<html>
	<header>
		<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	</header>
</html>


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

	//$con=mysqli_connect("localhost","root","killerm111","abredb");
	$mysqli = new mysqli('localhost', 'root', 'killerm111', 'abredb');
	// Check connection
	//if (mysqli_connect_errno())
  //{
  //	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  //}

	$sql = "SELECT COUNT(*) FROM mood_table";
	$result = mysqli_query($sql);
	$data = mysqli_fetch_assoc($result);
	echo $data;

?>
