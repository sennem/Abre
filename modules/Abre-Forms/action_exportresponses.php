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
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once("functions.php");

	if($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator())
	{

		//Get GET Data
		if(isset($_GET["formid"])){
      $formId = htmlspecialchars($_GET["formid"], ENT_QUOTES);
    }else{
      $formId = "";
    }

		if($formId == ""){
      echo "There was an error retrieving the form ID. Please try again!";
		}else{

			$sql = "SELECT Name, FormFields FROM forms WHERE ID = '$formId'";
			$row = $db->query($sql);
			$value = $row->fetch_assoc();
			$formName = $value['Name'];
			$formFields = json_decode($value['FormFields'], true);

      header('Content-Type: text/csv; charset=utf-8');
			$filename = $formName.".csv";
      header('Content-Disposition: attachment; filename='.$filename);

      $output = fopen('php://output', 'w');

      $headerArray = array("Submission Time", "First Name", "Last Name", "Email", "Role", "ID");

      $sql = "SELECT * FROM forms_responses WHERE FormID = '$formId'";
      $rows = $db->query($sql);
      $headerRow = true;
      while($result = $rows->fetch_assoc()){

        $responses = json_decode($result['Response'], true);
        $submissionTime = $result['SubmissionTime'];
        $firstName = $result['FirstName'];
        $lastName = $result['LastName'];
        $email = $result['Submitter'];
        $id = $result['UniqueID'];
        $role = $result['UserType'];

        if($headerRow){
          foreach($formFields as $response){
						if($response["type"] == "text" || $response["type"] == "textarea" || $response["type"] == "select" || $response["type"] == "radio-group" || $response["type"] == "checkbox-group"){
							array_push($headerArray, $response['label']);
						}
          }
          fputcsv($output, $headerArray);
          $headerRow = false;
        }

        $exportRow = array($submissionTime, $firstName, $lastName, $email, $role, $id);

				foreach($formFields as $response){
					if($response["type"] == "text" || $response["type"] == "textarea" || $response["type"] == "select" || $response["type"] == "radio-group" || $response["type"] == "checkbox-group"){
						if($response["type"] == "checkbox-group"){
							$id = $response['name']."[]";
						}else{
							$id = $response['name'];
						}
						$return = "";
						$answer = "";

						if(isset($responses[$id])){
							$answer = $responses[$id];
						}
						if(gettype($answer) == "array"){
							$return = implode(", ", $answer);
						}else{
							$return = $answer;
						}
						array_push($exportRow, $return);
					}
				}
				fputcsv($output, $exportRow);
      }
		}

    fclose($output);
    $db->close();
	}
?>