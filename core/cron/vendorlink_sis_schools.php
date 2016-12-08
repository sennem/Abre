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
	
	//Get District Information from Database
	$query = "SELECT * FROM VendorLink_District";
	$dbreturn = databasequery($query);
	foreach ($dbreturn as $value) {
		$RefId=htmlspecialchars($value ['RefId'], ENT_QUOTES);
	}

	//VendorLink Request
	$VendorLinkURL=sitesettings("sitevendorlinkurl");
	$json=vendorLinkGet("$VendorLinkURL/SisService/SchoolInfo?leaOrSchoolInfoRefId=$RefId");
	$json=json_encode($json);
	$json=json_decode($json,true);
	
	//Get Returned Data
	$count=$json['count'];
	
	//Clear Existing Database Data
	mysqli_query($db, "DELETE FROM VendorLink_Schools WHERE Id>0");
	
	//Insert Returned Data
	for ($x = 0; $x <= $count; $x++)
	{
		//Get Returned Data
    	$RefId=$json['result'][$x]['RefId'];
    	$LocalId=$json['result'][$x]['LocalId'];
    	$StateProvinceId=$json['result'][$x]['StateProvinceId'];
    	$SchoolName=$json['result'][$x]['SchoolName'];
    	$LeaInfoRefId=$json['result'][$x]['LeaInfoRefId'];
    	$PrincipalContactName=$json['result'][$x]['PrincipalInfo']['ContactName'];
    	$Street=$json['result'][$x]['Address'][0]['Street']['Line1'];
    	$City=$json['result'][$x]['Address'][0]['City'];
    	$State=$json['result'][$x]['Address'][0]['StateProvince'];
    	$Country=$json['result'][$x]['Address'][0]['Country'];
    	$PostalCode=$json['result'][$x]['Address'][0]['PostalCode'];
		
		//Add to Data to Database
		if($RefId!=NULL)
		{
			mysqli_query($db, "INSERT INTO VendorLink_Schools (RefId,LocalId,StateProvinceId,SchoolName,LeaInfoRefId,PrincipalContactName,Street,City,State,Country,PostalCode) VALUES ('$RefId','$LocalId','$StateProvinceId','$SchoolName','$LeaInfoRefId','$PrincipalContactName','$Street','$City','$State','$Country','$PostalCode')");
		}
	}
	
	//Confirmation Message
	echo "Update Complete";
	
?>