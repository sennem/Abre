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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');

	$StaffId = GetStaffID($_SESSION['useremail']);
	$CurrentSememester = GetCurrentSemester();

	echo "<div class='page_container page_container_limit'>";
		echo "<div class='row'>";
			echo "<div class='col s12'><h5>Your Classes</h5></div>";

				//Get users courses
				$query = "SELECT CourseCode, SchoolCode, SectionCode, CourseName, Period FROM Abre_StaffSchedules WHERE StaffID = '$StaffId' AND (TermCode = '$CurrentSememester' OR TermCode = 'Year') ORDER BY Period";
				$dbreturn = databasequery($query);
				$totalcourses = count($dbreturn);
				$counter = 0;
				foreach ($dbreturn as $value){
					$counter++;
					$CourseCode = $value['CourseCode'];
					$SchoolCode = $value['SchoolCode'];
					$SectionCode = $value['SectionCode'];
					$CourseName = $value['CourseName'];
					$Period = $value['Period'];
					echo DisplayCard('sample.png', $CourseName, $CourseCode, $SectionCode);
				}
				if($totalcourses == 0){ echo "<div class='col s12'>You do not have any classes.</div>"; }

		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col s12'><h5>Your Groups</h5></div>";

				//Get users groups
				$query = "SELECT Name, ID FROM students_groups WHERE StaffId = '$StaffId'";
				$dbreturn = databasequery($query);
				$resultscounter = count($dbreturn);
				$counter = 0;
				foreach ($dbreturn as $value){
					$counter++;
					$GroupName = $value['Name'];
					$GroupName_Encoded = base64_encode($GroupName);
					$GroupID = $value['ID'];
					echo DisplayCard('sample.png', $GroupName, $GroupID,'');
				}
				if($resultscounter == 0){ echo "<div class='col s12'>You have not created any groups.</div>"; }

		echo "</div>";
	echo "</div>";
?>

<script>

	$(function(){
		$(".link").unbind().click(function(){
		    if($(this).find("a").length){
		        window.location.href = $(this).find("a:first").attr("href");
		    }
		});
	});

</script>