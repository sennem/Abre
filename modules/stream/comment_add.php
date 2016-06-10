<?php
	
	/*
	* Copyright 2015 Hamilton City School District	
	* 		
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	* 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	* 
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */
	
	//Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');  
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	
	$streamUrl=$_POST["streamUrl"];
	$streamUrldecoded=base64_decode($streamUrl);
	$streamComment=$_POST["streamComment"];
	$streamTitleValue=$_POST["streamTitleValue"];
	$streamTitleValue=mysql_real_escape_string($streamTitleValue);
	$streamComment=htmlspecialchars($streamComment, ENT_QUOTES);
	
	$Commentspecial=nl2br(strip_tags(html_entity_decode($streamComment)));
	$Commentspecial=linkify($Commentspecial);
	
	$userposter=$_SESSION['useremail'];

	if($streamComment!="" && $streamTitleValue!="")
	{
		
		//Insert comment into database
		$sql = "INSERT INTO streams_comments (url, title, user, comment) VALUES ('$streamUrldecoded', '$streamTitleValue', '$userposter', '$streamComment');";
		$dbreturn = databaseexecute($sql);

	}
	$streamUrldecoded=base64_encode($streamUrldecoded);
	echo $streamUrldecoded;
	
?>