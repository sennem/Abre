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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');  
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	
	if($_SESSION['usertype']=='staff')
	{	
		$streamUrl=$_POST["streamUrl"];
		$streamUrldecoded=base64_decode($streamUrl);
		$streamComment=$_POST["streamComment"];
		$streamTitleValue=$_POST["streamTitleValue"];
		$streamTitleValue=addslashes($streamTitleValue);
		$streamComment=htmlspecialchars($streamComment, ENT_QUOTES);
		
		$Commentspecial=nl2br(strip_tags(html_entity_decode($streamComment)));
		$Commentspecial=linkify($Commentspecial);
		
		$userposter=$_SESSION['useremail'];
	
		if($streamComment!="" && $streamTitleValue!="")
		{	
			$sql = "INSERT INTO streams_comments (url, title, user, comment) VALUES ('$streamUrldecoded', '$streamTitleValue', '$userposter', '$streamComment');";
			$dbreturn = databaseexecute($sql);
		}
		$streamUrldecoded=base64_encode($streamUrldecoded);
		echo $streamUrldecoded;
	}
	
?>