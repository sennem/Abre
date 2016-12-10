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
	
	//Include required files
	require_once('abre_verification.php');
	require_once('abre_functions.php'); 
	
	//Send the feedback email
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
	
?>