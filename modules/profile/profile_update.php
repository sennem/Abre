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
	require_once(dirname(__FILE__) . '/../../core/abre_google_login.php');

	//Insert/Update Profile
	include "../../core/abre_dbconnect.php";
	$sql = "SELECT *  FROM profiles WHERE email = '".$_SESSION['useremail']."'";
	$result = $db->query($sql);
	$stack = array();
	$departmentcount = mysqli_real_escape_string($db, $_POST["departmentcount"]);
	if($_SESSION['usertype'] != "student"){
		$card_mail = 0;
		$card_drive = 0;
		$card_calendar = 0;
		$card_classroom = 0;
		$card_apps = 0;
		if(!empty($_POST["card_mail"])){ $card_mail = mysqli_real_escape_string($db, $_POST["card_mail"]); }
		if(!empty($_POST["card_drive"])){ $card_drive = mysqli_real_escape_string($db, $_POST["card_drive"]); }
		if(!empty($_POST["card_calendar"])){ $card_calendar = mysqli_real_escape_string($db, $_POST["card_calendar"]); }
		if(!empty($_POST["card_classroom"])){ $card_classroom = mysqli_real_escape_string($db, $_POST["card_classroom"]); }
		if(!empty($_POST["card_apps"])){ $card_apps = mysqli_real_escape_string($db, $_POST["card_apps"]); }
		if(!empty($_POST["datePick"])){ $datePick = mysqli_real_escape_string($db, $_POST["datePick"]); }
	}else{
		$card_mail = 1;
		$card_drive = 1;
		$card_calendar = 1;
		$card_classroom = 1;
		$card_apps = 1;
	}

	while($row = $result->fetch_assoc()){
		$profileupdatecount = 1;
		for ($x = 0; $x <= $departmentcount; $x++) {
	    	if(!empty($_POST["checkbox_$x"])){ $message = mysqli_real_escape_string($db, $_POST["checkbox_$x"]); }
	    	if(!empty($message)){ array_push($stack, $message); }
		}
		$str = implode (", ", $stack);
		$stmt = $db->stmt_init();
		$sql = "UPDATE profiles SET streams = ?, card_mail = ?, card_drive = ?, card_calendar = ?, card_classroom = ?, card_apps = ? WHERE email = ?";
		$stmt->prepare($sql);
		$stmt->bind_param("siiiiis", $str, $card_mail, $card_drive, $card_calendar, $card_classroom, $card_apps, $_SESSION['useremail']);
		$stmt->execute();
		$stmt->close();
		$db->close();
	}

	if($profileupdatecount == 0){
		for ($x = 0; $x <= $departmentcount; $x++) {
	    	$message = mysqli_real_escape_string($db, $_POST["checkbox_$x"]);
	    	if($message != ""){ array_push($stack, $message); }
		}
		$str = implode (", ", $stack);
		$stmt = $db->stmt_init();
		$sql = "INSERT INTO profiles (email, streams, card_mail, card_drive, card_calendar, card_classroom, card_apps) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$stmt->prepare($sql);
		$stmt->bind_param("ssiiiii", $_SESSION['useremail'], $str, $card_mail, $card_drive, $card_calendar, $card_classroom, $card_apps);
		$stmt->execute();
		$stmt->close();
		$db->close();
	}

?>