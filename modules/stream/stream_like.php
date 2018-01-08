<?php

	/*
	* Copyright (C) 2016-2017 Abre.io LLC
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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');

	$streamUrl = $_REQUEST['url'];
	$streamTitle = $_REQUEST['title'];
	$streamImage = $_REQUEST['image'];
	$streamUrldecoded = base64_decode($streamUrl);
	$streamQuery = mysqli_real_escape_string($db, $streamUrldecoded);
	$streamTitledecoded = base64_decode($streamTitle);
	$streamImagedecoded = base64_decode($streamImage);

	$portal_root_path = $portal_root.'/';
	$trimmedimageurl = str_replace($portal_root_path, '', $streamImagedecoded);

	$userposter = $_SESSION['useremail'];

	if($streamUrldecoded != "" && $streamTitledecoded != ""){

		//Check to see if like already exists for this user
		$query = "SELECT * FROM streams_comments WHERE url = '$streamQuery' AND liked = '1' AND user = '".$_SESSION['useremail']."'";
		$dbreturn = databasequery($query);
		$num_rows_like_count = count($dbreturn);

		if($num_rows_like_count == 0){
			//Insert comment into database
			$stmt = $db->stmt_init();
			$sql = "INSERT INTO streams_comments (url, title, image, user, liked) VALUES (?, ?, ?, ?, '1');";
			$stmt->prepare($sql);
			$stmt->bind_param("ssss", $streamUrldecoded, $streamTitledecoded, $trimmedimageurl, $userposter);
			$stmt->execute();
			$stmt->close();
			$db->close();
		}else{
			//Remove commment from database
			$stmt = $db->stmt_init();
			$sql = "DELETE FROM streams_comments WHERE url = ? AND liked = '1' AND user = ?";
			$stmt->prepare($sql);
			$stmt->bind_param("ss", $streamUrldecoded, $_SESSION['useremail']);
			$stmt->execute();
			$stmt->close();
			$db->close();
		}
	}

	$streamUrldecoded = base64_encode($streamUrldecoded);
	echo $streamUrldecoded;

?>