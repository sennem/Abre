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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

  $consequenceID = $_POST["consequenceid"];
  $incidentID = $_POST["incidentid"];
	$reload = $_POST["reload"];

	$stmt = $db->stmt_init();
  $sql = "DELETE FROM conduct_discipline_consequences WHERE Incident_ID = ? and Consequence_ID = ?";
  $stmt->prepare($sql);
	$stmt->bind_param("ii", $incidentID, $consequenceID);
  $stmt->execute();
  $stmt->close();
	$db->close();

	$actionString = "Consequence with ID: ".$consequenceID." was deleted.";

	$Served = 0;
	$consequencesServedTotal = 0;
	$query = "SELECT Consequence_Served FROM conduct_discipline_consequences WHERE Incident_ID = '$incidentID'";
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

	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	$stmt = $db->stmt_init();
	$sql = "UPDATE conduct_discipline SET Served = ? WHERE ID = ?";
	$stmt->prepare($sql);
	$stmt->bind_param("ii", $Served, $incidentID);
	$stmt->execute();
	$stmt->close();

	$sql = "SELECT Type, StudentID, Incident_Date, Incident_Time, Offence, Location, Description, Information, Served, dupIncidentId FROM conduct_discipline WHERE ID = '$incidentID'";
	$dbreturn = $db->query($sql);
	$row = $dbreturn->fetch_assoc();
	$Type = $row['Type'];

	$incidentDetailsString = "Incident with ID: ".$incidentID." and data: {Student ID: ".$row['StudentID'].", Type: ".$row['Type'].", Incident Date: ".$row['Incident_Date'].", Incident Time: ".$row['Incident_Time'].", Offences: ".$row['Offence'].", Location: ".$row['Location'].", Description: ".$row['Description'].", Information: ".$row['Information'].", Served: ".$row['Served'].", Duplicate Incident ID: ".$row['dupIncidentId']."}\r\n";

	$consequenceDetailString = "";
	$query = "SELECT Consequence_ID, Consequence_Name, Serve_Date, Thru_Date, Total_Days, Consequence_Served FROM conduct_discipline_consequences WHERE Incident_ID = '$incidentID'";
	$dbreturn = databasequery($query);
	foreach($dbreturn as $value){
		$consequenceDetailString .= "\r\nConsequence with ID: ".$value['Consequence_ID']." and data: {Consequence: ".$value['Consequence_Name'].", Serve Date: ".$value['Serve_Date'].", Thru Date: ".$value['Thru_Date'].", Total Days: ".$value['Total_Days'].", Served: ".$value['Consequence_Served']."}";
	}

	$detailsString = $incidentDetailsString . $consequenceDetailString;

	$stmt = $db->stmt_init();
	$sql = "INSERT INTO conduct_log (Incident_ID, User, Action, Details) VALUES (?, ?, ?, ?);";
	$stmt->prepare($sql);
	$stmt->bind_param("isss", $incidentID, $_SESSION["useremail"], $actionString, $detailsString);
	$stmt->execute();
	$stmt->close();
	$db->close();

	if($Type == "Office" && getSoftwareAnswersURL() != "" && getSoftwareAnswersKey() != ""){
		//Pass to Report to SIS
		$url = $portal_root."/modules/Abre-Conduct/report_to_sis.php";
		$myvars = 'Incident_ID='.$incidentID.'&Status_Type=Update';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
	}

	$json = array("reload"=>$reload,"method"=>"update","message"=>"Incident Updated");
	header("Content-Type: application/json");
	echo json_encode($json);
?>