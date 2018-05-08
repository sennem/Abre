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

	if($pagerestrictions=="")
	{

		$ConductID=$_GET["ConductID"];

		$query = "SELECT ID, Incident_Date, Incident_Time, Offence, Location, Description, Information FROM conduct_discipline WHERE ID = '$ConductID' LIMIT 1";
		$dbreturn = databasequery($query);
		foreach ($dbreturn as $value)
		{

			$ID=htmlspecialchars($value['ID'], ENT_QUOTES);
			$Incident_Date=htmlspecialchars($value['Incident_Date'], ENT_QUOTES);
			$Incident_Time=htmlspecialchars($value['Incident_Time'], ENT_QUOTES);
			$Offence=htmlspecialchars($value['Offence'], ENT_QUOTES);
			$Location=htmlspecialchars($value['Location'], ENT_QUOTES);
			$Description=htmlspecialchars($value['Description'], ENT_QUOTES);
			$Information=htmlspecialchars($value['Information'], ENT_QUOTES);
			$Offence_Display = str_replace(array("'", "\"", "&quot;"), "", $Offence);


			echo "<div class='row'>";
				echo "<div class='col l3 s6'>";
					echo "<b>Date of Incident</b>";
					echo "<p>$Incident_Date</p>";
				echo "</div>";
				echo "<div class='col l3 s6'>";
					echo "<b>Time of Incident</b>";
					echo "<p>$Incident_Time</p>";
				echo "</div>";
				echo "<div class='col l3 s6'>";
					echo "<b>Offense</b>";
					echo "<p>$Offence_Display</p>";
				echo "</div>";
				echo "<div class='col l3 s6'>";
					echo "<b>Location</b>";
					echo "<p>$Location</p>";
				echo "</div>";
			echo "</div>";

			echo "<div class='row'><hr></div>";

			echo "<div class='row'>";
				echo "<div class='col l6 s12'>";
					echo "<b>Description (Facts and Details Viewable by Parents)</b>";
					echo "<p>$Description</p>";
				echo "</div>";
				echo "<div class='col l6 s12'>";
					echo "<b>Additional Information (Not Viewable by Parents)</b>";
					echo "<p>$Information</p>";
				echo "</div>";
			echo "</div>";

			echo "<div class='row'><hr></div>";

			//Loop through Consequences
			$queryconsequences = "SELECT Consequence_Name, Serve_Date, Thru_Date, Total_Days FROM conduct_discipline_consequences WHERE Incident_ID = '$ConductID'";
			$dbreturnconsequences = databasequery($queryconsequences);
			foreach ($dbreturnconsequences as $valueconsequences)
			{

				$Consequence_Name=htmlspecialchars($valueconsequences['Consequence_Name'], ENT_QUOTES);
				$Serve_Date=htmlspecialchars($valueconsequences['Serve_Date'], ENT_QUOTES);
				$Thru_Date=htmlspecialchars($valueconsequences['Thru_Date'], ENT_QUOTES);
				$Total_Days=htmlspecialchars($valueconsequences['Total_Days'], ENT_QUOTES);

				echo "<div class='row'>";
					echo "<div class='col l3 s6'>";
						echo "<b>Consequence</b>";
						echo "<p>$Consequence_Name</p>";
					echo "</div>";
					echo "<div class='col l3 s6'>";
						echo "<b>Start Date</b>";
						echo "<p>$Serve_Date</p>";
					echo "</div>";
					echo "<div class='col l3 s6'>";
						echo "<b>End Date</b>";
						echo "<p>$Thru_Date</p>";
					echo "</div>";
					echo "<div class='col l3 s6'>";
						echo "<b>Number of Days</b>";
						echo "<p>$Total_Days</p>";
					echo "</div>";
				echo "</div>";
			}

		}


	}
?>
