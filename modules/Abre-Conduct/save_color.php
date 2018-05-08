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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');
	require_once('permissions.php');

	if($pagerestrictions == ""){

		//Get Post Data
		$Student_ID = mysqli_real_escape_string($db, $_POST["Student_ID"]);
		$Color = mysqli_real_escape_string($db, $_POST["Color"]);
		$CourseGroup = mysqli_real_escape_string($db, $_POST["CourseGroup"]);
		$Section = mysqli_real_escape_string($db, $_POST["Section"]);
		$StaffID = GetStaffID($_SESSION['useremail']);

		$sql = "SELECT COUNT(*) FROM conduct_colors WHERE StudentID = '$Student_ID' AND CourseGroup = '$CourseGroup'";
		$result = $db->query($sql);
		$resultrow = $result->fetch_assoc();
		$numrows = $resultrow["COUNT(*)"];
		if($numrows == 0){
			$stmt = $db->stmt_init();
			$sql = "INSERT INTO conduct_colors (StudentID, Color, CourseGroup, Section, StaffID) VALUES ('$Student_ID', '$Color', '$CourseGroup', '$Section', '$StaffID');";
			$stmt->prepare($sql);
			$stmt->execute();
			$stmt->close();
			$db->close();
		}else{
			mysqli_query($db, "UPDATE conduct_colors SET Color = '$Color' WHERE StudentID = '$Student_ID' AND CourseGroup = '$CourseGroup' AND Section = '$Section' AND StaffID = '$StaffID'") or die (mysqli_error($db));
		}
	}
?>