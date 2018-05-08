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
	require_once('permissions.php');

	//Get POST Data
	$id = $_POST["id"];
	$reload = $_POST["reload"];

	//Archive the Incident
	$stmt = $db->stmt_init();
	$sql = "UPDATE conduct_discipline SET Archived = '1' where ID = ?";
	$stmt->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->close();

	$actionString = "Incident with ID: ".$id." was archived.";

	$sql = "SELECT Type, SIS_Reported, DisciplineIncidentRefId, StudentID, Incident_Date, Incident_Time, Offence, Location, Description, Information, Served, dupIncidentId FROM conduct_discipline WHERE ID = '$id'";
	$dbreturn = $db->query($sql);
	$row = $dbreturn->fetch_assoc();

	if($row["Type"] == "Office" && getSoftwareAnswersURL() != "" && getSoftwareAnswersKey() != ""){
		if($row["SIS_Reported"] == 1 && $row["DisciplineIncidentRefId"] != ""){
			//Pass to Report to SIS
			$url = $portal_root."/modules/Abre-Conduct/report_to_sis.php";
			$myvars = 'Incident_ID='.$id.'&Status_Type=Update';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
		}
	}

	$incidentDetailsString = "Incident with ID: ".$id." and data: {Student ID: ".$row['StudentID'].", Type: ".$row['Type'].", Incident Date: ".$row['Incident_Date'].", Incident Time: ".$row['Incident_Time'].", Offences: ".$row['Offence'].", Location: ".$row['Location'].", Description: ".$row['Description'].", Information: ".$row['Information'].", Served: ".$row['Served'].", Duplicate Incident ID: ".$row['dupIncidentId']."}\r\n";

	$consequenceDetailString = "";
	$query = "SELECT Consequence_ID, Consequence_Name, Serve_Date, Thru_Date, Total_Days, Consequence_Served FROM conduct_discipline_consequences WHERE Incident_ID = '$id'";
	$dbreturn = databasequery($query);
	foreach($dbreturn as $value){
		$consequenceDetailString .= "\r\nConsequence with ID: ".$value['Consequence_ID']." and data: {Consequence: ".$value['Consequence_Name'].", Serve Date: ".$value['Serve_Date'].", Thru Date: ".$value['Thru_Date'].", Total Days: ".$value['Total_Days'].", Served: ".$value['Consequence_Served']."}";
	}

	$detailsString = $incidentDetailsString . $consequenceDetailString;

	$stmt = $db->stmt_init();
	$sql = "INSERT INTO conduct_log (Incident_ID, User, Action, Details) VALUES (?, ?, ?, ?);";
	$stmt->prepare($sql);
	$stmt->bind_param("isss", $id, $_SESSION["useremail"], $actionString, $detailsString);
	$stmt->execute();
	$stmt->close();

	$db->close();

	$json = array("reload"=>$reload,"method"=>"update","message"=>"Incident Archived");
	header("Content-Type: application/json");
	echo json_encode($json);
?>
