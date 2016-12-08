<?php
	
	/*
	* Copyright 2015 Hamilton City School District	
	* 		
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	* 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	* 
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */
	
	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php'); 
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	require(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	
	//Clear Existing Database Data
	mysqli_query($db, "DELETE FROM VendorLink_Discipline WHERE Id>0");
	
	//Get School Information from Database
	$query = "SELECT * FROM VendorLink_Schools";
	$dbreturn = databasequery($query);
	foreach ($dbreturn as $value)
	{
		
		$RefIdSchool=htmlspecialchars($value['RefId'], ENT_QUOTES);
		
		//VendorLink Request
		$VendorLinkURL=sitesettings("sitevendorlinkurl");
		$json=vendorLinkGet("$VendorLinkURL/SisService/DisciplineIncident?leaOrSchoolInfoRefId=$RefIdSchool");
		$json=json_encode($json);
		$json=json_decode($json,true);
		$count=$json['count'];

		//Insert Returned Data
		for ($x = 0; $x <= $count; $x++)
		{
			//Get Returned Data
	    	$RefId=$json['result'][$x]['RefId'];
	    	$SchoolInfoRefId=$json['result'][$x]['SchoolInfoRefId'];
	    	$SchoolYear=$json['result'][$x]['SchoolYear'];
	    	$IncidentNumber=$json['result'][$x]['IncidentNumber'];
	    	$IncidentName=$json['result'][$x]['IncidentName'];
	    	$Description=$json['result'][$x]['Description'];
	    	$IncidentDateTime=$json['result'][$x]['IncidentDateTime'];
	    	$LEAInfoRefId=$json['result'][$x]['LEAInfoRefId'];
	    	$IncidentBuildingIRN=$json['result'][$x]['IncidentBuildingIRN'];
	    	$IncidentAgainstPropertyInd=$json['result'][$x]['IncidentAgainstPropertyInd'];
	    	$DisciplineIncidentPlaceCodeId=$json['result'][$x]['DisciplineIncidentPlaceCodeId'];
	    	$DisciplineIncidentTimeFrameCodeId=$json['result'][$x]['DisciplineIncidentTimeFrameCodeId'];
	    	$FacilitiesCodeId=$json['result'][$x]['FacilitiesCodeId'];
	    	$IncidentStatusTypeCodeId=$json['result'][$x]['IncidentStatusTypeCodeId'];
	    	$IncidentComment=$json['result'][$x]['IncidentComment'];
	    	$IncidentReferrer=$json['result'][$x]['IncidentReferrer'];
	    	$IncidentCategories=$json['result'][$x]['IncidentCategories']; $IncidentCategories=json_encode($IncidentCategories);
	    	$Offenders=$json['result'][$x]['Offenders']; $Offenders=json_encode($Offenders);
	    	$Victims=$json['result'][$x]['Victims']; $Victims=json_encode($Victims);
	    	$Witnesses=$json['result'][$x]['Witnesses']; $Witnesses=json_encode($Witnesses);
			
			//Add to Data to Database
			if($RefId!=NULL)
			{
				mysqli_query($db, "INSERT INTO VendorLink_Discipline (RefId,SchoolInfoRefId,SchoolYear,IncidentNumber,IncidentName,Description,IncidentDateTime,LEAInfoRefId,IncidentBuildingIRN,IncidentAgainstPropertyInd,DisciplineIncidentPlaceCodeId,DisciplineIncidentTimeFrameCodeId,FacilitiesCodeId,IncidentStatusTypeCodeId,IncidentComment,IncidentReferrer,IncidentCategories,Offenders,Victims,Witnesses) VALUES ('$RefId','$SchoolInfoRefId','$SchoolYear','$IncidentNumber','$IncidentName','$Description','$IncidentDateTime','$LEAInfoRefId','$IncidentBuildingIRN','$IncidentAgainstPropertyInd','$DisciplineIncidentPlaceCodeId','$DisciplineIncidentTimeFrameCodeId','$FacilitiesCodeId','$IncidentStatusTypeCodeId','$IncidentComment','$IncidentReferrer','$IncidentCategories','$Offenders','$Victims','$Witnesses')");
			}
		}

	}
	
	//Confirmation Message
	echo "Update Complete";
	
?>