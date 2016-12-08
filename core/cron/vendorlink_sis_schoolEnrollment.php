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
	mysqli_query($db, "DELETE FROM VendorLink_SchoolEnrollment WHERE Id>0");
	
	//Get School Information from Database
	$query = "SELECT * FROM VendorLink_Schools";
	$dbreturn = databasequery($query);
	foreach ($dbreturn as $value)
	{
		
		$RefIdSchool=htmlspecialchars($value['RefId'], ENT_QUOTES);
		
		//VendorLink Request
		$VendorLinkURL=sitesettings("sitevendorlinkurl");
		$json=vendorLinkGet("$VendorLinkURL/SisService/SchoolEnrollment?leaOrSchoolInfoRefId=$RefIdSchool");
		$json=json_encode($json);
		$json=json_decode($json,true);
		$count=$json['count'];

		
		//Insert Returned Data
		for ($x = 0; $x <= $count; $x++)
		{
			//Get Returned Data
	    	$RefId=$json['result'][$x]['RefId'];
	    	$StudentPersonalRefId=$json['result'][$x]['StudentPersonalRefId'];
	    	$SchoolInfoRefId=$json['result'][$x]['SchoolInfoRefId'];
	    	$MembershipType=$json['result'][$x]['MembershipType'];
	    	$TimeFrame=$json['result'][$x]['TimeFrame'];
	    	$SchoolYear=$json['result'][$x]['SchoolYear'];
	    	$EntryDate=$json['result'][$x]['EntryDate'];
	    	$EntryType=$json['result'][$x]['EntryType']; $EntryType=json_encode($EntryType);
	    	$GradeLevel=$json['result'][$x]['GradeLevel']; $GradeLevel=json_encode($GradeLevel);
	    	$Homeroom=$json['result'][$x]['Homeroom']; $Homeroom=json_encode($Homeroom);
	    	$Counselor=$json['result'][$x]['Counselor']; $Counselor=json_encode($Counselor);
	    	$ExitDate=$json['result'][$x]['ExitDate'];
	    	$ExitType=$json['result'][$x]['ExitType']; $ExitType=json_encode($ExitType);
	    	$Fte=$json['result'][$x]['Fte'];
	    	$FtptStatus=$json['result'][$x]['FtptStatus'];
			
			//Add to Data to Database
			if($RefId!=NULL)
			{
				mysqli_query($db, "INSERT INTO VendorLink_SchoolEnrollment (RefId,StudentPersonalRefId,SchoolInfoRefId,MembershipType,TimeFrame,SchoolYear,EntryDate,EntryType,GradeLevel,Homeroom,Counselor,ExitDate,ExitType,Fte,FtptStatus) VALUES ('$RefId','$StudentPersonalRefId','$SchoolInfoRefId','$MembershipType','$TimeFrame','$SchoolYear','$EntryDate','$EntryType','$GradeLevel','$Homeroom','$Counselor','$ExitDate','$ExitType','$Fte','$FtptStatus')");
			}
		}
		

	}
	
	//Confirmation Message
	echo "Update Complete";
	
?>