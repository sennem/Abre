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

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=Student_Roster_Groups.csv');

		$output = fopen('php://output', 'w');

		fputcsv($output, array('LastName', 'FirstName', 'MiddleName', 'StudentID', 'Gender', 'Ethnicity', 'Birthday', 'Grade', 'IEP', 'Gifted', 'ELL'));
		$rows = mysqli_query($db, "SELECT Abre_Students.LastName, Abre_Students.FirstName, Abre_Students.MiddleName, Abre_Students.StudentId, Abre_Students.Gender, Abre_Students.EthnicityDescription, Abre_Students.DateOfBirth, Abre_Students.CurrentGrade, Abre_Students.IEP, Abre_Students.Gifted, Abre_Students.ELL FROM students_groups_students LEFT JOIN Abre_Students ON students_groups_students.Student_ID=Abre_Students.StudentId WHERE students_groups_students.StaffId='$StaffId' AND Abre_Students.Status!='I' GROUP BY Abre_Students.StudentId ORDER BY Abre_Students.LastName");

		while($row = mysqli_fetch_assoc($rows)){
			$LastName = $row["LastName"];
			$FirstName = $row["FirstName"];
			$MiddleName = $row["MiddleName"];
			$StudentID = $row["StudentId"];
			$Gender = $row["Gender"];
			$Ethnicity = $row["EthnicityDescription"];
			$Birthday = $row["DateOfBirth"];
			$Grade = $row["CurrentGrade"];
			$IEP = $row["IEP"];
			$Gifted = $row["Gifted"];
			$ELL = $row["ELL"];

			$data = [$LastName,$FirstName,$MiddleName,$StudentID,$Gender,$Ethnicity,$Birthday,$Grade,$IEP,$Gifted,$ELL];
			fputcsv($output, $data);
		}
		fclose($output);
		mysqli_close($db);
		exit();

	}

?>