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

	$VendorLinkURL=sitesettings("sitevendorlinkurl");
	$json=vendorLinkGet("$VendorLinkURL/SisService/District");
	$json=json_encode($json);
	$json=json_decode($json,true);
	
	//Get Returned Data
	$RefId=$json['result'][0]['RefId'];
	$LocalId=$json['result'][0]['LocalId'];
	$StateProvinceId=$json['result'][0]['StateProvinceId'];
	$LeaName=$json['result'][0]['LeaName'];

	//Clear Existing Database Data
	mysqli_query($db, "DELETE FROM VendorLink_District WHERE Id>0");
	
	//Add to Data to Database
	mysqli_query($db, "INSERT INTO VendorLink_District (RefId,LocalId,StateProvinceId,LeaName) VALUES ('$RefId','$LocalId','$StateProvinceId','$LeaName')");
	
	//Confirmation Message
	echo "Update Complete";
	
?>