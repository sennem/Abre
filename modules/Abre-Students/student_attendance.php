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

		$query = "SELECT AbsenceDate, AbsenceCategoryCode, AbsenceReasonDescription FROM Abre_Attendance WHERE StudentID = '$Student_ID'";
		$dbreturn = databasequery($query);
		$totalabsences = count($dbreturn);
		$count = 0;
		foreach ($dbreturn as $value)
		{

			$count++;
			if($count==1)
			{
				//Display Attendance
				echo "<h4>Attendance Records</h4>";
				echo "<p style='font-size: 14px !important; font-weight:500;'>Total Absences: $totalabsences</p>";
				echo "<table id='table' class='tablesorter bordered highlight'>";
				echo "<thead><tr class='pointer'><th width='200px'>Date</th><th>Type</th><th>Reason</th></tr></thead><tbody>";
			}

			$AbsenceDate=htmlspecialchars($value["AbsenceDate"], ENT_QUOTES);

			$AbsenceDescription = htmlspecialchars($value["AbsenceReasonDescription"], ENT_QUOTES);

			$AbsenceCategoryCode=htmlspecialchars($value["AbsenceCategoryCode"], ENT_QUOTES);
			if($AbsenceCategoryCode=="A"){ $AbsenceCategoryCode="Excused Absence"; }
			if($AbsenceCategoryCode=="E"){ $AbsenceCategoryCode="Early Dismissal"; }
			if($AbsenceCategoryCode=="P"){ $AbsenceCategoryCode="HASP Placement"; }
			if($AbsenceCategoryCode=="H"){ $AbsenceCategoryCode="Hospital"; }
			if($AbsenceCategoryCode=="I"){ $AbsenceCategoryCode="In School Suspension"; }
			if($AbsenceCategoryCode=="J"){ $AbsenceCategoryCode="Juvenile Detention Center"; }
			if($AbsenceCategoryCode=="N"){ $AbsenceCategoryCode="Not an Absence from School"; }
			if($AbsenceCategoryCode=="NOS"){ $AbsenceCategoryCode="Non Absence Out of School Suspension - Ct Week Only"; }
			if($AbsenceCategoryCode=="S"){ $AbsenceCategoryCode="Out of School Suspension"; }
			if($AbsenceCategoryCode=="PREV"){ $AbsenceCategoryCode="Attendance from Previous School Building"; }
			if($AbsenceCategoryCode=="T"){ $AbsenceCategoryCode="Tardy"; }
			if($AbsenceCategoryCode=="HOPE"){ $AbsenceCategoryCode="Unexcused Absence for Not Completing 3 Hrs of Work at Home"; }
			if($AbsenceCategoryCode=="U"){ $AbsenceCategoryCode="Unexcused Absence"; }
			if($AbsenceCategoryCode=="Z"){ $AbsenceCategoryCode="Unexcused Tardy"; }

			echo "<tr><td>$AbsenceDate</td><td>$AbsenceCategoryCode</td><td>$AbsenceDescription</td></tr>";

			if($count==$totalabsences)
			{
				echo "</tbody></table>";
			}

		}

		if($totalabsences==0){ echo "<div class='row center-align'><div class='col s12'><h6>No attendance records found</h6></div></div>"; }

	}

?>

<script>

	$(function()
	{
	    $("#table").tablesorter({
		    sortList: [[0,1]]
	    });
	});

</script>
