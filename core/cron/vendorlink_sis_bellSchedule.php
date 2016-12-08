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
	mysqli_query($db, "DELETE FROM VendorLink_BellSchedule WHERE Id>0");
	
	//Get School Information from Database
	$query = "SELECT * FROM VendorLink_Schools";
	$dbreturn = databasequery($query);
	foreach ($dbreturn as $value)
	{
		
		$RefIdSchool=htmlspecialchars($value['RefId'], ENT_QUOTES);
		
		//VendorLink Request
		$VendorLinkURL=sitesettings("sitevendorlinkurl");
		$json=vendorLinkGet("$VendorLinkURL/SisService/BellSchedule?leaOrSchoolInfoRefId=$RefIdSchool");
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
	    	$BellScheduleName=$json['result'][$x]['BellScheduleName'];
	    	$TimetableDay=$json['result'][$x]['TimetableDay']; $TimetableDay=json_encode($TimetableDay);
	    	$TimetablePeriod=$json['result'][$x]['TimetablePeriod']; $TimetablePeriod=json_encode($TimetablePeriod);
	    	$BellPeriod=$json['result'][$x]['BellPeriod']; $BellPeriod=json_encode($BellPeriod);
	    	$SifExtendedElements=$json['result'][$x]['SifExtendedElements']; $SifExtendedElements=json_encode($SifExtendedElements);
			
			//Add to Data to Database
			if($RefId!=NULL)
			{
				mysqli_query($db, "INSERT INTO VendorLink_BellSchedule (RefId,SchoolInfoRefId,SchoolYear,BellScheduleName,TimetableDay,TimetablePeriod,BellPeriod,SifExtendedElements) VALUES ('$RefId','$SchoolInfoRefId','$SchoolYear','$BellScheduleName','$TimetableDay','$TimetablePeriod','$BellPeriod','$SifExtendedElements')");
			}
		}
		

	}
	
	//Confirmation Message
	echo "Update Complete";
	
?>