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
	require_once('permissions.php');

	if($pagerestrictions == ""){

		//Get StaffID Given Email
		function GetStaffID($email){
			$email = strtolower($email);
			$query = "SELECT StaffID FROM Abre_Staff WHERE EMail1 LIKE '$email' LIMIT 1";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value){
				$StaffId = htmlspecialchars($value["StaffID"], ENT_QUOTES);
				return $StaffId;
			}
		}

		//Get SchoolCode Given Email
		function GetStaffSchoolCode($email){
			$email = strtolower($email);
			$query = "SELECT SchoolCode FROM Abre_Staff WHERE EMail1 LIKE '$email'";
			$dbreturn = databasequery($query);
			$SchoolCode = "";
			$SchoolCodeTotal = "";
			foreach ($dbreturn as $value){
				$SchoolCode = htmlspecialchars($value["SchoolCode"], ENT_QUOTES);
				$SchoolCodeTotal = "$SchoolCode, $SchoolCodeTotal";
			}
			$SchoolCodeTotal = substr($SchoolCodeTotal, 0, -2);

			return $SchoolCodeTotal;
		}

		//Get Student Name Given ID
		function GetStudentNameGivenID($studentid){
			$query = "SELECT FirstName, LastName FROM Abre_Students WHERE StudentId = '$studentid' LIMIT 1";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value){
				$FirstName = htmlspecialchars($value["FirstName"], ENT_QUOTES);
				$LastName = htmlspecialchars($value["LastName"], ENT_QUOTES);
				return "$FirstName $LastName";
			}
		}

		//Get Student LastName Given ID
		function GetStudentLastNameGivenID($studentid){
			$query = "SELECT LastName FROM Abre_Students WHERE StudentId = '$studentid' LIMIT 1";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value){
				$LastName = htmlspecialchars($value["LastName"], ENT_QUOTES);
				return $LastName;
			}
		}

		//Get Student FirstName Given ID
		function GetStudentFirstNameGivenID($studentid){
			$query = "SELECT FirstName FROM Abre_Students WHERE StudentId = '$studentid' LIMIT 1";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value){
				$FirstName = htmlspecialchars($value["FirstName"], ENT_QUOTES);
				return $FirstName;
			}
		}

		//Get Current Semester
		function GetCurrentSemester(){
			$currentMonth = date("F");
			if(	$currentMonth == "January" 	or
				$currentMonth == "February" 	or
				$currentMonth == "March" 		or
				$currentMonth == "April" 		or
				$currentMonth == "May" 		or
				$currentMonth == "June" 		or
				$currentMonth == "July" 		or
				$currentMonth == "August"
			){
				return "Sem2";
			}else{
				return "Sem1";
			}
		}

		//Get Course Name
		function GetCourseName($CourseCode, $SchoolCode){
			$query = "SELECT LongCourseName FROM Swoca_HA_OnHands_Courses WHERE CourseCode = '$CourseCode' AND SchoolCode = '$SchoolCode'";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value){
				$LongCourseName = $value["LongCourseName"];
				return $LongCourseName;
			}
		}

		//Display Card
		function DisplayCard($image, $title, $coursegroup, $section){
			echo "<div class='col l3 m4 s12'>";
				echo "<div class='mdl-card mdl-shadow--2dp link pointer' style='width:100%; background-color: #fff; padding:20px; margin-bottom:20px;'>";
					echo "<img src='/modules/Abre-Conduct/images/$image' width='94px' height='94px' style='margin:0 auto;'><br>";
					echo "<span class='center-align truncate'>$title</span>";
					if($section == ''){
						echo "<a href='#conduct/classroom/$coursegroup/#'></a>";
					}else{
						echo "<a href='#conduct/classroom/$coursegroup/$section'></a>";
					}
				echo "</div>";
			echo "</div>";
		}

		//Check to see if use is a District Administrator
		function conductAdminCheck($email){
			require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
			$contract = encrypt('Administrator', "");
			$sql = "SELECT COUNT(*) FROM directory WHERE email = '$email' AND contract = '$contract'";
			$result = $db->query($sql);
			$resultrow = $result->fetch_assoc();
			$count = $resultrow["COUNT(*)"];
			if($count >= 1){
				return 1;
			}else{
				//Check to see if they have the Conduct Administrator Role
				$sql = "SELECT role FROM directory WHERE email = '$email'";
				$dbreturn = databasequery($sql);
				foreach ($dbreturn as $value){
					$role = decrypt($value["role"], "");
					if (strpos($role, 'Conduct Administrator') !== false) {
						return 1;
					}
				}
				return 0;
			}
			$db->close();
		}

		//Check to see if user has conduct verifcation role
		function conductMonitor($email){
			require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
			$sql = "SELECT role FROM directory WHERE email = '$email'";
			$dbreturn = databasequery($sql);
			foreach ($dbreturn as $value){
				$role = decrypt($value["role"], "");
				if (strpos($role, 'Conduct Verification Monitor') !== false) {
					return 1;
				}
			}
			return 0;
			$db->close();
		}

		function sendAdminConductEmail($StudentBuildingCode, $StudentFirstName, $StudentLastName, $inVerification){
			//select all staff members in the same building as student. If they are
			//an admin, send an email to them.
			$recipients = array();
			$sql = "SELECT EMail1 FROM Abre_Staff WHERE SchoolCode = '$StudentBuildingCode'";
			$dbreturn = databasequery($sql);
			foreach($dbreturn as $value){
				if(conductAdminCheck($value["EMail1"])){
					array_push($recipients, $value["EMail1"]);
				}
			}

			$to = implode(", ", $recipients);
			$subject = "New Incident Posted";
			if($inVerification){
				$message = "A new incident for $StudentFirstName $StudentLastName has been posted to your verification tab. Please visit your conduct app to view more details about this incident.";
			}else{
				$message = "A new incident for $StudentFirstName $StudentLastName has been posted to your queue tab. Please visit your conduct app to view more details about this incident.";
			}
			$headers = "From: noreply@abre.io";
			mail($to,$subject,$message,$headers);
		}

		function sendOwnerConductEmail($Owner_Email, $StudentFirstName, $StudentLastName){
			//Send email to owner of the incident. The owners email is passed to the function.
			$to = $Owner_Email;
			$subject = "Incident Closed";
			$message = "The incident for $StudentFirstName $StudentLastName has been closed. Please visit your conduct app to view more details about this incident.";
			$headers = "From: noreply@abre.io";
			mail($to,$subject,$message,$headers);
		}
	}

	//Add Incident to SIS
	function addToSIS(
		$RefId,
		$Incident_ID,
		$SchoolInfoRefId,
		$SchoolYear,
		$IncidentNumber,
		$IncidentName,
		$Incident_Description,
		$IncidentDateTime,
		$LEAInfoRefId,
		$IncidentBuildingIRN,
		$IncidentAgainstPropertyInd,
		$DisciplineIncidentPlaceCodeId,
		$DisciplineIncidentTimeFrameCodeId,
		$FacilitiesCodeId,
		$IncidentStatusTypeCodeId,
		$IncidentComment,
		$IncidentReferrer_DisciplinePersonRefId,
		$IncidentReferrer_PersonType,
		$Offenders_DisciplineOffenderId,
		$Offenders_DisciplinePersonRefId,
		$Offenders_PersonType,
		$Offender_InfractionArray,
		$Offenders_DisciplinaryActionsArray,
		$Offenders_ParentInvolvements,
		$Victims_Victims,
		$Witnesses_Witnesses,
		$Status_Type){

		$VendorLinkURL = getSoftwareAnswersURL();

		$IncidentTime = time();
		$IncidentTime = date("Y-m-d h:i:s",$IncidentTime);

		$data = array([
			"RefId" => $RefId,
			"SchoolInfoRefId" => $SchoolInfoRefId,
			"SchoolYear" => $SchoolYear,
			"IncidentNumber" => $IncidentNumber,
			"IncidentName" => $IncidentName,
			"Description" => $Incident_Description,
			"IncidentDateTime" => $IncidentDateTime,
			"LEAInfoRefId" => $LEAInfoRefId,
			"IncidentBuildingIRN" => $IncidentBuildingIRN,
			"IncidentAgainstPropertyInd" => $IncidentAgainstPropertyInd,
			"DisciplineIncidentPlaceCodeId" => $DisciplineIncidentPlaceCodeId,
			"DisciplineIncidentTimeFrameCodeId" => $DisciplineIncidentTimeFrameCodeId,
			"FacilitiesCodeId" => $FacilitiesCodeId,
			"IncidentComment" => $IncidentComment,
			"IncidentStatusTypeCodeId" => $IncidentStatusTypeCodeId,
			"IncidentReferrer" => array(
				"DisciplinePersonRefId" => $IncidentReferrer_DisciplinePersonRefId,
				"PersonType" => $IncidentReferrer_PersonType
			),
			"IncidentCategories" => [],
			"Offenders" => array([
				"DisciplineOffenderId" => $Offenders_DisciplineOffenderId,
				"DisciplinePersonRefId" => $Offenders_DisciplinePersonRefId,
				"PersonType" => $Offenders_PersonType,
				"Infractions" => $Offender_InfractionArray,
				"DisciplinaryActions" => $Offenders_DisciplinaryActionsArray,
				"ParentInvolvements" => $Offenders_ParentInvolvements,
			]),
			"Victims" => $Victims_Victims,
			"Witnesses" => $Witnesses_Witnesses
		]);
		$fields = json_encode($data);

		if(is_null($RefId) && $Status_Type == "New"){
			$VendorLinkPost = vendorLinkPost("$VendorLinkURL/SisService/DisciplineIncident", $fields);
			if($VendorLinkPost['Message'] != "Invalid Message Format" && $VendorLinkPost['Message'] != "An error has occurred." && isset($VendorLinkPost)){
				$VendorLinkPostJSON = json_encode($VendorLinkPost);
				error_log("Result: ".$VendorLinkPostJSON);
				$VendorLinkPostJSON = json_decode($VendorLinkPostJSON,true);
				if(isset($VendorLinkPostJSON['result'][0])){
					$DisciplineIncidentRefId = $VendorLinkPostJSON['result'][0];
					$DisciplineIncidentRefId = json_encode($DisciplineIncidentRefId);
					$DisciplineIncidentRefId = json_decode($DisciplineIncidentRefId,true);
					$DisciplineIncidentRefId = $DisciplineIncidentRefId['access'];
					$DisciplineIncidentRefId = substr($DisciplineIncidentRefId, strpos($DisciplineIncidentRefId, "=") + 1);
					require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
					mysqli_query($db, "UPDATE conduct_discipline SET SIS_Reported = '1', DisciplineIncidentRefId = '$DisciplineIncidentRefId' WHERE ID = '$Incident_ID'") or die (mysqli_error($db));
				}
			}else{
				error_log("Error Message: ".$VendorLinkPost['Message']);
			}
		}elseif($Status_Type == "Cancelled"){
			$VendorLinkPut = vendorLinkPut("$VendorLinkURL/SisService/DisciplineIncident", $fields);
			require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
			mysqli_query($db, "UPDATE conduct_discipline SET SIS_Reported = '0', DisciplineIncidentRefId = '' WHERE ID = '$Incident_ID'") or die (mysqli_error($db));
		}elseif($Status_Type == "Open"){
			$VendorLinkPut = vendorLinkPut("$VendorLinkURL/SisService/DisciplineIncident", $fields);
			error_log(json_encode($VendorLinkPut));
		}

		echo "<br><br>";
		print_r($fields);

	}
?>