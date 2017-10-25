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
	require_once('permissions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	if(superadmin()){

		//connect to the database
		include "../../core/abre_dbconnect.php";

		//Upload and Process CSV File
		if($_FILES['file']['tmp_name']){
			$handle = fopen($_FILES['file']['tmp_name'], "r");
			$counter = 0;
			while(($data = fgetcsv($handle, 5000, ",")) !== FALSE){
				if($counter > 0){
					$firstname = $data[0];
					$firstname = encrypt($firstname, "");
					$lastname = $data[1];
					$lastname = encrypt($lastname, "");
					$middlename = $data[2];
					$middlename = encrypt($middlename, "");
					$title = $data[3];
					$title = encrypt($title, "");
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
					$email = $data[9];
					$email = encrypt($email, "");
					$phone = $data[10];
					$phone = encrypt($phone, "");
					$cellphone = $data[11];
					$cellphone = encrypt($cellphone, "");
					$ss = $data[12];
					$ss = encrypt($ss, "");
					$dob = $data[13];
					$dob = encrypt($dob, "");
					$gender = $data[14];
					$gender = encrypt($gender, "");
					$ethnicity = $data[15];
					$ethnicity = encrypt($ethnicity, "");
					$classification = $data[16];
					$classification = encrypt($classification, "");
					$location = $data[17];
					$location = encrypt($location, "");
					$grade = $data[18];
					$grade = encrypt($grade, "");
					$subject = $data[19];
					$subject = encrypt($subject, "");
					$doh = $data[20];
					$doh = encrypt($doh, "");
					$senioritydate = $data[21];
					$senioritydate = encrypt($senioritydate, "");
					$effectivedate = $data[22];
					$effectivedate = encrypt($effectivedate, "");
					$rategroup = $data[23];
					$rategroup = encrypt($rategroup, "");
					$step = $data[24];
					$step = encrypt($step, "");
					$educationlevel = $data[25];
					$educationlevel = encrypt($educationlevel, "");
					$salary = $data[26];
					$salary = encrypt($salary, "");
					$hours = $data[27];
					$hours = encrypt($hours, "");
					$stateeducatorid = $data[28];
					$stateeducatorid = encrypt($stateeducatorid, "");
					$l1_1 = $data[29];
					$l1_1 = encrypt($l1_1, "");
					$l1_2 = $data[30];
					$l1_2 = encrypt($l1_2, "");
					$l1_3 = $data[31];
					$l1_3 = encrypt($l1_3, "");
					$l1_4 = $data[32];
					$l1_4 = encrypt($l1_4, "");
					$l2_1 = $data[33];
					$l2_1 = encrypt($l2_1, "");
					$l2_2 = $data[34];
					$l2_2 = encrypt($l2_2, "");
					$l2_3 = $data[35];
					$l2_3 = encrypt($l2_3, "");
					$l2_4 = $data[36];
					$l2_4 = encrypt($l2_4, "");
					$l3_1 = $data[37];
					$l3_1 = encrypt($l3_1, "");
					$l3_2 = $data[38];
					$l3_2 = encrypt($l3_2, "");
					$l3_3 = $data[39];
					$l3_3 = encrypt($l3_3, "");
					$l3_4 = $data[40];
					$l3_4 = encrypt($l3_4, "");
					$l4_1 = $data[41];
					$l4_1 = encrypt($l4_1, "");
					$l4_2 = $data[42];
					$l4_2 = encrypt($l4_2, "");
					$l4_3 = $data[43];
					$l4_3 = encrypt($l4_3, "");
					$l4_4 = $data[44];
					$l4_4 = encrypt($l4_4, "");
					$l5_1 = $data[45];
					$l5_1 = encrypt($l5_1, "");
					$l5_2 = $data[46];
					$l5_2 = encrypt($l5_2, "");
					$l5_3 = $data[47];
					$l5_3 = encrypt($l5_3, "");
					$l5_4 = $data[48];
					$l5_4 = encrypt($l5_4, "");
					$l6_1 = $data[49];
					$l6_1 = encrypt($l6_1, "");
					$l6_2 = $data[50];
					$l6_2 = encrypt($l6_2, "");
					$l6_3 = $data[51];
					$l6_3 = encrypt($l6_3, "");
					$l6_4 = $data[52];
					$l6_4 = encrypt($l6_4, "");
					$probationreportdate = $data[53];
					$probationreportdate = encrypt($probationreportdate, "");
					$statebackgroundcheck = $data[54];
					$statebackgroundcheck = encrypt($statebackgroundcheck, "");
					$federalbackgroundcheck = $data[55];
					$federalbackgroundcheck = encrypt($federalbackgroundcheck, "");
					$stmt = $db->stmt_init();
					$sql = "INSERT into directory (firstname,lastname,middlename,title,contract,address,city,state,zip,email,phone,cellphone,ss,dob,gender,ethnicity,classification,location,grade,subject,doh,senioritydate,effectivedate,rategroup,step,educationlevel,salary,hours,stateeducatorid,licensetype1,licenseissuedate1,licenseexpirationdate1,licenseterm1,licensetype2,licenseissuedate2,licenseexpirationdate2,licenseterm2,licensetype3,licenseissuedate3,licenseexpirationdate3,licenseterm3,licensetype4,licenseissuedate4,licenseexpirationdate4,licenseterm4,licensetype5,licenseissuedate5,licenseexpirationdate5,licenseterm5,licensetype6,licenseissuedate6,licenseexpirationdate6,licenseterm6,probationreportdate,statebackgroundcheck,federalbackgroundcheck) VALUES ('$firstname','$lastname','$middlename','$title','$contract','$address','$city','$state','$zip','$email','$phone','$cellphone','$ss','$dob','$gender','$ethnicity','$classification','$location','$grade','$subject','$doh','$senioritydate','$effectivedate','$rategroup','$step','$educationlevel','$salary','$hours','$stateeducatorid','$l1_1','$l1_2','$l1_3','$l1_4','$l2_1','$l2_2','$l2_3','$l2_4','$l3_1','$l3_2','$l3_3','$l3_4','$l4_1','$l4_2','$l4_3','$l4_4','$l5_1','$l5_2','$l5_3','$l5_4','$l6_1','$l6_2','$l6_3','$l6_4','$probationreportdate','$statebackgroundcheck','$federalbackgroundcheck')";
					$stmt->prepare($sql);
					$stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssssssssssssssssss", $firstname, $lastname, $middlename, $title, $contract, $address, $city, $state, $zip, $email, $phone, $cellphone, $ss, $dob, $gender, $ethnicity, $classification, $location, $grade, $subject, $doh, $senioritydate, $effectivedate, $rategroup, $step, $educationlevel, $salary, $hours, $stateeducatorid, $l1_1, $l1_2, $l1_3, $l1_4, $l2_1, $l2_2, $l2_3, $l2_4, $l3_1, $l3_2, $l3_3, $l3_4, $l4_1, $l4_2, $l4_3, $l4_4, $l5_1, $l5_2, $l5_3, $l5_4, $l6_1, $l6_2, $l6_3, $l6_4, $probationreportdate, $statebackgroundcheck, $federalbackgroundcheck);
					$stmt->execute();
				}
				$counter++;
			}
			fclose($handle);
			$stmt->close();
			$db->close();

			//Response Message
			echo "Import Complete!";
		}else{
			echo "No file was chosen.";
		}
	}
?>