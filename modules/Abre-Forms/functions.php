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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	function getFormsSettingsDbValue($value, $formid){
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql2 = "SELECT Settings FROM forms WHERE ID = '$formid'";
		$result2 = $db->query($sql2);
		$row = $result2->fetch_assoc();
		$options = $row["Settings"];
		if($options != ""){
			$options = json_decode($options);
			if(isset($options->$value)){
				$valuereturn = $options->$value;
			}else{
				$valuereturn = "";
			}
		}else{
			$valuereturn = "";
		}
		$db->close();
		return $valuereturn;
	}

	function getFormsSettingsLimitUsers($formid){
		$valuereturn = getFormsSettingsDbValue('restrictions', $formid);
		if($valuereturn == ""){ $valuereturn = ""; }
		return $valuereturn;
	}

	function getFormsSettingsConfirmation($formid){
		$valuereturn = getFormsSettingsDbValue('confirmation', $formid);
		if($valuereturn == ""){ $valuereturn = ""; }
		return $valuereturn;
	}

	function getFormsSettingsLimit($formid){
		$valuereturn = getFormsSettingsDbValue('limit', $formid);
		if($valuereturn == ""){ $valuereturn = "unchecked"; }
		return $valuereturn;
	}

	function getFormsSettingsTemplate($formid){
		$valuereturn = getFormsSettingsDbValue('template', $formid);
		if($valuereturn == ""){ $valuereturn = "unchecked"; }
		return $valuereturn;
	}

	function getFormsSettingsPublic($formid){
		$valuereturn = getFormsSettingsDbValue('public', $formid);
		if($valuereturn == ""){ $valuereturn = "unchecked"; }
		return $valuereturn;
	}

	function getFormsSettingsPlan($formid){
		$valuereturn = getFormsSettingsDbValue('plan', $formid);
		if($valuereturn == ""){ $valuereturn = "unchecked"; }
		return $valuereturn;
	}

	function getFormsSettingsNotifications($formid){
		$valuereturn = getFormsSettingsDbValue('emailNotifications', $formid);
		if($valuereturn == ""){ $valuereturn = "unchecked"; }
		return $valuereturn;
	}

	function getFormEditors($formid){
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql = "SELECT Editors FROM forms WHERE ID = '$formid'";
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$editors = $row["Editors"];
		return $editors;
	}

	function getFormResponseAccess($formid){
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql = "SELECT responseAccess FROM forms WHERE ID = '$formid'";
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$sharedResponses = $row["responseAccess"];
		return $sharedResponses;
	}

	function isFormsAdministrator(){
		//Check to see if they have the Conduct Administrator Role
		$email = $_SESSION['useremail'];
		$sql = "SELECT role FROM directory WHERE email = '$email'";
		$dbreturn = databasequery($sql);
		foreach ($dbreturn as $value){
			$role = decrypt($value["role"], "");
			if(strpos($role, 'Forms Administrator') !== false) {
				return true;
			}
		}
		return false;
	}

	function isOwner($formid){
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql2 = "SELECT Owner FROM forms WHERE ID = '$formid'";
		$result2 = $db->query($sql2);
		$row = $result2->fetch_assoc();
		$owner = $row["Owner"];
		if($owner == $_SESSION['useremail']){
			return true;
		}
	}

	function hasEditAccess($formid){
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql2 = "SELECT COUNT(*) FROM forms WHERE ID = '$formid' AND (Owner = '".$_SESSION['useremail']."' OR Editors LIKE '%".$_SESSION['useremail']."%')";
		$result2 = $db->query($sql2);
		$row = $result2->fetch_assoc();
		$returnCount = $row["COUNT(*)"];
		if($returnCount == 1){
			return true;
		}else{
			return false;
		}
	}

	function hasResponseAccess($formid){
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql2 = "SELECT COUNT(*) FROM forms WHERE ID = '$formid' AND ResponseAccess LIKE '%".$_SESSION['useremail']."%'";
		$result2 = $db->query($sql2);
		$row = $result2->fetch_assoc();
		$returnCount = $row["COUNT(*)"];
		if($returnCount == 1){
			return true;
		}else{
			return false;
		}
	}

	function getResponseCount($id){
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql = "SELECT COUNT(*) FROM forms_responses WHERE FormID = $id";
		$query = $db->query($sql);
		$row = $query->fetch_assoc();
		$count = $row['COUNT(*)'];
		$db->close();
		return $count;
	}

?>