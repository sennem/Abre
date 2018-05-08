<?php

	/*
	* Copyright 2015 Hamilton City School District
	*
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	*
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	*
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */

	//Required configuration files
	require(dirname(__FILE__) . '/../../../configuration.php');
	require_once(dirname(__FILE__) . '/../../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../../core/abre_functions.php');
	require_once('../functions.php');

	if(admin() or conductAdminCheck($_SESSION['useremail']) or conductMonitor($_SESSION['useremail'])){


		$query_encoded = $_GET["query"];
		$query = $query_encoded;

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=Conduct_Report.csv');

		$output = fopen('php://output', 'w');

		fputcsv($output, array('Submission Time', 'Incident Date', 'Incident Time', 'Submitter', 'Submitter Email', 'Building', 'Student ID', 'Student First Name', 'Student Middle Name', 'First Last Name', 'IEP Status', 'Offense', 'Offense Codes', 'Location', 'Consequence', 'Serve Date', 'Thru Date', "Total Days"));
		include "../../../core/abre_dbconnect.php";


		$rows = mysqli_query($db, $query);

		while($row = mysqli_fetch_assoc($rows)){
			$Submission_Time = htmlspecialchars($row["Submission_Time"], ENT_QUOTES);
			$Incident_Date = htmlspecialchars($row["Incident_Date"], ENT_QUOTES);
			$Incident_Time = htmlspecialchars($row["Incident_Time"], ENT_QUOTES);
			$Owner = htmlspecialchars($row["Owner"], ENT_QUOTES);
			$Owner_Name = $row["Owner_Name"];
			$Building = $row["Building"];
			$StudentID = htmlspecialchars($row["StudentID"], ENT_QUOTES);
			$Student_IEP = htmlspecialchars($row["Student_IEP"], ENT_QUOTES);
			$Student_FirstName = $row["Student_FirstName"];
			$Student_MiddleName = $row["Student_MiddleName"];
			$Student_LastName = $row["Student_LastName"];
			$Offence = htmlspecialchars($row["Offence"], ENT_QUOTES);
			$Offence_Display = str_replace(array("'", "\"", "&quot;"), "", $Offence);
			$Offence_Codes = htmlspecialchars($row["Offence_Codes"], ENT_QUOTES);
			$Location = htmlspecialchars($row["Location"], ENT_QUOTES);
			$Description = htmlspecialchars($row["Description"], ENT_QUOTES);
			$Information = htmlspecialchars($row["Information"], ENT_QUOTES);
			$Consequence = htmlspecialchars($row["Consequence_Name"], ENT_QUOTES);
			$Serve_Date = htmlspecialchars($row["Serve_Date"], ENT_QUOTES);
			$Thru_Date = htmlspecialchars($row["Thru_Date"], ENT_QUOTES);
			$Total_Days = htmlspecialchars($row["Total_Days"], ENT_QUOTES);
			$data = [$Submission_Time, $Incident_Date, $Incident_Time, $Owner_Name, $Owner, $Building, $StudentID, $Student_FirstName, $Student_MiddleName, $Student_LastName, $Student_IEP, $Offence_Display, $Offence_Codes, $Location, $Consequence, $Serve_Date, $Thru_Date, $Total_Days];
			fputcsv($output, $data);
		}

		fclose($output);
		mysqli_close($db);
		exit();
	}
?>