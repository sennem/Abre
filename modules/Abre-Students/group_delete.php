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
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');
	require_once('permissions.php');

	if($pagerestrictions=="")
	{

		$group_id=mysqli_real_escape_string($db, $_POST["group_id"]);

		//Find the StaffId of the user
		$StaffId=GetStaffID($_SESSION['useremail']);

		//Delete students added to group
		$stmt = $db->stmt_init();
		$sql = "Delete from students_groups_students where Group_ID='$group_id'";
		$stmt->prepare($sql);
		$stmt->execute();
		$stmt->store_result();
		$stmt->close();

		//Delete group
		$stmt = $db->stmt_init();
		$sql = "Delete from students_groups where id='$group_id' and StaffId='$StaffId' LIMIT 1";
		$stmt->prepare($sql);
		$stmt->execute();
		$stmt->store_result();
		$stmt->close();

		$db->close();
		echo "The group has been deleted.";

	}

?>
