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
	require_once('permissions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	if(admin()){

		//connect to the database
		include "../../core/abre_dbconnect.php";

		$stmt = $db->stmt_init();
		$sql = "INSERT INTO directory (firstname,lastname,middlename,title,contract,address,city,state,zip,email,phone,extension,cellphone,ss,dob,gender,ethnicity,classification,location,grade,subject,doh,senioritydate,effectivedate,rategroup,step,educationlevel,salary,hours,stateeducatorid,licensetype1,licenseissuedate1,licenseexpirationdate1,licenseterm1,licensetype2,licenseissuedate2,licenseexpirationdate2,licenseterm2,licensetype3,licenseissuedate3,licenseexpirationdate3,licenseterm3,licensetype4,licenseissuedate4,licenseexpirationdate4,licenseterm4,licensetype5,licenseissuedate5,licenseexpirationdate5,licenseterm5,licensetype6,licenseissuedate6,licenseexpirationdate6,licenseterm6,probationreportdate,statebackgroundcheck,federalbackgroundcheck,permissions,contractdays,RefID,StateID,TeacherID,LocalId,role) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt->prepare($sql);

		$dupFound = 0;
		//Upload and Process CSV File
		if($_FILES['file']['tmp_name']){
			$handle = fopen($_FILES['file']['tmp_name'], "r");
			$counter = 0;
			while(($data = fgetcsv($handle, 0, ",")) !== FALSE){
				if($counter > 0){
					$email = "";
					$email = $data[9];
					$duplicateCheck = "SELECT COUNT(*) FROM directory WHERE email = '$email' LIMIT 1";
					$query = $db->query($duplicateCheck);
					$row = $query->fetch_assoc();
					$count = $row['COUNT(*)'];
					if($email == "" || $count != 0){
						$dupFound = 1;
						continue;
					}
					$firstname = $data[0];
					$lastname = $data[1];
					$middlename = $data[2];
					$title = $data[3];
					$contract = $data[4];
					$contract = encrypt($contract, "");
					$address = $data[5];
					$address = encrypt($address, "");
					$city = $data[6];
					$city = encrypt($city, "");
					$state = $data[7];
					$state = encrypt($state, "");
					$zip = $data[8];
					$zip = encrypt($zip, "");
					$phone = $data[10];
					$phone = encrypt($phone, "");
					$extension = $data[11];
					$cellphone = $data[12];
					$cellphone = encrypt($cellphone, "");
					$ss = $data[13];
					$ss = encrypt($ss, "");
					$dob = $data[14];
					$dob = encrypt($dob, "");
					$gender = $data[15];
					$gender = encrypt($gender, "");
					$ethnicity = $data[16];
					$ethnicity = encrypt($ethnicity, "");
					$classification = $data[17];
					$location = $data[18];
					$grade = $data[19];
					$subject = $data[20];
					$doh = $data[21];
					$doh = encrypt($doh, "");
					$senioritydate = $data[22];
					$senioritydate = encrypt($senioritydate, "");
					$effectivedate = $data[23];
					$effectivedate = encrypt($effectivedate, "");
					$rategroup = $data[24];
					$rategroup = encrypt($rategroup, "");
					$step = $data[25];
					$step = encrypt($step, "");
					$educationlevel = $data[26];
					$educationlevel = encrypt($educationlevel, "");
					$salary = $data[27];
					$salary = encrypt($salary, "");
					$hours = $data[28];
					$hours = encrypt($hours, "");
					$contractDays = $data[29];
					$contractDays = encrypt($contractDays, "");
					$stateeducatorid = $data[30];
					$stateeducatorid = encrypt($stateeducatorid, "");
					$l1_1 = $data[31];
					$l1_1 = encrypt($l1_1, "");
					$l1_2 = $data[32];
					$l1_2 = encrypt($l1_2, "");
					$l1_3 = $data[33];
					$l1_3 = encrypt($l1_3, "");
					$l1_4 = $data[34];
					$l1_4 = encrypt($l1_4, "");
					$l2_1 = $data[35];
					$l2_1 = encrypt($l2_1, "");
					$l2_2 = $data[36];
					$l2_2 = encrypt($l2_2, "");
					$l2_3 = $data[37];
					$l2_3 = encrypt($l2_3, "");
					$l2_4 = $data[38];
					$l2_4 = encrypt($l2_4, "");
					$l3_1 = $data[39];
					$l3_1 = encrypt($l3_1, "");
					$l3_2 = $data[40];
					$l3_2 = encrypt($l3_2, "");
					$l3_3 = $data[41];
					$l3_3 = encrypt($l3_3, "");
					$l3_4 = $data[42];
					$l3_4 = encrypt($l3_4, "");
					$l4_1 = $data[43];
					$l4_1 = encrypt($l4_1, "");
					$l4_2 = $data[44];
					$l4_2 = encrypt($l4_2, "");
					$l4_3 = $data[45];
					$l4_3 = encrypt($l4_3, "");
					$l4_4 = $data[46];
					$l4_4 = encrypt($l4_4, "");
					$l5_1 = $data[47];
					$l5_1 = encrypt($l5_1, "");
					$l5_2 = $data[48];
					$l5_2 = encrypt($l5_2, "");
					$l5_3 = $data[49];
					$l5_3 = encrypt($l5_3, "");
					$l5_4 = $data[50];
					$l5_4 = encrypt($l5_4, "");
					$l6_1 = $data[51];
					$l6_1 = encrypt($l6_1, "");
					$l6_2 = $data[52];
					$l6_2 = encrypt($l6_2, "");
					$l6_3 = $data[53];
					$l6_3 = encrypt($l6_3, "");
					$l6_4 = $data[54];
					$l6_4 = encrypt($l6_4, "");
					$probationreportdate = $data[55];
					$probationreportdate = encrypt($probationreportdate, "");
					$statebackgroundcheck = $data[56];
					$statebackgroundcheck = encrypt($statebackgroundcheck, "");
					$federalbackgroundcheck = $data[57];
					$federalbackgroundcheck = encrypt($federalbackgroundcheck, "");

					$emptyString = encrypt("", "");

					$stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss", $firstname, $lastname, $middlename, $title, $contract, $address, $city, $state, $zip, $email, $phone, $extension, $cellphone, $ss, $dob, $gender, $ethnicity, $classification, $location, $grade, $subject, $doh, $senioritydate, $effectivedate, $rategroup, $step, $educationlevel, $salary, $hours, $stateeducatorid, $l1_1, $l1_2, $l1_3, $l1_4, $l2_1, $l2_2, $l2_3, $l2_4, $l3_1, $l3_2, $l3_3, $l3_4, $l4_1, $l4_2, $l4_3, $l4_4, $l5_1, $l5_2, $l5_3, $l5_4, $l6_1, $l6_2, $l6_3, $l6_4, $probationreportdate, $statebackgroundcheck, $federalbackgroundcheck, $emptyString, $contractDays, $emptyString, $emptyString, $emptyString, $emptyString, $emptyString);
					$stmt->execute();
				}
				$counter++;
			}
			fclose($handle);
			$stmt->close();
			$db->close();

			//Response Message
			if($dupFound == 1){
				echo "Import complete. One or more entries were not added due to unlisted or conflicting email!";
			}else{
				echo "Import complete!";
			}
		}else{
			echo "No file was chosen.";
		}
	}
?>