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

	if($pagerestrictions=="")
	{

		$StaffId=GetStaffID($_SESSION['useremail']);
		$CurrentSememester=GetCurrentSemester();

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=Parent_Contacts_Courses.csv');

		$output = fopen('php://output', 'w');

		fputcsv($output, array('LastName', 'FirstName', 'StudentID', 'CourseName', 'Term', 'Period', 'ParentFirstName', 'ParentLastName', 'ParentAddress', 'ParentCity', 'ParentState', 'ParentZip', 'ParentPhone1', 'ParentPhone2', 'ParentEmail'));
		$rows = mysqli_query($db, "SELECT Abre_StudentSchedules.LastName as StudentLastName, Abre_StudentSchedules.FirstName as StudentFirstName, Abre_StudentSchedules.StudentID as StudentStudentID, Abre_StudentSchedules.CourseName as StudentCourseName, Abre_StudentSchedules.TermCode as StudentTerm, Abre_StudentSchedules.Period as StudentPeriod, Abre_ParentContacts.FirstName as ParentFirstName, Abre_ParentContacts.LastName as ParentLastName, Abre_ParentContacts.AddressLine1 as ParentAddressLine1, Abre_ParentContacts.City as ParentCity, Abre_ParentContacts.State as ParentState, Abre_ParentContacts.Zip as ParentZip, Abre_ParentContacts.Phone1 as ParentPhone1, Abre_ParentContacts.Phone2 as ParentPhone2, Abre_ParentContacts.Email1 as ParentEmail1 FROM Abre_StudentSchedules LEFT JOIN Abre_ParentContacts ON Abre_StudentSchedules.StudentID=Abre_ParentContacts.StudentID WHERE Abre_StudentSchedules.StaffId='$StaffId' AND (Abre_StudentSchedules.TermCode='$CurrentSememester' OR Abre_StudentSchedules.TermCode='Year') GROUP BY Abre_StudentSchedules.StudentID ORDER BY Abre_StudentSchedules.LastName");

		while ($row = mysqli_fetch_assoc($rows)) {
			$LastName=$row["StudentLastName"];
			$FirstName=$row["StudentFirstName"];
			$StudentID=$row["StudentStudentID"];
			$CourseName=$row["StudentCourseName"];
			$Term=$row["StudentTerm"];
			$Period=$row["StudentPeriod"];
			$ParentFirstName=$row["ParentFirstName"];
			$ParentLastName=$row["ParentLastName"];
			$ParentAddress=$row["ParentAddressLine1"];
			$ParentCity=$row["ParentCity"];
			$ParentState=$row["ParentState"];
			$ParentZip=$row["ParentZip"];
			$ParentPhone1=$row["ParentPhone1"];
			$ParentPhone2=$row["ParentPhone2"];
			$ParentEmail=$row["ParentEmail1"];

			$data = [$LastName,$FirstName,$StudentID,$CourseName,$Term,$Period,$ParentFirstName,$ParentLastName,$ParentAddress,$ParentCity,$ParentState,$ParentZip,$ParentPhone1,$ParentPhone2,$ParentEmail];
			fputcsv($output, $data);
		}
		fclose($output);
		mysqli_close($db);
		exit();

	}

?>