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
	
	//Include required files
	require_once('abre_verification.php');
	require_once('abre_functions.php'); 
	
	//Send the feedback email
	if($_SESSION['usertype']=="staff")
	{
		$textarea=$_POST["textarea"];
		if($textarea!="")
		{
			$to=sitesettings("siteadminemail");
			$subject = "Abre Feedback";
			$message = "From: ".$_SESSION['useremail']."\r\n\r\n".$_SESSION['displayName']."\r\n\r\n$textarea";
			$headers = "From: ". $_SESSION['useremail'];
			mail($to,$subject,$message,$headers);
			echo "Your feedback has been sent!";
		}
		else
		{
			echo "Whoops, you didn't enter any feedback.";
		}
	}
	
?>