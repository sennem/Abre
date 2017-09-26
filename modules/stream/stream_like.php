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
	
	$streamUrl=$_REQUEST['url'];
	$streamTitle=$_REQUEST['title'];
	$streamImage=$_REQUEST['image'];
	$streamUrldecoded=base64_decode($streamUrl);
	$streamTitledecoded=addslashes(base64_decode($streamTitle));
	$streamImagedecoded=base64_decode($streamImage);
	
	$portal_root_path=$portal_root.'/';
	$trimmedimageurl = str_replace($portal_root_path, '', $streamImagedecoded);
	
	$userposter=$_SESSION['useremail'];

	if($streamUrldecoded!="" && $streamTitledecoded!="")
	{
		
		//Check to see if like already exists for this user
		$query = "SELECT * FROM streams_comments where url='$streamUrldecoded' and liked='1' and user='".$_SESSION['useremail']."'";
		$dbreturn = databasequery($query);
		$num_rows_like_count = count($dbreturn);
		
		if($num_rows_like_count==0)
		{
			//Insert comment into database
			$sql = "INSERT INTO streams_comments (url, title, image, user, liked) VALUES ('$streamUrldecoded', '$streamTitledecoded', '$trimmedimageurl', '$userposter', '1');";
			$dbreturn = databaseexecute($sql);
		}
		else
		{
			//Remove commment from database
			$sql = "DELETE FROM streams_comments WHERE url='$streamUrldecoded' and liked='1' and user='".$_SESSION['useremail']."'";
			$dbreturn = databaseexecute($sql);
		}

	}
	
	$streamUrldecoded=base64_encode($streamUrldecoded);
	echo $streamUrldecoded;
	
?>