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
	require_once('permissions.php');

	if($pagerestrictions=="")
	{

		$Course_ID=htmlspecialchars($_GET["course"], ENT_QUOTES);
		$Lesson_ID=htmlspecialchars($_GET["lesson"], ENT_QUOTES);

		//Get Course Information
		include "../../core/abre_dbconnect.php";

		$sqllogin = "SELECT Title, Grade FROM curriculum_course WHERE ID='$Course_ID'";
		$resultlogin = $db->query($sqllogin);
		while($rowlogin = $resultlogin->fetch_assoc())
		{
			$Course_Title=htmlspecialchars($rowlogin["Title"], ENT_QUOTES);
			$Course_Grade=htmlspecialchars($rowlogin["Grade"], ENT_QUOTES);
		}

		$sqllookup = "SELECT Title FROM curriculum_lesson WHERE ID='$Lesson_ID'";
		$result2 = $db->query($sqllookup);
		while($row = $result2->fetch_assoc())
		{
			$Title=htmlspecialchars($row["Title"], ENT_QUOTES);
		}

		echo "<div class='col s12' style='padding:0 30px 30px 30px;'>";
			echo "<h4 class='center-align'>$Title</h4>";
			echo "<h6 class='center-align'>$Course_Title, Grade Level: $Course_Grade</h6>";
		echo "</div>";
	}

?>