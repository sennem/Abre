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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');
	require_once('permissions.php');

	if($pagerestrictions=="")
	{

		//Add the course
		if(isset($_POST["group_name"])){ $group_name=mysqli_real_escape_string($db, $_POST["group_name"]); }else{ $group_name="Untitled Group"; }
		if(isset($_POST["group_id"])){ $group_id=mysqli_real_escape_string($db, $_POST["group_id"]); }else{ $group_id=""; }

		//Find the StaffId of the user
		$StaffId=GetStaffID($_SESSION['useremail']);

		//Add or update the course
		if($group_id=="")
		{
			$stmt = $db->stmt_init();
			$sql = "INSERT INTO students_groups (StaffId, Name) VALUES ('$StaffId', '$group_name');";
			$stmt->prepare($sql);
			$stmt->execute();
			$groupid = $stmt->insert_id;
			$stmt->close();
			$db->close();

			$person = array("groupid"=>$groupid);
			header("Content-Type: application/json");
			echo json_encode($person);
		}
		else
		{
			mysqli_query($db, "UPDATE students_groups set Name='$group_name' where ID='$group_id'") or die (mysqli_error($db));
			$person = array("message"=>"The group has been saved");
			header("Content-Type: application/json");
			echo json_encode($person);
		}

	}

?>
