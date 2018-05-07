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
	require('dbconnect.php');

  //Encryption function
  function encrypt($string, $encryption_key){
    $encryption_key = 'lCoFCKGubq2X1xfM48By7YLrBRGzRaEd';
    $string = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $encryption_key, $string, MCRYPT_MODE_ECB)));

    return $string;
  }

	//Upload and Process CSV File
  $handle = fopen("/home/master/applications/gyvseaknxu/private_html/directory_mcs.csv", "r");

  $counter = 0;
  $previousName = "";
  while(($data = fgetcsv($handle, 0, ",")) !== FALSE){
    if($counter > 0){
      $firstname = $data[0];
      $lastname = $data[1];
      $fullName = $firstname." ".$lastname;
      if($previousName != "" && $previousName == $fullName){
        continue;
      }
      $previousName = $fullName;
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
      $email = "";
      $email = $data[9];
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
      $stateeducatorid = $data[29];
      $stateeducatorid = encrypt($stateeducatorid, "");
      $l1_1 = $data[30];
      $l1_1 = encrypt($l1_1, "");
      $l1_2 = $data[31];
      $l1_2 = encrypt($l1_2, "");
      $l1_3 = $data[32];
      $l1_3 = encrypt($l1_3, "");
      $l1_4 = $data[33];
      $l1_4 = encrypt($l1_4, "");
      $l2_1 = $data[34];
      $l2_1 = encrypt($l2_1, "");
      $l2_2 = $data[35];
      $l2_2 = encrypt($l2_2, "");
      $l2_3 = $data[36];
      $l2_3 = encrypt($l2_3, "");
      $l2_4 = $data[37];
      $l2_4 = encrypt($l2_4, "");
      $l3_1 = $data[38];
      $l3_1 = encrypt($l3_1, "");
      $l3_2 = $data[39];
      $l3_2 = encrypt($l3_2, "");
      $l3_3 = $data[40];
      $l3_3 = encrypt($l3_3, "");
      $l3_4 = $data[41];
      $l3_4 = encrypt($l3_4, "");
      $l4_1 = $data[42];
      $l4_1 = encrypt($l4_1, "");
      $l4_2 = $data[43];
      $l4_2 = encrypt($l4_2, "");
      $l4_3 = $data[44];
      $l4_3 = encrypt($l4_3, "");
      $l4_4 = $data[45];
      $l4_4 = encrypt($l4_4, "");
      $l5_1 = $data[46];
      $l5_1 = encrypt($l5_1, "");
      $l5_2 = $data[47];
      $l5_2 = encrypt($l5_2, "");
      $l5_3 = $data[48];
      $l5_3 = encrypt($l5_3, "");
      $l5_4 = $data[49];
      $l5_4 = encrypt($l5_4, "");
      $l6_1 = $data[50];
      $l6_1 = encrypt($l6_1, "");
      $l6_2 = $data[51];
      $l6_2 = encrypt($l6_2, "");
      $l6_3 = $data[52];
      $l6_3 = encrypt($l6_3, "");
      $l6_4 = $data[53];
      $l6_4 = encrypt($l6_4, "");
      $probationreportdate = $data[54];
      $probationreportdate = encrypt($probationreportdate, "");
      $statebackgroundcheck = $data[55];
      $statebackgroundcheck = encrypt($statebackgroundcheck, "");
      $federalbackgroundcheck = $data[56];
      $federalbackgroundcheck = encrypt($federalbackgroundcheck, "");


      if($email != "" && strpos($email, '@') != 0){
        $duplicateCheck = "SELECT COUNT(*) FROM directory WHERE email = '$email' LIMIT 1";
        $query = $db->query($duplicateCheck);
        $row = $query->fetch_assoc();
        $count = $row['COUNT(*)'];
        if($count != 0){
          $stmt = $db->stmt_init();
          $sql = "UPDATE directory SET firstname = ?,lastname = ?, middlename = ?, title = ?, contract = ?, address = ?, city = ?, state = ?, zip = ?, phone = ?, extension = ?, cellphone = ?, ss = ?, dob = ?, gender = ?, ethnicity = ?, classification = ?, location = ?, grade = ?, subject = ?, doh = ?, senioritydate = ?, effectivedate = ?, rategroup = ?, step = ?, educationlevel = ?, salary = ?, hours = ?, stateeducatorid = ?, licensetype1 = ?,licenseissuedate1 = ?, licenseexpirationdate1 = ?, licenseterm1 = ?, licensetype2 = ?, licenseissuedate2 = ?, licenseexpirationdate2 = ?, licenseterm2 = ?, licensetype3 = ?, licenseissuedate3 = ?, licenseexpirationdate3 = ?, licenseterm3 = ?, licensetype4 = ?, licenseissuedate4 = ?, licenseexpirationdate4 = ?, licenseterm4 = ?, licensetype5 = ?, licenseissuedate5 = ?, licenseexpirationdate5 = ?, licenseterm5 = ?, licensetype6 = ?, licenseissuedate6 = ?, licenseexpirationdate6 = ?, licenseterm6 = ?, probationreportdate = ?, statebackgroundcheck = ?, federalbackgroundcheck = ? WHERE email = ?";
          $stmt->prepare($sql);
          $stmt->bind_param("sssssssssssssssssssssssssssssssssssssssssssssssssssssssss", $firstname, $lastname, $middlename, $title, $contract, $address, $city, $state, $zip, $phone, $extension, $cellphone, $ss, $dob, $gender, $ethnicity, $classification, $location, $grade, $subject, $doh, $senioritydate, $effectivedate, $rategroup, $step, $educationlevel, $salary, $hours, $stateeducatorid, $l1_1, $l1_2, $l1_3, $l1_4, $l2_1, $l2_2, $l2_3, $l2_4, $l3_1, $l3_2, $l3_3, $l3_4, $l4_1, $l4_2, $l4_3, $l4_4, $l5_1, $l5_2, $l5_3, $l5_4, $l6_1, $l6_2, $l6_3, $l6_4, $probationreportdate, $statebackgroundcheck, $federalbackgroundcheck, $email);
          $stmt->execute();
          echo $stmt->error;
          $stmt->close();
        }else{
          $stmt = $db->stmt_init();
          $sql = "INSERT INTO directory (firstname,lastname,middlename,title,contract,address,city,state,zip,email,phone,extension,cellphone,ss,dob,gender,ethnicity,classification,location,grade,subject,doh,senioritydate,effectivedate,rategroup,step,educationlevel,salary,hours,stateeducatorid,licensetype1,licenseissuedate1,licenseexpirationdate1,licenseterm1,licensetype2,licenseissuedate2,licenseexpirationdate2,licenseterm2,licensetype3,licenseissuedate3,licenseexpirationdate3,licenseterm3,licensetype4,licenseissuedate4,licenseexpirationdate4,licenseterm4,licensetype5,licenseissuedate5,licenseexpirationdate5,licenseterm5,licensetype6,licenseissuedate6,licenseexpirationdate6,licenseterm6,probationreportdate,statebackgroundcheck,federalbackgroundcheck) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
          $stmt->prepare($sql);
          $stmt->bind_param("sssssssssssssssssssssssssssssssssssssssssssssssssssssssss", $firstname, $lastname, $middlename, $title, $contract, $address, $city, $state, $zip, $email, $phone, $extension, $cellphone, $ss, $dob, $gender, $ethnicity, $classification, $location, $grade, $subject, $doh, $senioritydate, $effectivedate, $rategroup, $step, $educationlevel, $salary, $hours, $stateeducatorid, $l1_1, $l1_2, $l1_3, $l1_4, $l2_1, $l2_2, $l2_3, $l2_4, $l3_1, $l3_2, $l3_3, $l3_4, $l4_1, $l4_2, $l4_3, $l4_4, $l5_1, $l5_2, $l5_3, $l5_4, $l6_1, $l6_2, $l6_3, $l6_4, $probationreportdate, $statebackgroundcheck, $federalbackgroundcheck);
          $stmt->execute();
          $stmt->close();
        }
      }
    }
    $counter++;
  }
	fclose($handle);
	$db->close();

  //Send Confirmation Email
  mail("$supportemail","$district - SIS Sync Cron Job - Directory_Sync.php","");

?>