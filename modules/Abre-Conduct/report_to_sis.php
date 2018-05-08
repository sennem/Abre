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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');

	//Get POST Variable
	$POST_Incident_ID = $_POST['Incident_ID'];
	$POST_Status_Type = $_POST["Status_Type"];

	if($POST_Status_Type == "New"){

		$IncidentNumber = NULL;
		$LEAInfoRefId = NULL;
		$IncidentAgainstPropertyInd = "No";
		$DisciplineIncidentPlaceCodeId = NULL;
		$IncidentComment = NULL;
		$DisciplineIncidentTimeFrameCodeId = NULL;
		$FacilitiesCodeId = NULL;

		//School Year
		$SchoolYear = "2018";

		//Referrer Type
		$IncidentReferrer_PersonType = NULL;
		$IncidentReferrer_PersonType = "Staff";

		//Incident Categories
		$IncidentCategories_DisciplineIncidentCategoryId = NULL;
		$IncidentCategories_DisciplineIncidentCategoryCodeId = NULL;

		//Offender Type
		$Offenders_PersonType = NULL;
		$Offenders_PersonType = "Student";

		$Offenders_ParentInvolvements = [];
		$Victims_Victims = [];
		$Witnesses_Witnesses = [];

		//Find all incidents where not reported and a reportable offense
		$query = "SELECT ID, Submission_Time, Incident_Date, Incident_Time, Owner, Owner_Name, Building, SchoolCode, Type, StudentID, Student_IEP, Student_FirstName, Student_MiddleName, Student_LastName, Offence, Location, Description, Information, Archived, Offence_Codes, SIS_Reported, DisciplineIncidentRefId FROM conduct_discipline WHERE ID = '$POST_Incident_ID' AND Type = 'Office' LIMIT 1";
		$dbreturn = databasequery($query);
		foreach($dbreturn as $value){
			$Incident_ID = $value["ID"];
			$Incident_Submission_Time = $value["Submission_Time"];
			$Incident_Incident_Date = $value["Incident_Date"];
			$Incident_Incident_Time = $value["Incident_Time"];
			$Incident_Owner = $value["Owner"];
			$Incident_Owner_Name = $value["Owner_Name"];
			$Incident_Building = $value["Building"];
			$Incident_SchoolCode = $value["SchoolCode"];
			$Incident_Type = $value["Type"];
			$Incident_StudentID = $value["StudentID"];
			$Incident_Student_IEP = $value["Student_IEP"];
			$Incident_Student_FirstName = $value["Student_FirstName"];
			$Incident_Student_MiddleName = $value["Student_MiddleName"];
			$Incident_Student_LastName = $value["Student_LastName"];
			$Incident_Offence = $value["Offence"];
			$Incident_Location = $value["Location"];
			$Incident_Description = $value["Description"];
			$Incident_Information = $value["Information"];
			$Incident_Archived = $value["Archived"];
			$Incident_Offence_Codes = $value["Offence_Codes"];
			$Incident_SIS_Reported = $value["SIS_Reported"];
			$DisciplineIncidentRefId = $value["DisciplineIncidentRefId"];
		}

		//NULLS
		$RefId = NULL;

		//Find Incident Name
		$IncidentName = NULL;
		$IncidentName = substr($Incident_Description, 0, 50);

		$Incident_Description = substr($Incident_Description, 0, 1900);

		//Incident Time
		$IncidentDateTime = NULL;
		$IncidentDateTime = date('Y-m-d\TH:i:s\Z', strtotime($Incident_Submission_Time));

		//Find RefId of the school
		$SchoolInfoRefId = NULL;
		$querylookup = "SELECT RefId FROM Abre_VendorLink_SIS_Schools WHERE LocalId = '$Incident_SchoolCode' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$SchoolInfoRefId = $valuelookup["RefId"];
		}

		//EMIS Alternate Program
		$Offenders_AltEducationAssigned = NULL;
		$querylookup = "SELECT EMISCodeTypes FROM Abre_VendorLink_SIS_DisciplineCodes WHERE SchoolId = '$SchoolInfoRefId' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach ($dbreturnlookup as $valuelookup){
			$CodeTypes = $valuelookup["EMISCodeTypes"];
			$CodeTypes = json_decode($CodeTypes, true);

			foreach($CodeTypes as $key => $json){
				$CodeTypeName = $json['CodeTypeName'];
				$CodeTypeCodes = $json['Codes'];

				if($CodeTypeName == "AlternateProgram"){
					foreach($CodeTypeCodes as $key => $json){
						$CodeTypeCodesName = $json['Description'];
						if($CodeTypeCodesName == "Not Applicable"){
							$Offenders_AltEducationAssigned = $json['Value'];
							break;
						}
					}
				}
			}
		}

		$querylookup = "SELECT CodeTypes FROM Abre_VendorLink_SIS_DisciplineCodes WHERE SchoolId = '$SchoolInfoRefId' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$CodeTypes = $valuelookup["CodeTypes"];
			$CodeTypes = json_decode($CodeTypes, true);
		}

		//Incident Building IRN
		$IncidentBuildingIRN = NULL;
		$querylookup = "SELECT StateProvinceId FROM Abre_VendorLink_SIS_Schools WHERE LocalId = '$Incident_SchoolCode' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$IncidentBuildingIRN = $valuelookup["StateProvinceId"];
		}

		$query2 = "SELECT Consequence_Served, Consequence_Name, Total_Days, Serve_Date, Thru_Date FROM conduct_discipline_consequences WHERE Incident_ID = '$POST_Incident_ID' AND (Consequence_Name = 'Suspension - OSS' OR Consequence_Name = 'Expulsion')";
		$dbreturn2 = databasequery($query2);
		$numResults = sizeof($dbreturn2);
		$Offenders_DisciplinaryActionsArray = array();
		$numServed = 0;
		foreach($dbreturn2 as $value2){
			$hasServedInd = "No";
			if($value2["Consequence_Served"] == 1){
				$hasServedInd = "Yes";
				$numServed++;
			}
			foreach($CodeTypes as $key => $json){
				$CodeTypeName = $json['CodeTypeName'];
				$CodeTypeCodes = $json['Codes'];

				if($CodeTypeName == "DisciplineAction"){
					if(strpos($value2["Consequence_Name"], "Suspension") !== false){ $Incident_Consequence_Short = "Suspension"; }
					if(strpos($value2["Consequence_Name"], "Expulsion") !== false){ $Incident_Consequence_Short = "Expulsion"; }
					foreach($CodeTypeCodes as $key => $json){
						$DisciplineActionName = $json['Name'];
						if(strpos($DisciplineActionName, $Incident_Consequence_Short) !== false){
							$Offenders_DisciplineActionCodeId = $json['CodeId'];
							break;
						}
					}
				}
			}
			array_push($Offenders_DisciplinaryActionsArray, ["DisciplineOffenderDisciplinaryActionId" => NULL, "DisciplineActionCodeId" => $Offenders_DisciplineActionCodeId, "DisciplinaryActionDuration" => $value2["Total_Days"], "StartDate" => $value2["Serve_Date"], "EndDate" => $value2["Thru_Date"], "HasServedInd" => $hasServedInd, "AltEducationAssigned" => $Offenders_AltEducationAssigned]);
		}

		//Incident Status Code (from Discipline Table)
		$IncidentStatusTypeCodeId = NULL;
		$querylookup = "SELECT CodeTypes FROM Abre_VendorLink_SIS_DisciplineCodes WHERE SchoolId = '$SchoolInfoRefId' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$CodeTypes = $valuelookup["CodeTypes"];
			$CodeTypes = json_decode($CodeTypes, true);

			foreach($CodeTypes as $key => $json){
				$CodeTypeName = $json['CodeTypeName'];
				$CodeTypeCodes = $json['Codes'];

				if($CodeTypeName == "IncidentStatusType"){
					foreach($CodeTypeCodes as $key => $json){
						$CodeTypeCodesName = $json['Name'];
						if($CodeTypeCodesName == $POST_Status_Type){
							$IncidentStatusTypeCodeId = $json['CodeId'];
							break;
						}
					}
				}
			}
		}

		//Referrer RefId
		$IncidentReferrer_DisciplinePersonRefId = NULL;
		$querylookup = "SELECT RefId FROM Abre_VendorLink_SIS_Staff WHERE EmailList LIKE '%$Incident_Owner%' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$IncidentReferrer_DisciplinePersonRefId = $valuelookup["RefId"];
		}

		//Offender ID
		$Offenders_DisciplineOffenderId = NULL;

		//Offender RefId
		$Offenders_DisciplinePersonRefId = NULL;
		$querylookup = "SELECT RefId FROM Abre_VendorLink_SIS_Students WHERE LocalId = '$Incident_StudentID' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$Offenders_DisciplinePersonRefId = $valuelookup["RefId"];
		}

		$Offender_InfractionArray = array();
		$querylookup = "SELECT CodeTypes FROM Abre_VendorLink_SIS_DisciplineCodes WHERE SchoolId = '$SchoolInfoRefId' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$CodeTypes = $valuelookup["CodeTypes"];
			$CodeTypes = json_decode($CodeTypes, true);

			foreach($CodeTypes as $key => $json){
				$CodeTypeName = $json['CodeTypeName'];
				$CodeTypeCodes = $json['Codes'];

				if($CodeTypeName == "DisciplineInfractionType"){
					$OffenceCodesArray = explode(",", $Incident_Offence_Codes);
					foreach($OffenceCodesArray as $codeToFind){
						foreach($CodeTypeCodes as $key => $json){
							$InfractionTypeCode = $json['Code'];
							if((float)$codeToFind == (float)$InfractionTypeCode){
								array_push($Offender_InfractionArray, ["DisciplineOffenderInfractionId" => NULL, "DisciplineInfractionTypeCodeId" => $json['CodeId']]);
								break;
							}
						}
					}
				}
			}
		}

	}elseif($POST_Status_Type == "Update"){

		$POST_Status_Type = "Open";
		$query = "SELECT ID, Submission_Time, Incident_Date, Incident_Time, Owner, Owner_Name, Building, SchoolCode, Type, StudentID, Student_IEP, Student_FirstName, Student_MiddleName, Student_LastName, Offence, Location, Description, Information, Archived, Offence_Codes, SIS_Reported, DisciplineIncidentRefId FROM conduct_discipline WHERE ID = '$POST_Incident_ID' AND Type = 'Office' LIMIT 1";
		$dbreturn = databasequery($query);
		foreach($dbreturn as $value){
			$Incident_ID = $value["ID"];
			$Incident_Submission_Time = $value["Submission_Time"];
			$Incident_Incident_Date = $value["Incident_Date"];
			$Incident_Incident_Time = $value["Incident_Time"];
			$Incident_Owner = $value["Owner"];
			$Incident_Owner_Name = $value["Owner_Name"];
			$Incident_Building = $value["Building"];
			$Incident_SchoolCode = $value["SchoolCode"];
			$Incident_Type = $value["Type"];
			$Incident_StudentID = $value["StudentID"];
			$Incident_Student_IEP = $value["Student_IEP"];
			$Incident_Student_FirstName = $value["Student_FirstName"];
			$Incident_Student_MiddleName = $value["Student_MiddleName"];
			$Incident_Student_LastName = $value["Student_LastName"];
			$Incident_Offence = $value["Offence"];
			$Incident_Location = $value["Location"];
			$Incident_Description = $value["Description"];
			$Incident_Information = $value["Information"];
			$Incident_Archived = $value["Archived"];
			$Incident_Offence_Codes = $value["Offence_Codes"];
			$Incident_SIS_Reported = $value["SIS_Reported"];
			$DisciplineIncidentRefId = $value["DisciplineIncidentRefId"];
		}

		$RefId = $DisciplineIncidentRefId;

		$IncidentName = NULL;
		$IncidentName = substr($Incident_Description, 0, 50);

		$Incident_Description = substr($Incident_Description, 0, 1900);

		$Offenders_ParentInvolvements = [];
		$Victims_Victims = [];
		$Witnesses_Witnesses = [];

		$Offenders_DisciplinePersonRefId = NULL;
		$querylookup = "SELECT RefId FROM Abre_VendorLink_SIS_Students where LocalId = '$Incident_StudentID' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$Offenders_DisciplinePersonRefId = $valuelookup["RefId"];
		}

		$VendorLinkURL = getSoftwareAnswersURL();
		$VendorLinkGet = vendorLinkGet("$VendorLinkURL/SisService/DisciplineIncident?studentPersonalRefId=$Offenders_DisciplinePersonRefId");
		foreach($VendorLinkGet["result"] as $array){
			if($array["RefId"] == $DisciplineIncidentRefId){
				$SchoolInfoRefId = $array["SchoolInfoRefId"];
				$SchoolYear = $array["SchoolYear"];
				$IncidentNumber = $array["IncidentNumber"];
				$IncidentDateTime = $array["IncidentDateTime"];
				$LEAInfoRefId = $array["LEAInfoRefId"];
				$IncidentBuildingIRN = $array["IncidentBuildingIRN"];
				$IncidentAgainstPropertyInd = $array["IncidentAgainstPropertyInd"];
				$DisciplineIncidentPlaceCodeId = $array["DisciplineIncidentPlaceCodeId"];
				$DisciplineIncidentTimeFrameCodeId = $array["DisciplineIncidentTimeFrameCodeId"];
				$FacilitiesCodeId = $array["FacilitiesCodeId"];
				$IncidentComment = $array["IncidentComment"];
				$IncidentReferrer_PersonType = $array["IncidentReferrer"]["PersonType"];
				$Offenders_DisciplineOffenderId = $array["Offenders"][0]["DisciplineOffenderId"];
				$Offenders_PersonType = $array["Offenders"][0]["PersonType"];

				//EMIS Alternate Program
				$schoolId = str_replace("-", "", $SchoolInfoRefId);
				$Offenders_AltEducationAssigned = NULL;
				$querylookup = "SELECT EMISCodeTypes FROM Abre_VendorLink_SIS_DisciplineCodes WHERE SchoolId = '$schoolId' LIMIT 1";
				$dbreturnlookup = databasequery($querylookup);
				foreach ($dbreturnlookup as $valuelookup){
					$CodeTypes = $valuelookup["EMISCodeTypes"];
					$CodeTypes = json_decode($CodeTypes, true);

					foreach($CodeTypes as $key => $json){
						$CodeTypeName = $json['CodeTypeName'];
						$CodeTypeCodes = $json['Codes'];

						if($CodeTypeName == "AlternateProgram"){
							foreach($CodeTypeCodes as $key => $json){
								$CodeTypeCodesName = $json['Description'];
								if($CodeTypeCodesName == "Not Applicable"){
									$Offenders_AltEducationAssigned = $json['Value'];
									break;
								}
							}
						}
					}
				}

				$querylookup = "SELECT CodeTypes FROM Abre_VendorLink_SIS_DisciplineCodes WHERE SchoolId = '$schoolId' LIMIT 1";
				$dbreturnlookup = databasequery($querylookup);
				foreach($dbreturnlookup as $valuelookup){
					$CodeTypes = $valuelookup["CodeTypes"];
					$CodeTypes = json_decode($CodeTypes, true);
				}

				$query2 = "SELECT Consequence_Served, Consequence_Name, Total_Days, Serve_Date, Thru_Date FROM conduct_discipline_consequences WHERE Incident_ID = '$POST_Incident_ID' AND (Consequence_Name = 'Suspension - OSS' OR Consequence_Name = 'Expulsion')";
				$dbreturn2 = databasequery($query2);
				$numResults = sizeof($dbreturn2);
				$newDisciplinaryActionArray = array();
				$numServed = 0;
				foreach($dbreturn2 as $value2){
					$hasServedInd = "No";
					if($value2["Consequence_Served"] == 1){
						$hasServedInd = "Yes";
						$numServed++;
					}
					foreach($CodeTypes as $key => $json){
						$CodeTypeName = $json['CodeTypeName'];
						$CodeTypeCodes = $json['Codes'];

						if($CodeTypeName == "DisciplineAction"){
							if(strpos($value2["Consequence_Name"], "Suspension") !== false){ $Incident_Consequence_Short = "Suspension"; }
							if(strpos($value2["Consequence_Name"], "Expulsion") !== false){ $Incident_Consequence_Short = "Expulsion"; }
							foreach($CodeTypeCodes as $key => $json){
								$DisciplineActionName = $json['Name'];
								if(strpos($DisciplineActionName, $Incident_Consequence_Short) !== false){
									$Offenders_DisciplineActionCodeId = $json['CodeId'];
									break;
								}
							}
						}
					}
					array_push($newDisciplinaryActionArray, ["DisciplineOffenderDisciplinaryActionId" => NULL, "DisciplineActionCodeId" => $Offenders_DisciplineActionCodeId, "DisciplinaryActionDuration" => $value2["Total_Days"], "StartDate" => $value2["Serve_Date"], "EndDate" => $value2["Thru_Date"], "HasServedInd" => $hasServedInd, "AltEducationAssigned" => $Offenders_AltEducationAssigned]);
				}

				$Offenders_DisciplinaryActionsArray = array();
				if(sizeof($newDisciplinaryActionArray) == sizeof($array["Offenders"][0]["DisciplinaryActions"])){
					for($i = 0; $i < sizeof($newDisciplinaryActionArray); $i++){
						$array["Offenders"][0]["DisciplinaryActions"][$i]["DisciplineActionCodeId"] = $newDisciplinaryActionArray[$i]["DisciplineActionCodeId"];
						$array["Offenders"][0]["DisciplinaryActions"][$i]["DisciplinaryActionDuration"] = $newDisciplinaryActionArray[$i]["DisciplinaryActionDuration"];
						$array["Offenders"][0]["DisciplinaryActions"][$i]["StartDate"] = $newDisciplinaryActionArray[$i]["StartDate"];
						$array["Offenders"][0]["DisciplinaryActions"][$i]["EndDate"] = $newDisciplinaryActionArray[$i]["EndDate"];
						$array["Offenders"][0]["DisciplinaryActions"][$i]["HasServedInd"] = $newDisciplinaryActionArray[$i]["HasServedInd"];

						array_push($Offenders_DisciplinaryActionsArray, $array["Offenders"][0]["DisciplinaryActions"][$i]);
					}
				}elseif(sizeof($newDisciplinaryActionArray) > sizeof($array["Offenders"][0]["DisciplinaryActions"])){
					for($i = 0; $i < sizeof($newDisciplinaryActionArray); $i++){
						if(isset($array["Offenders"][0]["DisciplinaryActions"][$i])){
							$array["Offenders"][0]["DisciplinaryActions"][$i]["DisciplineActionCodeId"] = $newDisciplinaryActionArray[$i]["DisciplineActionCodeId"];
							$array["Offenders"][0]["DisciplinaryActions"][$i]["DisciplinaryActionDuration"] = $newDisciplinaryActionArray[$i]["DisciplinaryActionDuration"];
							$array["Offenders"][0]["DisciplinaryActions"][$i]["StartDate"] = $newDisciplinaryActionArray[$i]["StartDate"];
							$array["Offenders"][0]["DisciplinaryActions"][$i]["EndDate"] = $newDisciplinaryActionArray[$i]["EndDate"];
							$array["Offenders"][0]["DisciplinaryActions"][$i]["HasServedInd"] = $newDisciplinaryActionArray[$i]["HasServedInd"];

							array_push($Offenders_DisciplinaryActionsArray, $array["Offenders"][0]["DisciplinaryActions"][$i]);
						}else{
							array_push($Offenders_DisciplinaryActionsArray, $newDisciplinaryActionArray[$i]);
						}
					}
				}else{
					for($i = 0; $i < sizeOf($array["Offenders"][0]["DisciplinaryActions"]); $i++){
						if(isset($newDisciplinaryActionArray[$i])){
							$array["Offenders"][0]["DisciplinaryActions"][$i]["DisciplineActionCodeId"] = $newDisciplinaryActionArray[$i]["DisciplineActionCodeId"];
							$array["Offenders"][0]["DisciplinaryActions"][$i]["DisciplinaryActionDuration"] = $newDisciplinaryActionArray[$i]["DisciplinaryActionDuration"];
							$array["Offenders"][0]["DisciplinaryActions"][$i]["StartDate"] = $newDisciplinaryActionArray[$i]["StartDate"];
							$array["Offenders"][0]["DisciplinaryActions"][$i]["EndDate"] = $newDisciplinaryActionArray[$i]["EndDate"];
							$array["Offenders"][0]["DisciplinaryActions"][$i]["HasServedInd"] = $newDisciplinaryActionArray[$i]["HasServedInd"];

							array_push($Offenders_DisciplinaryActionsArray, $array["Offenders"][0]["DisciplinaryActions"][$i]);
						}
					}
				}

				//Offender ID's
				$newInfractionArray = array();
				$querylookup = "SELECT CodeTypes FROM Abre_VendorLink_SIS_DisciplineCodes WHERE SchoolId = '$schoolId' LIMIT 1";
				$dbreturnlookup = databasequery($querylookup);
				foreach($dbreturnlookup as $valuelookup){
					$CodeTypes = $valuelookup["CodeTypes"];
					$CodeTypes = json_decode($CodeTypes, true);

					foreach($CodeTypes as $key => $json){
						$CodeTypeName = $json['CodeTypeName'];
						$CodeTypeCodes = $json['Codes'];

						if($CodeTypeName == "DisciplineInfractionType"){
							$OffenceCodesArray = explode(",", $Incident_Offence_Codes);
							foreach($OffenceCodesArray as $codeToFind){
								foreach($CodeTypeCodes as $key => $json){
									$InfractionTypeCode = $json['Code'];
									if((float)$codeToFind == (float)$InfractionTypeCode){
										array_push($newInfractionArray, $json['CodeId']);
										break;
									}
								}
							}
						}
					}
				}

				$Offender_InfractionArray = array();
				if(sizeof($newInfractionArray) == sizeof($array["Offenders"][0]["Infractions"])){
					for($i = 0; $i < sizeof($newInfractionArray); $i++){
						$array["Offenders"][0]["Infractions"][$i]["DisciplineInfractionTypeCodeId"] = $newInfractionArray[$i];
						array_push($Offender_InfractionArray, $array["Offenders"][0]["Infractions"][$i]);
					}
				}elseif(sizeof($newInfractionArray) > sizeof($array["Offenders"][0]["Infractions"])){
					for($i = 0; $i < sizeof($newInfractionArray); $i++){
						if(isset($array["Offenders"][0]["Infractions"][$i])){
							$array["Offenders"][0]["Infractions"][$i]["DisciplineInfractionTypeCodeId"] = $newInfractionArray[$i];
							array_push($Offender_InfractionArray, $array["Offenders"][0]["Infractions"][$i]);
						}else{
							array_push($Offender_InfractionArray, ["DisciplineOffenderInfractionId" => NULL, "DisciplineInfractionTypeCodeId" => $newInfractionArray[$i]]);
						}
					}
				}else{
					for($i = 0; $i < sizeOf($array["Offenders"][0]["Infractions"]); $i++){
						if(isset($newInfractionArray[$i])){
							$array["Offenders"][0]["Infractions"][$i]["DisciplineInfractionTypeCodeId"] = $newInfractionArray[$i];
							array_push($Offender_InfractionArray, $array["Offenders"][0]["Infractions"][$i]);
						}
					}
				}

				if($Incident_Archived == 1 || $numResults == 0){
					$POST_Status_Type = "Cancelled";
				}
				$IncidentStatusTypeCodeId = NULL;
				$querylookup = "SELECT CodeTypes FROM Abre_VendorLink_SIS_DisciplineCodes WHERE SchoolId='$schoolId' LIMIT 1";
				$dbreturnlookup = databasequery($querylookup);
				foreach($dbreturnlookup as $valuelookup){
					$CodeTypes = $valuelookup["CodeTypes"];
					$CodeTypes = json_decode($CodeTypes, true);

					foreach($CodeTypes as $key => $json){
						$CodeTypeName = $json['CodeTypeName'];
						$CodeTypeCodes = $json['Codes'];

						if($CodeTypeName == "IncidentStatusType"){
							foreach($CodeTypeCodes as $key => $json){
								$CodeTypeCodesName = $json['Name'];
								if($CodeTypeCodesName == $POST_Status_Type){
									$IncidentStatusTypeCodeId = $json['CodeId'];
									break;
								}
							}
						}
					}
				}

				$IncidentReferrer_DisciplinePersonRefId = NULL;
				$querylookup = "SELECT RefId FROM Abre_VendorLink_SIS_Staff WHERE EmailList LIKE '%$Incident_Owner%' LIMIT 1";
				$dbreturnlookup = databasequery($querylookup);
				foreach($dbreturnlookup as $valuelookup){
					$IncidentReferrer_DisciplinePersonRefId = $valuelookup["RefId"];
				}

				break;
			}
		}
	}

	addToSIS(
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
		$POST_Status_Type
	);
?>