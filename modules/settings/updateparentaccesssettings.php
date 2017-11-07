<?php

	/*
	* Copyright (C) 2016-2017 Abre.io LLC
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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');

	//Update system settings
	if(superadmin()){
		
		//Retrieve settings and group as json
		if(isset($_POST['parentaccess'])){ $siteparentaccess=$_POST['parentaccess']; }else{ $siteparentaccess=""; }
		$sitegoogleclientid = $_POST["googleclientid"];
		if($_POST["googleclientsecret"] != ""){
			$sitegoogleclientsecret = encrypt($_POST["googleclientsecret"], '');
		}else{
			$sitegoogleclientsecret="";
		}
		$sitefacebookclientid = $_POST["facebookclientid"];
		if($_POST["facebookclientsecret"] != ""){
			$sitefacebookclientsecret = encrypt($_POST["facebookclientsecret"], '');
		}else{
			$sitefacebookclientsecret="";
		}
		$sitemicrosoftclientid = $_POST["microsoftclientid"];
		if($_POST["microsoftclientsecret"] != ""){
			$sitemicrosoftclientsecret = encrypt($_POST["microsoftclientsecret"], '');
		}else{
			$sitemicrosoftclientsecret="";
		}

		$array = [ 
					"parentaccess" => "$siteparentaccess",
					"googleclientid" => "$sitegoogleclientid",
					"googleclientsecret" => "$sitegoogleclientsecret",
					"facebookclientid" => "$sitefacebookclientid",
					"facebookclientsecret" => "$sitefacebookclientsecret",
					"microsoftclientid" => "$sitemicrosoftclientid",
					"microsoftclientsecret" => "$sitemicrosoftclientsecret"
				];
		$json = json_encode($array);

		$stmt = $db->stmt_init();
		$sql = "UPDATE settings SET parentaccess=?";
		$stmt->prepare($sql);
		$stmt->bind_param("s", $json);
		$stmt->execute();
		$stmt->close();
		$db->close();

		//Notification message
		echo "Parent Access have been updated.";
	}

?>
