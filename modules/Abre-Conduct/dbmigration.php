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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');

	if(admin()){

		//Delete existing data from Conduct Discipline
		$stmt = $db->stmt_init();
		$sql = "DELETE FROM conduct_discipline_consequences";
		$stmt->prepare($sql);
		$stmt->execute();
		$stmt->store_result();
		$stmt->close();

		//Get existing Discipline Data
		$query = "SELECT * FROM conduct_discipline";
		$dbreturn = databasequery($query);
		foreach ($dbreturn as $value){
			$IncidentID = htmlspecialchars($value["ID"], ENT_QUOTES);
			$Consequence = htmlspecialchars($value["Consequence"], ENT_QUOTES);
			$Serve_Date = htmlspecialchars($value["Serve_Date"], ENT_QUOTES);
			$Thru_Date = htmlspecialchars($value["Thru_Date"], ENT_QUOTES);
			$Total_Days = htmlspecialchars($value["Total_Days"], ENT_QUOTES);
			$Served = htmlspecialchars($value["Served"], ENT_QUOTES);

			if($Consequence != ""){
				$array = explode(', ', $Consequence);
				foreach($array as $value){
					$stmt = $db->stmt_init();
					$sql = "INSERT INTO conduct_discipline_consequences (Incident_ID, Consequence_Name, Serve_Date, Thru_Date, Total_Days, Consequence_Served) VALUES (?, ?, ?, ?, ?, ?);";
					$stmt->prepare($sql);
					$stmt->bind_param("isssii", $IncidentID, $value, $Serve_Date, $Thru_Date, $Total_Days, $Served);
					$stmt->execute();
					$stmt->close();
				}
			}
		}

		$db->close();
		echo "Migration Complete";
	}
?>