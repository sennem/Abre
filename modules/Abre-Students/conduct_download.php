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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');

	if($pagerestrictions=="")
	{

		$Student_ID=$_GET["StudentID"];

		$query = "SELECT conduct_discipline.Submission_Time, conduct_discipline.Incident_Date, conduct_discipline.Incident_Time, conduct_discipline.Owner, conduct_discipline.Owner_Name, conduct_discipline.Building, conduct_discipline.StudentID, conduct_discipline.Student_IEP, conduct_discipline.Student_FirstName, conduct_discipline.Student_MiddleName, conduct_discipline.Student_LastName, conduct_discipline.Offence, conduct_discipline.Offence_Codes, conduct_discipline.Location, conduct_discipline.Description, conduct_discipline.Information, conduct_discipline_consequences.Consequence_Name, conduct_discipline_consequences.Serve_Date, conduct_discipline_consequences.Thru_Date, conduct_discipline_consequences.Total_Days, conduct_discipline_consequences.Consequence_Served FROM conduct_discipline LEFT JOIN conduct_discipline_consequences ON conduct_discipline.ID = conduct_discipline_consequences.Incident_ID WHERE conduct_discipline.StudentID='$Student_ID' AND conduct_discipline.Type='Office' AND conduct_discipline.Archived!='1' ORDER BY conduct_discipline.Submission_Time DESC";

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=Personal_Conduct_Report.csv');

		$output = fopen('php://output', 'w');

		fputcsv($output, array('Submission Time', 'Incident Date', 'Incident Time', 'Submitter', 'Submitter Email', 'Building', 'Student ID', 'Student First Name', 'Student Middle Name', 'Student Last Name', 'IEP Status', 'Offense', 'Offense Codes', 'Location', 'Description (Facts and Details Viewable by Parents)', 'Information (Not Viewable by Parents)', 'Consequence', 'Serve Date', 'Thru Date', 'Total Days', 'Consequence Served'));
		include "../../core/abre_dbconnect.php";


		$rows = mysqli_query($db, $query);

		while ($row = mysqli_fetch_assoc($rows))
		{
			$Submission_Time=htmlspecialchars($row["Submission_Time"], ENT_QUOTES);
			$Incident_Date=htmlspecialchars($row["Incident_Date"], ENT_QUOTES);
			$Incident_Time=htmlspecialchars($row["Incident_Time"], ENT_QUOTES);
			$Owner=htmlspecialchars($row["Owner"], ENT_QUOTES);
			$Owner_Name= $row["Owner_Name"];
			$Building= $row["Building"];
			$StudentID=htmlspecialchars($row["StudentID"], ENT_QUOTES);
			$Student_IEP=htmlspecialchars($row["Student_IEP"], ENT_QUOTES);
			$Student_FirstName= $row["Student_FirstName"];
			$Student_MiddleName = $row["Student_MiddleName"];
			$Student_LastName= $row["Student_LastName"];
			$Offence=htmlspecialchars($row["Offence"], ENT_QUOTES);
			$Offence_Display = str_replace(array("'", "\"", "&quot;"), "", $Offence);
			$Offence_Codes=htmlspecialchars($row["Offence_Codes"], ENT_QUOTES);
			$Location=htmlspecialchars($row["Location"], ENT_QUOTES);
			$Description=htmlspecialchars($row["Description"], ENT_QUOTES);
			$Information=htmlspecialchars($row["Information"], ENT_QUOTES);
			$Consequence=htmlspecialchars($row["Consequence_Name"], ENT_QUOTES);
			if($Consequence == ""){
				$Serve_Date = "";
				$Thru_Date = "";
				$Total_Days = "";
				$Consequence_Served = "";
			}else{
				$Serve_Date=htmlspecialchars($row["Serve_Date"], ENT_QUOTES);
				$Thru_Date=htmlspecialchars($row["Thru_Date"], ENT_QUOTES);
				$Total_Days=htmlspecialchars($row["Total_Days"], ENT_QUOTES);
				$Consequence_Served=htmlspecialchars($row["Consequence_Served"], ENT_QUOTES);
			}
			$data = [$Submission_Time,$Incident_Date,$Incident_Time,$Owner_Name,$Owner,$Building,$StudentID,$Student_FirstName,$Student_MiddleName,$Student_LastName,$Student_IEP,$Offence_Display,$Offence_Codes,$Location,$Description,$Information,$Consequence,$Serve_Date,$Thru_Date,$Total_Days,$Consequence_Served];
			fputcsv($output, $data);
		}
		fclose($output);
		mysqli_close($db);
		exit();

	}

?>
