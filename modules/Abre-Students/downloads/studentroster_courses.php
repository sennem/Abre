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
	require(dirname(__FILE__) . '/../../../configuration.php');
	require_once(dirname(__FILE__) . '/../../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../../core/abre_dbconnect.php');
	require(dirname(__FILE__) . '/../../../core/abre_functions.php');
	require_once('../functions.php');
	require_once('../permissions.php');

	if($pagerestrictions == ""){

		$StaffId = GetStaffID($_SESSION['useremail']);
		$CurrentSememester = GetCurrentSemester();

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=Student_Roster_Courses.csv');

		$output = fopen('php://output', 'w');

		fputcsv($output, array('LastName', 'FirstName', 'MiddleName', 'StudentID', 'CourseName', 'Term', 'Period', 'Gender', 'Ethnicity', 'Birthday', 'Grade', 'IEP', 'Gifted', 'ELL'));
		$rows = mysqli_query($db, "SELECT Abre_Students.LastName, Abre_Students.FirstName, Abre_Students.MiddleName, Abre_StudentSchedules.StudentID, Abre_StudentSchedules.CourseName, Abre_StudentSchedules.CourseName, Abre_StudentSchedules.TermCode, Abre_StudentSchedules.Period, Abre_Students.Gender, Abre_Students.EthnicityDescription, Abre_Students.DateOfBirth, Abre_Students.CurrentGrade, Abre_StudentSchedules.StudentIEPStatus, Abre_StudentSchedules.StudentGiftedStatus, Abre_StudentSchedules.StudentELLStatus FROM Abre_StudentSchedules LEFT JOIN Abre_Students ON Abre_StudentSchedules.StudentID=Abre_Students.StudentId WHERE Abre_StudentSchedules.StaffId='$StaffId' AND Abre_Students.Status!='I' AND (Abre_StudentSchedules.TermCode='$CurrentSememester' OR Abre_StudentSchedules.TermCode='Year') GROUP BY Abre_StudentSchedules.StudentID ORDER BY Abre_Students.LastName");

		while($row = mysqli_fetch_assoc($rows)){
			$LastName = $row["LastName"];
			$FirstName = $row["FirstName"];
			$MiddleName = $row["MiddleName"];
			$StudentID = $row["StudentID"];
			$CourseName = $row["CourseName"];
			$Term = $row["TermCode"];
			$Period = $row["Period"];
			$Gender = $row["Gender"];
			$Ethnicity = $row["EthnicityDescription"];
			$Birthday = $row["DateOfBirth"];
			$Grade = $row["CurrentGrade"];
			$StudentIEPStatus = $row["StudentIEPStatus"];
			$StudentGiftedStatus = $row["StudentGiftedStatus"];
			$StudentELLStatus = $row["StudentELLStatus"];

			$data = [$LastName,$FirstName,$MiddleName,$StudentID,$CourseName,$Term,$Period,$Gender,$Ethnicity,$Birthday,$Grade,$StudentIEPStatus,$StudentGiftedStatus,$StudentELLStatus];
			fputcsv($output, $data);
		}
		fclose($output);
		mysqli_close($db);
		exit();

	}

?>