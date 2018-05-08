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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once("functions.php");

	//Update system settings
	if($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator())
	{

		//Retrieve settings and group as json
		if(isset($_POST['limit'])){ $limit = $_POST['limit']; }else{ $limit = ""; }
		if(isset($_POST['template'])){ $template = $_POST['template']; }else{ $template = ""; }
		if(isset($_POST['public'])){ $public = $_POST['public']; }else{ $public = ""; }
		if(isset($_POST['plan'])){ $plan = $_POST['plan']; }else{ $plan = ""; }
		if(isset($_POST['restrictions'])){ $restrictions = $_POST["restrictions"]; }else{ $restrictions = array(); }
		if(isset($_POST['confirmation'])){ $confirmation = $_POST["confirmation"]; }else{ $confirmation = ""; }
		if(isset($_POST['formid'])){ $formid = $_POST["formid"]; }else{ $formid = ""; }
		if(isset($_POST['formEmailNotifications'])){ $formNotifications = $_POST['formEmailNotifications']; }else{ $formNotifications = ""; }
		if(isset($_POST['editors'])){ $editors = $_POST['editors']; }else{ $editors = ""; }
		if(isset($_POST['responseAccess'])){ $responseAccess = $_POST['responseAccess']; }else{ $responseAccess = ""; }

		//Restriction Multiselect Save
		$restrictionsoptions = "";
		foreach($restrictions as $value){
			$restrictionsoptions = "$restrictionsoptions $value, ";
		}
	  $restrictionsoptions = rtrim($restrictionsoptions, ', ');
	  $restrictionsoptions = ltrim($restrictionsoptions, ' ,');

		$array = [
			"limit" => "$limit",
			"template" => "$template",
			"public" => "$public",
			"plan" => "$plan",
			"restrictions" => "$restrictionsoptions",
			"confirmation" => "$confirmation",
			"emailNotifications" => "$formNotifications"
		];
		$json = json_encode($array);

		if($public == "checked"){ $publicvalue = 1; }else{ $publicvalue = 0; }
		if($template == "checked"){ $templatevalue = 1; }else{ $templatevalue = 0; }
		if($plan == "checked"){ $planvalue = 1; }else{ $planvalue = 0; }

		$stmt = $db->stmt_init();
		$sql = "UPDATE forms SET Settings = ?, Template = ?, Public = ?, Plan = ?, Restrictions = ?, Editors = ?, ResponseAccess = ? WHERE id = ?";
		$stmt->prepare($sql);
		$stmt->bind_param("siiisssi", $json, $templatevalue, $publicvalue, $planvalue, $restrictionsoptions, $editors, $responseAccess, $formid);
		$stmt->execute();
		$stmt->close();
		$db->close();

		//Notification message
		echo "Form settings have been updated.";
	}

?>
