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
	require_once('functions.php');
	require_once('permissions.php');

	if($pagerestrictions == "" || $isParent)
	{

		$CurrentSemester=GetCurrentSemester();

		$query = "SELECT CourseName, TeacherName, Period, RoomNumber FROM Abre_StudentSchedules WHERE StudentID='$Student_ID' AND (TermCode='$CurrentSemester' OR TermCode='Year')";
		$dbreturn = databasequery($query);
		$totalcount = count($dbreturn);
		$count=0;
		foreach ($dbreturn as $value)
		{
			$count++;
			if($count==1)
			{
				//Display Attendance
				echo "<h4>Current Schedule</h4>";
				echo "<table id='tableschedule' class='tablesorter bordered'>";
				echo "<thead><tr class='pointer'><th>Period</th><th>Course</th><th>Room</th><th>Teacher</th></tr></thead><tbody>";
			}

			$CourseName=htmlspecialchars($value["CourseName"], ENT_QUOTES);
			$TeacherName=htmlspecialchars($value["TeacherName"], ENT_QUOTES);
			$Period=htmlspecialchars($value["Period"], ENT_QUOTES);
			$RoomNumber=htmlspecialchars($value["RoomNumber"], ENT_QUOTES);

			echo "<tr><td>$Period</td><td>$CourseName</td><td>$RoomNumber</td><td>$TeacherName</td></tr>";

			if($count==$totalcount)
			{
				echo "</tbody></table>";
			}
		}

		if($totalcount==0){ echo "<div class='row center-align'><div class='col s12'><h6>No schedule found</h6></div></div>"; }

	}

?>

<script>
	$(function()
	{
	    $("#tableschedule").tablesorter({
			sortList: [[0,0]]
	    });
	});
</script>