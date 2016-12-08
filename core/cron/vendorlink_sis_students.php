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
	mysqli_query($db, "DELETE FROM VendorLink_Students WHERE Id>0");
	
	//Get School Information from Database
	$query = "SELECT * FROM VendorLink_Schools";
	$dbreturn = databasequery($query);
	foreach ($dbreturn as $value)
	{
		
		$RefIdSchool=htmlspecialchars($value['RefId'], ENT_QUOTES);
		
		//VendorLink Request
		$VendorLinkURL=sitesettings("sitevendorlinkurl");
		$json=vendorLinkGet("$VendorLinkURL/SisService/StudentPersonal?schoolInfoRefId=$RefIdSchool");
		$json=json_encode($json);
		$json=json_decode($json,true);
		$count=$json['count'];

		//Insert Returned Data
		for ($x = 0; $x <= $count; $x++)
		{
			//Get Returned Data
	    	$RefId=$json['result'][$x]['RefId'];
	    	$AlertMessages=$json['result'][$x]['AlertMessages']; $AlertMessages=json_encode($AlertMessages);
	    	$MedicalAlertMessages=$json['result'][$x]['MedicalAlertMessages']; $MedicalAlertMessages=json_encode($MedicalAlertMessages);
	    	$LocalId=$json['result'][$x]['LocalId'];
	    	$StateProvinceId=$json['result'][$x]['StateProvinceId'];
	    	$LastName=$json['result'][$x]['Name']['LastName'];
	    	$FirstName=$json['result'][$x]['Name']['FirstName'];
	    	$MiddleName=$json['result'][$x]['Name']['MiddleName'];
	    	$HispanicLatino=$json['result'][$x]['Demographics']['HispanicLatino'];
	    	$Gender=$json['result'][$x]['Demographics']['Gender'];
	    	$BirthDate=$json['result'][$x]['Demographics']['BirthDate'];
	    	$PlaceOfBirth=$json['result'][$x]['Demographics']['PlaceOfBirth'];
	    	$CountryOfBirth=$json['result'][$x]['Demographics']['CountryOfBirth'];
	    	$CitizenshipStatus=$json['result'][$x]['Demographics']['CitizenshipStatus'];
	    	$EnglishProficiency=$json['result'][$x]['Demographics']['EnglishProficiency']; $EnglishProficiency=json_encode($EnglishProficiency);
	    	$LanguageList=$json['result'][$x]['Demographics']['LanguageList']; $LanguageList=json_encode($LanguageList);
	    	$AddressList=$json['result'][$x]['AddressList']; $AddressList=json_encode($AddressList);
	    	$PhoneNumberList=$json['result'][$x]['PhoneNumberList']; $PhoneNumberList=json_encode($PhoneNumberList);
	    	$EmailList=$json['result'][$x]['EmailList']; $EmailList=json_encode($EmailList);
	    	$ProjectedGraduationYear=$json['result'][$x]['ProjectedGraduationYear'];
	    	$OnTimeGraduationYear=$json['result'][$x]['OnTimeGraduationYear'];
	    	$IDEA=$json['result'][$x]['IDEA'];
	    	$Migrant=$json['result'][$x]['Migrant'];
	    	$EconomicDisadvantage=$json['result'][$x]['EconomicDisadvantage'];
	    	$Homeless=$json['result'][$x]['Homeless'];
	    	$Section504=$json['result'][$x]['Section504'];
	    	$SifExtendedElements=$json['result'][$x]['SifExtendedElements']; $SifExtendedElements=json_encode($SifExtendedElements); 	
	    	$SnapshotSchoolLocalId=$json['result'][$x]['SnapshotSchoolLocalId'];
			
			//Add to Data to Database
			if($RefId!=NULL)
			{
				mysqli_query($db, "INSERT INTO VendorLink_Students (RefId,AlertMessages,MedicalAlertMessages,LocalId,StateProvinceId,LastName,FirstName,MiddleName,HispanicLatino,Gender,BirthDate,PlaceOfBirth,CountryOfBirth,CitizenshipStatus,EnglishProficiency,LanguageList,AddressList,PhoneNumberList,EmailList,ProjectedGraduationYear,OnTimeGraduationYear,IDEA,Migrant,EconomicDisadvantage,Homeless,Section504,SifExtendedElements,SnapshotSchoolLocalId) VALUES ('$RefId','$AlertMessages','$MedicalAlertMessages','$LocalId','$StateProvinceId','$LastName','$FirstName','$MiddleName','$HispanicLatino','$Gender','$BirthDate','$PlaceOfBirth','$CountryOfBirth','$CitizenshipStatus','$EnglishProficiency','$LanguageList','$AddressList','$PhoneNumberList','$EmailList','$ProjectedGraduationYear','$OnTimeGraduationYear','$IDEA','$Migrant','$EconomicDisadvantage','$Homeless','$Section504','$SifExtendedElements','$SnapshotSchoolLocalId')");
			}
		}

	}
	
	//Confirmation Message
	echo "Update Complete";
	
?>