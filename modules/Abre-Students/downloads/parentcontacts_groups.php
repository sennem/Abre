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
		header('Content-Disposition: attachment; filename=Parent_Contacts_Groups.csv');

		$output = fopen('php://output', 'w');

		fputcsv($output, array('LastName', 'FirstName', 'StudentID', 'ParentFirstName', 'ParentLastName', 'ParentAddress', 'ParentCity', 'ParentState', 'ParentZip', 'ParentPhone1', 'ParentPhone2', 'ParentEmail'));
		$rows = mysqli_query($db, "SELECT Abre_ParentContacts.StudentID, Abre_ParentContacts.FirstName, Abre_ParentContacts.LastName, Abre_ParentContacts.AddressLine1, Abre_ParentContacts.City, Abre_ParentContacts.State, Abre_ParentContacts.Zip, Abre_ParentContacts.Phone1, Abre_ParentContacts.Phone2, Abre_ParentContacts.Email1 FROM students_groups_students LEFT JOIN Abre_ParentContacts ON students_groups_students.Student_ID=Abre_ParentContacts.StudentID WHERE students_groups_students.StaffId='$StaffId' GROUP BY students_groups_students.Student_ID ORDER BY Abre_ParentContacts.LastName");

		while ($row = mysqli_fetch_assoc($rows)) {
			$StudentID=$row["StudentID"];
			$ParentFirstName=$row["FirstName"];
			$ParentLastName=$row["LastName"];
			$ParentAddress=$row["AddressLine1"];
			$ParentCity=$row["City"];
			$ParentState=$row["State"];
			$ParentZip=$row["Zip"];
			$ParentPhone1=$row["Phone1"];
			$ParentPhone2=$row["Phone2"];
			$ParentEmail=$row["Email1"];

			//Find Students Name
			$query = "SELECT FirstName, LastName FROM Abre_Students WHERE StudentId='$StudentID' LIMIT 1";
			$dbreturn = databasequery($query);
			$LastName=NULL;
			$FirstName=NULL;
			foreach ($dbreturn as $value)
			{
				$FirstName=$value['FirstName'];
				$LastName=$value['LastName'];
			}

			$data = [$LastName,$FirstName,$StudentID,$ParentFirstName,$ParentLastName,$ParentAddress,$ParentCity,$ParentState,$ParentZip,$ParentPhone1,$ParentPhone2,$ParentEmail];
			fputcsv($output, $data);
		}
		fclose($output);
		mysqli_close($db);
		exit();

	}

?>