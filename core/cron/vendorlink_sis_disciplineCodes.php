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
	mysqli_query($db, "DELETE FROM VendorLink_DisciplineCodes WHERE Id>0");
	
	//Get School Information from Database
	$query = "SELECT * FROM VendorLink_Schools";
	$dbreturn = databasequery($query);
	foreach ($dbreturn as $value)
	{
		
		$RefIdSchool=htmlspecialchars($value['RefId'], ENT_QUOTES);
		
		//VendorLink Request
		$VendorLinkURL=sitesettings("sitevendorlinkurl");
		$json=vendorLinkGet("$VendorLinkURL/SisService/DisciplineCodes?leaOrSchoolInfoRefId=$RefIdSchool");
		$json=json_encode($json);
		$json=json_decode($json,true);
		$count=$json['count'];

		
		//Insert Returned Data
		for ($x = 0; $x <= $count; $x++)
		{
			//Get Returned Data
	    	$SchoolId=$json['result'][$x]['SchoolId'];
	    	$SchoolYear=$json['result'][$x]['SchoolYear'];
	    	$CodeTypes=$json['result'][$x]['CodeTypes']; $CodeTypes=json_encode($CodeTypes);
	    	$EMISCodeTypes=$json['result'][$x]['EMISCodeTypes']; $EMISCodeTypes=json_encode($EMISCodeTypes);
			
			mysqli_query($db, "INSERT INTO VendorLink_DisciplineCodes (SchoolId,SchoolYear,CodeTypes,EMISCodeTypes) VALUES ('$SchoolId','$SchoolYear','$CodeTypes','$EMISCodeTypes')");

		}
		

	}
	
	//Confirmation Message
	echo "Update Complete";
	
?>