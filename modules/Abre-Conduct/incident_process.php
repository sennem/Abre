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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');

	$Owner_Name = "";
	if($_SESSION['displayName'] == ""){
		$query = "SELECT FirstName, LastName FROM Abre_Staff WHERE EMail1 = '".$_SESSION['useremail']."' LIMIT 1";
    $dbreturn = databasequery($query);
    foreach ($dbreturn as $value){
			$FirstName = $value["FirstName"];
      $LastName = $value["LastName"];
      $Owner_Name = "$FirstName $LastName";
		}
	}else{
		$Owner_Name = $_SESSION['displayName'];
	}
	$Owner_Name = $Owner_Name;

	//Create the Incident
	$Incident_ID = $_POST["Incident_ID"];
	$Type = $_POST["Type"];
	$IncidentDate = $_POST["IncidentDate"];
	$IncidentTime = $_POST["IncidentTime"];
	$IncidentReload = $_POST["Incident_Reload"];
	if(isset($_POST["Offence"])){ $Offence = $_POST["Offence"]; $OffenceData = NULL; }else{ $Offence = NULL; }

	//Loop through each multiselect
	$OffenceCodes = "";
	if($Offence != NULL){
		foreach($Offence as $Offences){
			//Add Offence codes if offence is listed
			$sql = "SELECT ViolationNumber FROM conduct_offences WHERE Offence = '$Offences'";
			$dbreturn = databasequery($sql);
			foreach ($dbreturn as $value){
				$ViolationNumber = $value['ViolationNumber'];
				$OffenceCodes = "$OffenceCodes, $ViolationNumber";
			}

			$Offences = '"'.$Offences.'"';
			$OffenceData = "$OffenceData, $Offences";
		}
		$OffenceData = substr($OffenceData, 2);
	  $OffenceCodes = substr($OffenceCodes, 2);
	}else{
		$OffenceData = "";
	}

	$Location = $_POST["Location"];
	$Description = $_POST["Description"];
	$Information = $_POST["Information"];

	$StudentID = $_POST["Incident_Student_ID"];
	$StudentIEP = $_POST["Incident_Student_IEP"];
	$StudentFirstName = $_POST["Incident_Student_FirstName"];
	$StudentMiddleName = $_POST["Incident_Student_MiddleName"];
	$StudentLastName = $_POST["Incident_Student_LastName"];
	$StudentBuilding = $_POST["Incident_Student_Building"];
	$StudentBuildingCode = $_POST["Incident_Student_Code"];
	isset($_POST["Owner_Email"]) ? $Owner_Email = $_POST["Owner_Email"] : $Owner_Email = "";
	isset($_POST["dupIncidentId"]) ? $dupIncidentId = $_POST["dupIncidentId"] : $dupIncidentId = 0;

	$inVerification = true;
	$message = "";
	$actionString = "";
	$incidentModified = false;
	$isError = false;
	$errorValue = "";

	//Add or update the incident
	if(!isset($IncidentDate)){
		$isError = true;
		$errorValue = "incident date";
	}
	if(!isset($IncidentTime)){
		$isError = true;
		$errorValue = "incident time";
	}
	if(!isset($Type)){
		$isError = true;
		$errorValue = "type";
	}
	if(!isset($Description) || $Description == ""){
		$isError = true;
		$errorValue = "description";
	}
	if(!isset($OffenceData)){
		$isError = true;
		$errorValue = "offence";
	}
	if(!isset($Location)){
		$isError = true;
		$errorValue = "location";
	}

	if($isError){
		if($errorValue == "offence" || $errorValue == "incident date" || $errorValue == "incident time"){
			$message = "Error! Your incident was not saved. An ".$errorValue." was not set.";
		}else{
			$message = "Error! Your incident was not saved. A ".$errorValue." was not set.";
		}

		$db->close();

		//return information to the front end
		$retMessage = array("method"=>"error", "message"=>$message);
		header("Content-Type: application/json");
		echo json_encode($retMessage);
	}else{
		if($Incident_ID == ""){
			$stmt = $db->stmt_init();
			$sql = "INSERT INTO conduct_discipline (Incident_Date, Incident_Time, Owner, Owner_Name, Building, SchoolCode, Type, Student_IEP, StudentID, Student_FirstName, Student_MiddleName, Student_LastName, Offence, Location, Description, Information, Served, Offence_Codes, dupIncidentId, Last_Modified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', ?, ?, ?);";
			$stmt->prepare($sql);
			$stmt->bind_param("sssssssssssssssssis", $IncidentDate, $IncidentTime, $_SESSION['useremail'], $Owner_Name, $StudentBuilding, $StudentBuildingCode, $Type, $StudentIEP, $StudentID, $StudentFirstName, $StudentMiddleName, $StudentLastName, $OffenceData, $Location, $Description, $Information, $OffenceCodes, $dupIncidentId, $_SESSION['useremail']);
			$stmt->execute();
			$Incident_ID = $stmt->insert_id;
			$stmt->close();

			$actionString .= "A new incident was created with ID ".$Incident_ID.".\r\n";
			$message = "Incident Created";
		}else{
			$sql = "SELECT Type, Served, DisciplineIncidentRefId, Student_MiddleName, Student_LastName, Incident_Date, Incident_Time, Offence, Location, Description, Information FROM conduct_discipline WHERE ID = '$Incident_ID'";
			$dbreturn = $db->query($sql);
			$row = $dbreturn->fetch_assoc();
			$oldType = $row["Type"];
			$oldServed = $row["Served"];
			$DisciplineIncidentRefId = $row["DisciplineIncidentRefId"];

			if($StudentMiddleName != $row["Student_MiddleName"]){
				$actionString .= "Middle name was changed from: ".$row["Student_MiddleName"]." to ".$StudentMiddleName.".\r\n";
				$incidentModified = true;
			}
			if($StudentLastName != $row["Student_LastName"]){
				$actionString .= "Last name was changed from: ".$row["Student_LastName"]." to ".$StudentLastName.".\r\n";
				$incidentModified = true;
			}
			if($Type != $row["Type"]){
				$actionString .= "Type was changed from: ".$row["Type"]." to ".$Type.".\r\n";
				$incidentModified = true;
			}
			if($IncidentDate != $row["Incident_Date"]){
				$actionString .= "Incident date was changed from: ".$row["Incident_Date"]." to: ".$IncidentDate.".\r\n";
				$incidentModified = true;
			}
			if($IncidentTime != $row["Incident_Time"]){
				$actionString .= "Incident time was changed from: ".$row["Incident_Time"]." to: ".$IncidentTime.".\r\n";
				$incidentModified = true;
			}
			if($OffenceData != $row["Offence"]){
				$actionString .= "Offense data was changed from: ".$row["Offence"]." to: ".$OffenceData.".\r\n";
				$incidentModified = true;
			}
			if($Location != $row["Location"]){
				$actionString .= "Location was changed from: ".$row["Location"]." to: ".$Location.".\r\n";
				$incidentModified = true;
			}
			if($Description != $row["Description"]){
				$actionString .= "Description was changed from: ".$row["Description"]." to: ".$Description.".\r\n";
				$incidentModified = true;
			}
			if($Information != $row["Information"]){
				$actionString .= "Information was changed from: ".$row["Information"]." to: ".$Information.".\r\n";
				$incidentModified = true;
			}

			if($incidentModified){
				$stmt = $db->stmt_init();
				$sql = "UPDATE conduct_discipline SET Student_FirstName = ?, Student_MiddleName = ?, Student_LastName = ?, Type = ?, Incident_Date = ?, Incident_Time = ?, Offence = ?, Location = ?, Description = ?, Information = ?, Offence_Codes = ?, Last_Modified = ? WHERE ID = ?";
				$stmt->prepare($sql);
				$stmt->bind_param("ssssssssssssi", $StudentFirstName, $StudentMiddleName, $StudentLastName, $Type, $IncidentDate, $IncidentTime, $OffenceData, $Location, $Description, $Information, $OffenceCodes, $_SESSION['useremail'], $Incident_ID);
				$stmt->execute();
				$stmt->close();
			}else{
				$actionString .= "No incident changes were made.\r\n";
			}

			$message = "Incident Updated";
		}


		$consequenceResponse = array();
		$emptyConsequenceCount = 0;
		$consequenceModified = false;
		$consequenceCreated = false;
		$consequenceDetailString = "";

		// If an incident is moving from a personal referral to an office referral,
		//reset (delete) the consequences for that incident
		if($oldType == "Personal" && $Type == "Office"){
			$stmt = $db->stmt_init();
			$sql = "DELETE FROM conduct_discipline_consequences WHERE Incident_ID = ?";
			$stmt->prepare($sql);
			$stmt->bind_param("i", $Incident_ID);
			$stmt->execute();
			$stmt->close();
			$emptyConsequenceCount = 8;

			$actionString .= "A personal referral was moved to an office referral. Saved consequences have been removed.\r\n";
		}else{
			//loop over submitted consequences and either insert them into the database if they are new
			//for the incident or update the pre-existing consequence's information
			for($i = 0; $i < 8; $i++){
				if(!isset($_POST["Consequence".$i]) || $_POST["Consequence".$i] == ""){
					$emptyConsequenceCount++;
					continue;
				}else{
					$ConsequenceID = $_POST["Consequence_ID".$i];
					$Consequence = $_POST["Consequence".$i];
					$ServeDate = $_POST["ServeDate".$i];
					if($ServeDate == ""){ $ServeDate = date('Y-m-d'); }
					$ThruDate = $_POST["ThruDate".$i];
					if($ThruDate == ""){ $ThruDate = date('Y-m-d'); }
					$TotalDays = $_POST["NumberOfDaysServed".$i];
					if(isset($_POST["servedCheckbox".$i])){ $Served = $_POST["servedCheckbox".$i]; }else{ $Served = NULL; }
					if($Served == "on"){ $Served = 1; }else{ $Served = 0; }

					if($ConsequenceID == ""){
						$stmt = $db->stmt_init();
						$sql = "INSERT INTO conduct_discipline_consequences (Incident_ID, Consequence_Name, Serve_Date, Thru_Date, Total_Days, Consequence_Served, Last_Modified) VALUES (?, ?, ?, ?, ?, ?, ?);";
						$stmt->prepare($sql);
						$stmt->bind_param("isssiis", $Incident_ID, $Consequence, $ServeDate, $ThruDate, $TotalDays, $Served, $_SESSION['useremail']);
						$stmt->execute();
						$ConsequenceID = $stmt->insert_id;
						array_push($consequenceResponse, $ConsequenceID);
						$stmt->close();
						$actionString .= "A new consequence was added with ID ".$ConsequenceID.".\r\n";
						$consequenceCreated = true;

					}else{
						$sql = "SELECT Consequence_Name, Serve_Date, Thru_Date, Total_Days, Consequence_Served FROM conduct_discipline_consequences WHERE Consequence_ID = '$ConsequenceID'";
						$dbreturn = $db->query($sql);
						$row = $dbreturn->fetch_assoc();

						array_push($consequenceResponse, $ConsequenceID);
						if($Consequence != $row["Consequence_Name"]){
							$actionString .= "Consequence ".$ConsequenceID." was changed from: ".$row["Consequence_Name"]." to: ".$Consequence.".\r\n";
							$consequenceModified = true;
						}
						if($ServeDate != $row["Serve_Date"]){
							$actionString .= "Consequence ".$ConsequenceID."'s Serve Date was changed from: ".$row["Serve_Date"]." to: ".$ServeDate.".\r\n";
							$consequenceModified = true;
						}
						if($ThruDate != $row["Thru_Date"]){
							$actionString .= "Consequence ".$ConsequenceID."'s Thru Date was changed from: ".$row["Thru_Date"]." to: ".$ThruDate.".\r\n";
							$consequenceModified = true;
						}
						if($TotalDays != $row["Total_Days"]){
							$actionString .= "Consequence ".$ConsequenceID."'s Total Days was changed from: ".$row["Total_Days"]." to: ".$TotalDays.".\r\n";
							$consequenceModified = true;
						}
						if($Served != $row["Consequence_Served"]){
							$actionString .= "Consequence ".$ConsequenceID." was marked as served.\r\n";
							$consequenceModified = true;
						}

						if($consequenceModified){
							$stmt = $db->stmt_init();
							$sql = "UPDATE conduct_discipline_consequences SET Incident_ID = ?, Consequence_Name = ?, Serve_Date = ?, Thru_Date = ?, Total_Days = ?, Consequence_Served = ?, Last_Modified = ? WHERE Consequence_ID = ?";
							$stmt->prepare($sql);
							$stmt->bind_param("isssiisi", $Incident_ID, $Consequence, $ServeDate, $ThruDate, $TotalDays, $Served, $_SESSION["useremail"], $ConsequenceID);
							$stmt->execute();
							$stmt->close();
							$consequenceModified = false;
						}
					}
					$consequenceDetailString .= "\r\nConsequence with ID: ".$ConsequenceID." and data: {Consequence: ".$Consequence.", Serve Date: ".$ServeDate.", Thru Date: ".$ThruDate.", Total Days: ".$TotalDays.", Served: ".$Served."}";
				}
			}
		}

		//if incident id is zero there was an error inserting it and we shouldn't do
		//any of the below processes.
		if($Incident_ID != 0){
			//check and see if all the consequences for an incident have been served. If
			//they have all been served, we need to mark the incident as served.
			$consequencesServedTotal = 0;
			$hasExpulsionOrSuspension = false; //used later for SIS reporting
			$query = "SELECT Consequence_Name, Consequence_Served FROM conduct_discipline_consequences WHERE Incident_ID = '$Incident_ID'";
			$dbreturn = databasequery($query);
			foreach($dbreturn as $value){
				if($value["Consequence_Name"] == "Expulsion" || $value["Consequence_Name"] == "Suspension - OSS"){
					$hasExpulsionOrSuspension = true;
				}
				if($value["Consequence_Served"] == 1){
					$consequencesServedTotal++;
				}
			}
			if($consequencesServedTotal == count($dbreturn) && count($dbreturn) != 0){
				$incidentServed = 1;
			}else{
				$incidentServed = 0;
			}

			//if there is not a consequence, we are not in the verification tab.
			if($emptyConsequenceCount == 8){
				$inVerification = false;
			}

			if(isset($oldServed)){
				if($oldServed == 0 && $oldServed != $incidentServed){
					$actionString .= "The incident was marked as served.\r\n";
				}
				if($oldServed == 1 && $oldServed != $incidentServed){
					$actionString .= "The incident was marked as not being served.\r\n";
				}
			}

			$stmt = $db->stmt_init();
			$sql = "UPDATE conduct_discipline SET Served = ? WHERE ID = ?";
			$stmt->prepare($sql);
			$stmt->bind_param("ii", $incidentServed, $Incident_ID);
			$stmt->execute();
			$stmt->close();

			//send an email based and navigate the user to the appropriate tab
			if(($IncidentReload == "" || $IncidentReload == "open") && $Type == "Office"){
				sendAdminConductEmail($StudentBuildingCode, $StudentFirstName, $StudentLastName, $inVerification);
			}
			if($incidentServed == 1 && (admin() || conductAdminCheck($_SESSION['useremail']))){
				if($IncidentReload == ""){
					sendOwnerConductEmail($_SESSION['useremail'], $StudentFirstName, $StudentLastName);
				}else{
					sendOwnerConductEmail($Owner_Email, $StudentFirstName, $StudentLastName);
				}
				$IncidentReload = "closed";
			}elseif($Type == "Personal" && $incidentServed == 1){
				$IncidentReload = "closed";
			}elseif($Type == "Office" && $inVerification && (admin() || conductAdminCheck($_SESSION['useremail']) || conductMonitor($_SESSION['useremail']))){
				$IncidentReload = "verification";
			}elseif(($IncidentReload == "" || $IncidentReload == "open") && $Type == "Office" && (admin() || conductAdminCheck($_SESSION['useremail']))){
				$IncidentReload = "queue";
			}elseif($Type == "Office" && (admin() || conductAdminCheck($_SESSION['useremail']))){
				$IncidentReload = "queue";
			}else{
				$IncidentReload = "open";
			}

			$incidentDetailsString = "Incident with ID: ".$Incident_ID." and data: {Student ID: ".$StudentID.", Type: ".$Type.", Incident Date: ".$IncidentDate.", Incident Time: ".$IncidentTime.", Offences: ".$OffenceData.", Location: ".$Location.", Description: ".$Description.", Information: ".$Information.", Served: ".$incidentServed.", Duplicate Incident ID: ".$dupIncidentId."}\r\n";
			$detailsString = $incidentDetailsString . $consequenceDetailString;

			$stmt = $db->stmt_init();
			$sql = "INSERT INTO conduct_log (Incident_ID, User, Action, Details) VALUES (?, ?, ?, ?);";
			$stmt->prepare($sql);
			$stmt->bind_param("isss", $Incident_ID, $_SESSION["useremail"], $actionString, $detailsString);
			$stmt->execute();
			$stmt->close();

			//Send/Update SIS
			$reported = false;
			if($Type == "Office" && getSoftwareAnswersURL() != "" && getSoftwareAnswersKey() != ""){
				if($hasExpulsionOrSuspension){
					$url = $portal_root."/modules/Abre-Conduct/report_to_sis.php";
					if(isset($DisciplineIncidentRefId) && $DisciplineIncidentRefId != ""){
						//update SIS information?
						$myvars = 'Incident_ID='.$Incident_ID.'&Status_Type=Update';
					}else{
						//Pass to Report to SIS
						$myvars = 'Incident_ID='.$Incident_ID.'&Status_Type=New';
					}
					$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$response = curl_exec($ch);

					$reported = true;
				}
			}
			if(!$reported && isset($DisciplineIncidentRefId) && $DisciplineIncidentRefId != ""){
				//incident was reported before but now none of the consequences are expulsion or
				//Suspension
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
		}

		$db->close();

		//return information to the front end
		$retMessage = array("reload"=>$IncidentReload, "method"=>"update", "message"=>$message, "consequenceid"=>$consequenceResponse, "incidentid"=>$Incident_ID);
		header("Content-Type: application/json");
		echo json_encode($retMessage);
	}

?>