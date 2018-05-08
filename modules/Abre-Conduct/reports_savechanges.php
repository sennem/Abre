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

	if(admin() or conductAdminCheck($_SESSION['useremail']) or conductMonitor($_SESSION['useremail'])){

		$SubmissionID = $_POST["SubmissionID"];
		$ConsequenceID = $_POST["ConsequenceID"];
		$Column = $_POST["Column"];
		$Value = $_POST["Value"];

		mysqli_query($db, "UPDATE conduct_discipline_consequences SET $Column = '$Value' where Incident_ID = '$SubmissionID' and Consequence_ID = '$ConsequenceID'") or die (mysqli_error($db));

		$Served = 0;
		$consequencesServedTotal = 0;
		$query = "SELECT Consequence_Served FROM conduct_discipline_consequences WHERE Incident_ID = '$SubmissionID'";
		$dbreturn = databasequery($query);
		foreach($dbreturn as $value){
			if($value["Consequence_Served"] == 1){
				$consequencesServedTotal++;
			}
		}
		if($consequencesServedTotal == count($dbreturn) && count($dbreturn) != 0){
			$Served = 1;
		}else{
			$Served = 0;
		}

		if($Column == "Consequence_Served"){
			$Column = "Served";
			mysqli_query($db, "UPDATE conduct_discipline set $Column='$Served' where ID='$SubmissionID'") or die (mysqli_error($db));
		}

		if(getSoftwareAnswersURL() != "" && getSoftwareAnswersKey() != ""){
			$url = $portal_root."/modules/Abre-Conduct/report_to_sis.php";
			$myvars = 'Incident_ID='.$SubmissionID.'&Status_Type=Update';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
		}
	}
?>