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
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once("functions.php");

	if($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator())
	{

		//Get POST Data
		if(isset($_POST["formid"])){ $formid = $_POST["formid"]; }else{ $formid=""; }
		if(isset($_POST["formfields"])){
			$formfields = $_POST["formfields"];
			$formArray = json_decode($formfields, true);
			if(count($formArray) != 0){
				$names = array();
				foreach($formArray as $question){
					array_push($names, $question["name"]);
				}
				if(count($names) != count(array_unique($names))){
					$response = array("status" => "Error", "message" => "Multiple questions cannot have the same name. Please review your questions and try saving again!");
					header("Content-Type: application/json");
					echo json_encode($response);
					exit;
				}
			}
		}else{
			$formfields = "";
		}
		if(isset($_POST["formname"])){ $formname = $_POST["formname"]; }else{ $formname=""; }

		//Add or update the course
		if($formid==""){

			//Create session key
			$timedate=time();
			$string=$timedate.$_SESSION['useremail'];
			$sessionid=sha1($string);

			$formname = "Untitled Form";
			$owner = $_SESSION['useremail'];
			$stmt = $db->stmt_init();
			$sql = "INSERT INTO forms (Owner, Name, Session) VALUES (?, ?, ?);";
			$stmt->prepare($sql);
			$stmt->bind_param("sss", $owner, $formname, $sessionid);
			$stmt->execute();
			$formid = $stmt->insert_id;
			$stmt->close();

		}
		else
		{
			$isReordered = $_POST["reorder"];
			if(!$isReordered){
				$sql = "SELECT FormFields FROM forms WHERE ID = '$formid'";
				$query = $db->query($sql);
				$row = $query->fetch_assoc();
				$oldFormFields = $row['FormFields'];

				$oldFormFieldsArray = json_decode($oldFormFields, true);
				$newFormFieldsArray = json_decode($formfields, true);

				//array containing key value pairs. The key is the newname of the question field
				//the value is the old name of the question field.
				$nameMap = array();

				$i = 0;
				foreach($newFormFieldsArray as $question){
					if($question["type"] == "text" || $question["type"] == "textarea" || $question["type"] == "select" || $question["type"] == "radio-group" || $question["type"] == "checkbox-group"){
						if(!isset($oldFormFieldsArray[$i])){
							break;
						}elseif($question['name'] != $oldFormFieldsArray[$i]['name']){
							$nameMap[$question['name']] = $oldFormFieldsArray[$i]['name'];
						}
					}
					$i++;
				}

				$sql = "SELECT Response, ID FROM forms_responses WHERE FormID = '$formid'";
				$query = $db->query($sql);

				$stmt = $db->stmt_init();
				$sql = "UPDATE forms_responses SET Response = ? WHERE ID = ?";
				$stmt->prepare($sql);

				while($row = $query->fetch_assoc()){
					$changeMade = 0;
					$responseArray = json_decode($row['Response'], true);
					foreach($nameMap as $key=>$value){
						if($value == ""){
							continue;
						}elseif(array_key_exists($value, $responseArray)){
							$responseArray[$key] = $responseArray[$value];
							unset($responseArray[$value]);
							$changeMade = 1;
						}
					}
					if($changeMade == 1){
						$responseJSON = json_encode($responseArray);
						$responseid = $row['ID'];
						$stmt->bind_param("si", $responseJSON, $responseid);
						$stmt->execute();
					}
				}
				$stmt->close();
			}

			$stmt = $db->stmt_init();
			$sql = "UPDATE forms SET FormFields = ?, Name = ? WHERE ID = ?";
			$stmt->prepare($sql);
			$stmt->bind_param("ssi", $formfields, $formname, $formid);
			$stmt->execute();
			$stmt->close();
		}

		$db->close();
		//Return
		echo json_encode(array("formid"=>$formid));

	}

?>