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

	$librarycourseid=mysqli_real_escape_string($db, $_GET["librarycourseid"]);

	//Delete Course from libraries
	$stmt = $db->stmt_init();
	$sql = "Delete from curriculum_libraries where Course_ID='$librarycourseid'";
	$stmt->prepare($sql);
	$stmt->execute();
	$stmt->store_result();
	$num_rows = $stmt->num_rows;
	$stmt->close();

	//Delete course
	$stmt = $db->stmt_init();
	$sql = "Delete from curriculum_course where id='$librarycourseid' LIMIT 1";
	$stmt->prepare($sql);
	$stmt->execute();
	$stmt->store_result();
	$num_rows = $stmt->num_rows;
	$stmt->close();

	//Delete resources for topics
	$sqllookup2 = "SELECT ID FROM curriculum_unit WHERE Course_ID='$librarycourseid'";
	$result3 = $db->query($sqllookup2);
	$unitcount=mysqli_num_rows($result3);
	while($row2 = $result3->fetch_assoc())
	{
		if (!empty($row2["ID"])){ $Unit_ID=stripslashes($row2["ID"]); }
		$stmt = $db->stmt_init();
		$sql = "Delete from curriculum_resources where TopicID='$Unit_ID'";
		$stmt->prepare($sql);
		$stmt->execute();
	}

	//Delete topics in course
	$stmt = $db->stmt_init();
	$sql = "Delete from curriculum_unit where Course_ID='$librarycourseid'";
	$stmt->prepare($sql);
	$stmt->execute();
	$stmt->store_result();
	$num_rows = $stmt->num_rows;
	$stmt->close();

	$db->close();
	echo "The course has been deleted.";

?>