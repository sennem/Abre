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

	//Find all incidents where not reported and a reportable offense
	$query = "SELECT * FROM conduct_discipline LEFT JOIN conduct_discipline_consequences ON conduct_discipline.ID = conduct_discipline_consequences.Incident_ID WHERE (conduct_discipline_consequences.Consequence_Name LIKE '%Suspension%' OR conduct_discipline_consequences.Consequence_Name LIKE '%Expulsion%') AND conduct_discipline.SIS_Reported = '0'";
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
		$Incident_Consequence = $value["Consequence_Name"];
		$Incident_Served = $value["Consequence_Served"];
		$Incident_Archived = $value["Archived"];
		$Incident_Serve_Date = $value["Serve_Date"];
		$Incident_Thru_Date = $value["Thru_Date"];
		$Incident_Offence_Codes = $value["Offence_Codes"];
		$Incident_Total_Days = $value["Total_Days"];
		$Incident_SIS_Reported = $value["SIS_Reported"];
		
		//NULLS
		$RefId = NULL;
		$IncidentNumber=NULL;
		$LEAInfoRefId=NULL;
		$IncidentAgainstPropertyInd="No";
		$DisciplineIncidentPlaceCodeId=NULL;
		$IncidentComment=NULL;
		$DisciplineIncidentTimeFrameCodeId=NULL;
		$FacilitiesCodeId=NULL;

		//Find RefId of the school
		$SchoolInfoRefId = NULL;
		$querylookup = "SELECT RefId FROM Abre_VendorLink_SIS_Schools WHERE LocalId = '$Incident_SchoolCode' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$SchoolInfoRefId=$valuelookup["RefId"];
		}

		//School Year
		$SchoolYear = "2018";

		//Find Incident Name
		$IncidentName = NULL;
		$IncidentName = substr($Incident_Description, 0, 50);

		//Incident Time
		$IncidentDateTime = NULL;
		$IncidentDateTime = date('Y-m-d\TH:i:s\Z', strtotime($Incident_Submission_Time));
		
		//Incident Building IRN
		$IncidentBuildingIRN = NULL;
		$querylookup = "SELECT StateProvinceId FROM Abre_VendorLink_SIS_Schools WHERE LocalId = '$Incident_SchoolCode' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$IncidentBuildingIRN=$valuelookup["StateProvinceId"];
		}

		//Incident Status Code (from Discipline Table)
		$IncidentStatusTypeCodeId = NULL;
		$querylookup = "SELECT CodeTypes FROM Abre_VendorLink_SIS_DisciplineCodes WHERE SchoolId='$SchoolInfoRefId' LIMIT 1";
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
						if($CodeTypeCodesName == "New"){
							$IncidentStatusTypeCodeId = $json['CodeId'];
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

		//Referrer Type
		$IncidentReferrer_PersonType = NULL;
		$IncidentReferrer_PersonType = "Staff";

		//Incident Categories
		$IncidentCategories_DisciplineIncidentCategoryId = NULL;
		$querylookup = "SELECT CodeTypes FROM Abre_VendorLink_SIS_DisciplineCodes WHERE SchoolId = '$SchoolInfoRefId' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$CodeTypes = $valuelookup["CodeTypes"];
			$CodeTypes = json_decode($CodeTypes, true);

			foreach($CodeTypes as $key => $json){
		    $CodeTypeName = $json['CodeTypeName'];
		    $CodeTypeCodes = $json['Codes'];

		    if($CodeTypeName == "DisciplineIncidentCategory"){
					foreach($CodeTypeCodes as $key => $json){
						$CodeTypeCodesName = $json['Name'];
						if($CodeTypeCodesName == "Bullying"){
							$IncidentCategories_DisciplineIncidentCategoryId = $json['CodeId'];
							$IncidentCategories_DisciplineIncidentCategoryCodeId = $json['CodeId'];
						}
					}
		    }
			}
		}

		//Offender ID
		$Offenders_DisciplineOffenderId = NULL;
		$Offenders_DisciplineOffenderId = $Incident_StudentID;

		//Offender RefId
		$Offenders_DisciplinePersonRefId = NULL;
		$querylookup = "SELECT RefId FROM Abre_VendorLink_SIS_Students where LocalId = '$Incident_StudentID' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$Offenders_DisciplinePersonRefId = $valuelookup["RefId"];
			$Offenders_DisciplineOffenderId = $Offenders_DisciplinePersonRefId;
		}

		//Offender Type
		$Offenders_PersonType = NULL;
		$Offenders_PersonType = "Student";

		//Offender ID's
		$Offenders_DisciplineOffenderInfractionId = NULL;
		$querylookup = "SELECT CodeTypes FROM Abre_VendorLink_SIS_DisciplineCodes where SchoolId = '$SchoolInfoRefId' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$CodeTypes = $valuelookup["CodeTypes"];
			$CodeTypes = json_decode($CodeTypes, true);

			foreach($CodeTypes as $key => $json){
		    $CodeTypeName = $json['CodeTypeName'];
		    $CodeTypeCodes = $json['Codes'];

		    if($CodeTypeName == "DisciplineInfractionType"){
					foreach($CodeTypeCodes as $key => $json){
						$InfractionTypeCode = $json['Code'];
						if(strpos($Incident_Offence_Codes, $InfractionTypeCode) !== false){
							$Offenders_DisciplineOffenderInfractionId = $json['CodeId'];
						}
					}
				}
			}
		}

		//Discipline Action
		$Offenders_DisciplineOffenderDisciplinaryActionId = NULL;
		$Offenders_DisciplineActionCodeId = NULL;
		$querylookup = "SELECT CodeTypes FROM Abre_VendorLink_SIS_DisciplineCodes WHERE SchoolId = '$SchoolInfoRefId' LIMIT 1";
		$dbreturnlookup = databasequery($querylookup);
		foreach($dbreturnlookup as $valuelookup){
			$CodeTypes = $valuelookup["CodeTypes"];
			$CodeTypes = json_decode($CodeTypes, true);

			foreach($CodeTypes as $key => $json){
		    $CodeTypeName = $json['CodeTypeName'];
		    $CodeTypeCodes = $json['Codes'];

		    if($CodeTypeName == "DisciplineAction"){
					foreach($CodeTypeCodes as $key => $json){
						$DisciplineActionName=$json['Name'];
						if(strpos($Incident_Consequence, "Suspension") !== false){ $Incident_Consequence_Short = "Suspension"; }
						if(strpos($Incident_Consequence, "Expulsion") !== false){ $Incident_Consequence_Short = "Expulsion"; }
						if(strpos($DisciplineActionName, $Incident_Consequence_Short) !== false){
							$Offenders_DisciplineOffenderDisciplinaryActionId = $json['CodeId'];
							$Offenders_DisciplineActionCodeId = $json['CodeId'];
						}
					}
		    }
			}
		}

		//Offender StartDate
		$Offenders_StartDate = NULL;
		$Offenders_StartDate = date($Incident_Serve_Date);
		$Offenders_StartDate = date('Y-m-d\TH:i:s\Z', strtotime($Offenders_StartDate));

		//Offender EndDate
		$Offenders_EndDate = NULL;
		$Offenders_EndDate = date($Incident_Thru_Date);
		$Offenders_EndDate = date('Y-m-d\TH:i:s\Z', strtotime($Offenders_EndDate));

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
						}
					}
		    }
			}
		}

		$Offenders_ParentInvolvements = [];
		$Victims_Victims = [];
		$Witnesses_Witnesses = [];

		echo addToSIS(
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
			$IncidentCategories_DisciplineIncidentCategoryId,
			$IncidentCategories_DisciplineIncidentCategoryCodeId,
			$Offenders_DisciplineOffenderId,
			$Offenders_DisciplinePersonRefId,
			$Offenders_PersonType,
			$Offenders_DisciplineOffenderInfractionId,
			$Offenders_DisciplineOffenderDisciplinaryActionId,
			$Offenders_DisciplineActionCodeId,
			$Offenders_StartDate,
			$Offenders_EndDate,
			$Offenders_AltEducationAssigned,
			$Offenders_ParentInvolvements,
			$Victims_Victims,
			$Witnesses_Witnesses
		);

	}
?>