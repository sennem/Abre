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
	require(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');
	require_once('permissions.php');

	if($pagerestrictions=="")
	{
		//Get Variables Passed to Page
		if(isset($_GET["GroupID"])){ $GroupID=htmlspecialchars($_GET["GroupID"], ENT_QUOTES); }else{ $GroupID=""; }
		if(isset($_GET["CourseCode"])){ $CourseCode=htmlspecialchars($_GET["CourseCode"], ENT_QUOTES); }else{ $CourseCode=""; }
		if(isset($_GET["SectionCode"])){ $SectionCode=htmlspecialchars($_GET["SectionCode"], ENT_QUOTES); }else{ $SectionCode=""; }
		if(isset($_GET["CounselingID"])){ $CounselingID=htmlspecialchars($_GET["CounselingID"], ENT_QUOTES); }else{ $CounselingID=""; }
		$StaffId=GetStaffID($_SESSION['useremail']);

		echo "<div class='mdl-shadow--2dp' style='background-color:#fff; padding:20px 40px 40px 40px'>";

			echo "<h5>IEP Students</h5>";

			echo "<table id='table' class='bordered highlight'>";
			echo "<thead><tr><th></th><th>Student</th></tr></thead>";
			echo "<tbody>";

					if($GroupID != ""){
						$lastStudentID = "";
						$query = "SELECT students_groups_students.Student_ID, Abre_Students.FirstName, Abre_Students.LastName FROM students_groups_students LEFT JOIN Abre_Students ON students_groups_students.Student_ID = Abre_Students.StudentId WHERE Abre_Students.IEP = 'Y' AND students_groups_students.StaffId = '$StaffId' AND students_groups_students.Group_ID = '$GroupID' ORDER BY students_groups_students.Student_ID";
						$dbreturn = databasequery($query);
						foreach($dbreturn as $value){
							$StudentId = htmlspecialchars($value["Student_ID"], ENT_QUOTES);
							if($StudentId == $lastStudentID){
								continue;
							}else{
								$FirstName = htmlspecialchars($value["FirstName"], ENT_QUOTES);
								$LastName = htmlspecialchars($value["LastName"], ENT_QUOTES);
								echo "<tr><td style='white-space:nowrap;width:1%'><a class='modal-studentlook' data-studentid='$StudentId' href='#studentlook' style='color:#000;'><i class='material-icons'>remove_red_eye</i></a></td><td style='padding-left:0;'>$FirstName $LastName</td></tr>";
								$lastStudentID = $StudentId;
							}
						}
					}
					if($CourseCode != ""){
						$lastStudentID = "";
						$query = "SELECT Abre_StudentSchedules.StudentID, Abre_Students.FirstName, Abre_Students.LastName FROM Abre_StudentSchedules LEFT JOIN Abre_Students ON Abre_StudentSchedules.StudentID = Abre_Students.StudentId WHERE Abre_StudentSchedules.CourseCode = '$CourseCode' AND Abre_StudentSchedules.SectionCode = '$SectionCode' AND Abre_StudentSchedules.StaffId = '$StaffId' AND Abre_Students.IEP = 'Y' ORDER BY Abre_StudentSchedules.StudentID";
						$dbreturn = databasequery($query);
						foreach($dbreturn as $value){
							$StudentId = htmlspecialchars($value["StudentID"], ENT_QUOTES);
							if($StudentId == $lastStudentID){
								continue;
							}else{
								$FirstName = htmlspecialchars($value["FirstName"], ENT_QUOTES);
								$LastName = htmlspecialchars($value["LastName"], ENT_QUOTES);
								echo "<tr><td style='white-space:nowrap;width:1%'><a class='modal-studentlook' data-studentid='$StudentId' href='#studentlook' style='color:#000;'><i class='material-icons'>remove_red_eye</i></a></td><td style='padding-left:0;'>$FirstName $LastName</td></tr>";
								$lastStudentID = $StudentId;
							}
						}
					}
					if($CounselingID != ""){
						$lastStudentID = "";
						$query = "SELECT Abre_Student_Counselors.StudentId, Abre_Students.FirstName, Abre_Students.LastName FROM Abre_Student_Counselors LEFT JOIN Abre_Students ON Abre_Student_Counselors.StudentId = Abre_Students.StudentId WHERE Abre_Student_Counselors.CounselorStaffId = '$StaffId' AND Abre_Students.IEP = 'Y' ORDER BY Abre_Student_Counselors.StudentId";
						$dbreturn = databasequery($query);
						foreach($dbreturn as $value){
							$StudentId = htmlspecialchars($value["StudentId"], ENT_QUOTES);
							if($studentId == $lastStudentID){
								continue;
							}else{
								$FirstName = htmlspecialchars($value["FirstName"], ENT_QUOTES);
								$LastName = htmlspecialchars($value["LastName"], ENT_QUOTES);
								echo "<tr><td style='white-space:nowrap;width:1%'><a class='modal-studentlook' data-studentid='$StudentId' href='#studentlook' style='color:#000;'><i class='material-icons'>remove_red_eye</i></a></td><td style='padding-left:0;'>$FirstName $LastName</td></tr>";
								$lastStudentID = $StudentId;
							}
						}
					}

				echo "</tbody>";
			echo "</table>";
		echo "</div>";

	}

?>

<script>

	$(function()
	{
	    $("#table").tablesorter({ sortList: [[0,0]] });
	});

</script>
