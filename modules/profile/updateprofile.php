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
	
	//Configuration
	require(dirname(__FILE__) . '/../../configuration.php'); 
	
	//Login Validation
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 

	require_once(dirname(__FILE__) . '/../../core/abre_google_login.php');
	
	//Insert/Update Profile
	include "../../core/abre_dbconnect.php";
	$sql = "SELECT *  FROM profiles where email='".$_SESSION['useremail']."'";
	$result = $db->query($sql);
	$profileupdatecount=0;
	$stack = array();
	$departmentcount=mysqli_real_escape_string($db, $_POST["departmentcount"]);
	if($_SESSION['usertype']!="student")
	{
		$card_mail=0;
		$card_drive=0;
		$card_calendar=0;
		$card_classroom=0;
		if (!empty($_POST["card_mail"])){ $card_mail=mysqli_real_escape_string($db, $_POST["card_mail"]); }
		if (!empty($_POST["card_drive"])){ $card_drive=mysqli_real_escape_string($db, $_POST["card_drive"]); }
		if (!empty($_POST["card_calendar"])){ $card_calendar=mysqli_real_escape_string($db, $_POST["card_calendar"]); }
		if (!empty($_POST["card_classroom"])){ $card_classroom=mysqli_real_escape_string($db, $_POST["card_classroom"]); }
	}
	else
	{
		$card_mail=1;
		$card_drive=1;
		$card_calendar=1;
		$card_classroom=1;
	}
	while($row = $result->fetch_assoc())
	{
		$profileupdatecount=1;
		for ($x = 0; $x <= $departmentcount; $x++) {
	    	if (!empty($_POST["checkbox_$x"])){ $message=mysqli_real_escape_string($db, $_POST["checkbox_$x"]); }
	    	if(!empty($message)){ array_push($stack, $message); }
		}
		$str = implode (", ", $stack);
		$stmt = $db->stmt_init();
		$sql = "UPDATE profiles set streams='$str', card_mail='$card_mail', card_drive='$card_drive', card_calendar='$card_calendar', card_classroom='$card_classroom' where email='".$_SESSION['useremail']."'";
		$stmt->prepare($sql);
		$stmt->execute();
		$stmt->store_result();
		$num_rows = $stmt->num_rows;
		$stmt->close();
		$db->close();	

	}
	
	if ($profileupdatecount==0)
	{
		for ($x = 0; $x <= $departmentcount; $x++) {
	    	$message=mysqli_real_escape_string($db, $_POST["checkbox_$x"]);
	    	if($message!=""){ array_push($stack, $message); }
		}
		$str = implode (", ", $stack);
		$stmt = $db->stmt_init();
		$sql = "Insert into profiles (id, email, streams, card_mail, card_drive, card_calendar, card_classroom) VALUES (NULL, '".$_SESSION['useremail']."', '$str', '$card_mail', '$card_drive', '$card_calendar', '$card_classroom')";
		$stmt->prepare($sql);
		$stmt->execute();
		$stmt->store_result();
		$num_rows = $stmt->num_rows;
		$stmt->close();
		$db->close();		
	}

?>