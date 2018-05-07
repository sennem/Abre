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
	require_once('permissions.php');

	//get offences
	$StudentID = mysqli_real_escape_string($db, $_POST["studentid"]);
	$submissionID = mysqli_real_escape_string($db, $_POST["submissionID"]);
	include "../../core/abre_dbconnect.php";
	$query = "SELECT conduct_discipline.Incident_Date, conduct_discipline.Offence, conduct_discipline.Location, conduct_discipline_consequences.Consequence_Name, conduct_discipline_consequences.Serve_Date, conduct_discipline_consequences.Thru_Date, conduct_discipline_consequences.Consequence_Served FROM conduct_discipline LEFT JOIN conduct_discipline_consequences ON conduct_discipline.ID = conduct_discipline_consequences.Incident_ID WHERE StudentID = '$StudentID' AND ID != '$submissionID' AND Archived = '0' ORDER BY Incident_Date DESC LIMIT 100";
	$dbreturn = databasequery($query);
	$count = count($dbreturn);
	$counter = 0;

	echo "<b>Previous Offenses</b><br>";

	foreach ($dbreturn as $value){
		$counter++;
		if($counter == 1){
			echo "<table class='tablesorter striped'>";
			echo "<thead><tr><th>Incident Date</th><th>Offense</th><th>Consequence</th><th class='hide-on-med-and-down'>Start Date</th><th class='hide-on-med-and-down'>Thru Date</th><th class='hide-on-med-and-down'>Served</th></tr></thead>";
		}

		$Incident_Date = htmlspecialchars($value["Incident_Date"], ENT_QUOTES);
		$Incident_Date = date("m/d/Y", strtotime($Incident_Date));
		$Offence = htmlspecialchars($value["Offence"], ENT_QUOTES);
		$Offence_Display = str_replace(array("'", "\"", "&quot;"), "", $Offence);
		$Location = htmlspecialchars($value["Location"], ENT_QUOTES);
		$Consequence = htmlspecialchars($value["Consequence_Name"], ENT_QUOTES);
		$Served_Date = htmlspecialchars($value["Serve_Date"], ENT_QUOTES);
		$Thru_Date = htmlspecialchars($value["Thru_Date"], ENT_QUOTES);
		$Served = htmlspecialchars($value["Consequence_Served"], ENT_QUOTES);

		if($Consequence != ""){
			if($Served_Date != "" && isset($Served_Date)){
				$Served_Date = date("m/d/Y", strtotime($Served_Date));
			}else{
				$Served_Date = "Unassigned";
			}
			if($Thru_Date != "" && isset($Thru_Date)){
				$Thru_Date = date("m/d/Y", strtotime($Thru_Date));
			}else{
				$Thru_Date = "Unassigned";
			}
			if($Served == 0){ $Served = "No"; }else{ $Served = "Yes"; }
		}else{
			$Consequence = "No consequence assigned";
			$Served = "";
		}

		echo "<tr><td>$Incident_Date</td><td>$Offence_Display</td><td>$Consequence</td><td class='hide-on-med-and-down'>$Served_Date</td><td class='hide-on-med-and-down'>$Thru_Date</td><td class='hide-on-med-and-down'>$Served</td></tr>";

		if($count == $counter){
			echo "</table>";
		}
	}
	if($count == 0){
		echo "No previous offences.";
	}
?>