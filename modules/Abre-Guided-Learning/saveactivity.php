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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

  if(isset($_POST["history"])){
    $historyJSON = $_POST["history"];
  }
  if(isset($_POST["studentemail"])){
    $studentEmail = $_POST["studentemail"];
  }
  if(isset($_POST["active"])){
    $active = $_POST["active"];
  }
  if(isset($_POST["code"])){
    $code = $_POST["code"];
  }
	if(isset($_POST["type"])){
		$type = $_POST["type"];
	}

  $sql = "SELECT COUNT(*) FROM guide_activity WHERE student_email = '$studentEmail' AND activity_code = '$code'";
  $result = $db->query($sql);
	$resultrow = $result->fetch_assoc();
	$num_results = $resultrow["COUNT(*)"];
  if($num_results == 1){
		date_default_timezone_set('EST');
		$currenttimestamp = date("Y-m-d H:i:s");

		if($type == "start"){
			$historyJSON = json_encode(array());
			$endtime = "000-00-00 00:00:00";
			$stmt = $db->stmt_init();
			$sql = "UPDATE guide_activity SET start_time = ?, active = ?, history = ?, end_time = ? WHERE activity_code = ? AND student_email = ?";
			$stmt->prepare($sql);
			$stmt->bind_param("sissss", $currenttimestamp, $active, $historyJSON, $endtime, $code, $studentEmail);
			$stmt->execute();
			$stmt->close();
		}elseif($type == "end"){
			$stmt = $db->stmt_init();
			$sql = "UPDATE guide_activity SET history = ?, end_time = ?, active = ? WHERE activity_code = ? AND student_email = ?";
			$stmt->prepare($sql);
			$stmt->bind_param("ssiss", $historyJSON, $currenttimestamp, $active, $code, $studentEmail);
			$stmt->execute();
			$stmt->close();
		}else{
			//update info here
			$stmt = $db->stmt_init();
			$sql = "UPDATE guide_activity SET history = ?, active = ? WHERE activity_code = ? AND student_email = ?";
			$stmt->prepare($sql);
			$stmt->bind_param("siss", $historyJSON, $active, $code, $studentEmail);
			$stmt->execute();
			$stmt->close();
		}
  }else{
		$historyJSON = json_encode(array());
    //insert new entry here
		$stmt = $db->stmt_init();
		$sql = "INSERT INTO guide_activity (student_email, activity_code, history, active) VALUES (?, ?, ?, ?)";
		$stmt->prepare($sql);
		$stmt->bind_param("sssi", $studentEmail, $code, $historyJSON, $active);
		$stmt->execute();
		$stmt->close();
  }
	$db->close();
?>