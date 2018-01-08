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
	require('permissions.php');
	require_once('../../core/abre_functions.php');

	//Predict Email
	function emailPrediction($first, $last){
		//Construct Email Address
		$firstfirstchar = $first[0];
		$firstsecondchar = $first[1];
		$firstthirdchar = $first[2];
		$predictedemail = $firstfirstchar.$last.SITE_GAFE_DOMAIN;
		$predictedemail = strtolower($predictedemail);
		$predictedemailencrypted = encrypt($predictedemail, "");

		//Check to make sure email doesn't already exist
		include "../../configuration.php";
		include "../../core/abre_dbconnect.php";
		$sql = "SELECT *  FROM directory WHERE email = '$predictedemailencrypted'";
		$result = $db->query($sql);
		$count = mysqli_num_rows($result);

		if($count == 1){
			$firstsecondchar = $first[1];
			$predictedemail = $firstfirstchar.$firstsecondchar.$last.SITE_GAFE_DOMAIN;
			$predictedemail = strtolower($predictedemail);

			//Check again
			$count=0;
			$predictedemailencrypted = encrypt($predictedemail, "");
			include "../../configuration.php";
			include "../../core/abre_dbconnect.php";
			$sql = "SELECT *  FROM directory WHERE email = '$predictedemailencrypted'";
			$result = $db->query($sql);
			$count = mysqli_num_rows($result);

			if($count == 1){
				$predictedemail = $firstfirstchar.$firstsecondchar.$firstthirdchar.$last.SITE_GAFE_DOMAIN;
				$predictedemail = strtolower($predictedemail);
				sendSupportTicket($first, $last, $predictedemail);
				return $predictedemail;
			}else{
				sendSupportTicket($first, $last, $predictedemail);
				return $predictedemail;
			}
		}else{
			sendSupportTicket($first, $last, $predictedemail);
			return $predictedemail;
		}
	}

	function sendSupportTicket($first, $last, $predictedemail){
		//Send the VarTek Ticket to have account created.
		include "../../core/abre_dbconnect.php";
		$sql = "SELECT * FROM directory_settings where dropdownID = 'supportTicket'";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc()){
			$email = $row["options"];
		}

		if($email != ''){
			//$to = "helpdesk@vartek.com";
			$to = $email;
			$subject = "New User Account Needed for $first $last";
			$message = "Please create a new user account for:\n\n$first $last ($predictedemail).";
			$headers = "From: web@hcsdoh.org";
			mail($to, $subject, $message, $headers);
		}
	}

?>