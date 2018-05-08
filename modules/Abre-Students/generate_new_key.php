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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');
	require_once('permissions.php');

	if(admin())
	{

		$studentid=$_POST["studentid"];
		$token=$_POST["token"];

		//Delete Entries of Old Key
		$stmt = $db->stmt_init();
		$sql = "DELETE FROM parent_students WHERE student_token='$token'";
		$stmt->prepare($sql);
		$stmt->execute();
		$stmt->store_result();
		$stmt->close();

		//Update Student Tokens with New Key
		$stringToken = $studentid . time();
	  $tokenencrypted = encrypt(substr(hash('sha256', $stringToken), 0, 10), "");

		if($token == ""){
			$stmt = $db->stmt_init();
			$sql = "INSERT INTO student_tokens (studentId, token) VALUES (?, ?)";
			$stmt->prepare($sql);
			$stmt->bind_param("is", $studentid, $tokenencrypted);
			$stmt->execute();
			$stmt->close();
		}else{
			$stmt = $db->stmt_init();
			$sql = "UPDATE student_tokens SET token = ? WHERE studentId = ?";
			$stmt->prepare($sql);
			$stmt->bind_param("si", $tokenencrypted, $studentid);
			$stmt->execute();
			$stmt->close();
		}
		$db->close();
	}
?>