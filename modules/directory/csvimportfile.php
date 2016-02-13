<?php
	
	/*
	* Copyright 2015 Hamilton City School District	
	* 		
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	* 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	* 
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */
	
	//Configuration
	require(dirname(__FILE__) . '/../../configuration.php'); 
	
	//Login Validation
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	
	require_once('permissions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	
	if($superadmin==1)
	{	

		//connect to the database 
		include "../../core/mysqlconnect.php";
		
		//Upload and Process CSV File
		if($_FILES['file']['tmp_name']){
			$handle = fopen($_FILES['file']['tmp_name'], "r");
			while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
				$picture = mysqli_real_escape_string($db,$data[0]);
				$firstname = mysqli_real_escape_string($db,$data[1]);
				$firstname=encrypt($firstname, "");
				$lastname = mysqli_real_escape_string($db,$data[2]);
				$lastname=encrypt($lastname, "");
				$middlename = mysqli_real_escape_string($db,$data[3]);
				$middlename=encrypt($middlename, "");
				$ss = mysqli_real_escape_string($db,$data[4]);
				$ss=encrypt($ss, "");
				$dob = mysqli_real_escape_string($db,$data[5]);
				$dob=encrypt($dob, "");
				$address = mysqli_real_escape_string($db,$data[6]);
				$address=encrypt($address, "");
				$city = mysqli_real_escape_string($db,$data[7]);
				$city=encrypt($city, "");
				$state = mysqli_real_escape_string($db,$data[8]);
				$state=encrypt($state, "");
				$zip = mysqli_real_escape_string($db,$data[9]);
				$zip=encrypt($zip, "");
				$phone = mysqli_real_escape_string($db,$data[10]);
				$phone=encrypt($phone, "");
				$email = mysqli_real_escape_string($db,$data[11]);
				$email=encrypt($email, "");
				$title = mysqli_real_escape_string($db,$data[12]);
				$title=encrypt($title, "");
				$classification = mysqli_real_escape_string($db,$data[13]);
				$classification=encrypt($classification, "");
				$location = mysqli_real_escape_string($db,$data[14]);
				$location=encrypt($location, "");
				$doh = mysqli_real_escape_string($db,$data[15]);
				$doh=encrypt($doh, "");
				$senioritydate = mysqli_real_escape_string($db,$data[16]);
				$senioritydate=encrypt($senioritydate, "");
				$effectivedate = mysqli_real_escape_string($db,$data[17]);
				$effectivedate=encrypt($effectivedate, "");
				$step = mysqli_real_escape_string($db,$data[18]);
				$step=encrypt($step, "");
				$salary = mysqli_real_escape_string($db,$data[19]);
				$salary=encrypt($salary, "");
				$hours = mysqli_real_escape_string($db,$data[20]);
				$hours=encrypt($hours, "");
				$probationreportdate = mysqli_real_escape_string($db,$data[21]);
				$probationreportdate=encrypt($probationreportdate, "");
				$statebackgroundcheck = mysqli_real_escape_string($db,$data[22]);
				$statebackgroundcheck=encrypt($statebackgroundcheck, "");
				$federalbackgroundcheck = mysqli_real_escape_string($db,$data[23]);
				$federalbackgroundcheck=encrypt($federalbackgroundcheck, "");
				$stateeducatorid = mysqli_real_escape_string($db,$data[24]);
				$stateeducatorid=encrypt($stateeducatorid, "");
				$l1_1 = mysqli_real_escape_string($db,$data[25]);
				$l1_1=encrypt($l1_1, "");
				$l1_2 = mysqli_real_escape_string($db,$data[26]);
				$l1_2=encrypt($l1_2, "");
				$l1_3 = mysqli_real_escape_string($db,$data[27]);
				$l1_3=encrypt($l1_3, "");
				$l1_4 = mysqli_real_escape_string($db,$data[28]);
				$l1_4=encrypt($l1_4, "");
				$l2_1 = mysqli_real_escape_string($db,$data[29]);
				$l2_1=encrypt($l2_1, "");
				$l2_2 = mysqli_real_escape_string($db,$data[30]);
				$l2_2=encrypt($l2_2, "");
				$l2_3 = mysqli_real_escape_string($db,$data[31]);
				$l2_3=encrypt($l2_3, "");
				$l2_4 = mysqli_real_escape_string($db,$data[32]);
				$l2_4=encrypt($l2_4, "");
				$l3_1 = mysqli_real_escape_string($db,$data[33]);
				$l3_1=encrypt($l3_1, "");
				$l3_2 = mysqli_real_escape_string($db,$data[34]);
				$l3_2=encrypt($l3_2, "");
				$l3_3 = mysqli_real_escape_string($db,$data[35]);
				$l3_3=encrypt($l3_3, "");
				$l3_4 = mysqli_real_escape_string($db,$data[36]);
				$l3_4=encrypt($l3_4, "");
				$l4_1 = mysqli_real_escape_string($db,$data[37]);
				$l4_1=encrypt($l4_1, "");
				$l4_2 = mysqli_real_escape_string($db,$data[38]);
				$l4_2=encrypt($l4_2, "");
				$l4_3 = mysqli_real_escape_string($db,$data[39]);
				$l4_3=encrypt($l4_3, "");
				$l4_4 = mysqli_real_escape_string($db,$data[40]);
				$l4_4=encrypt($l4_4, "");
				$l5_1 = mysqli_real_escape_string($db,$data[41]);
				$l5_1=encrypt($l5_1, "");
				$l5_2 = mysqli_real_escape_string($db,$data[42]);
				$l5_2=encrypt($l5_2, "");
				$l5_3 = mysqli_real_escape_string($db,$data[43]);
				$l5_3=encrypt($l5_3, "");
				$l5_4 = mysqli_real_escape_string($db,$data[44]);
				$l5_4=encrypt($l5_4, "");
				$l6_1 = mysqli_real_escape_string($db,$data[45]);
				$l6_1=encrypt($l6_1, "");
				$l6_2 = mysqli_real_escape_string($db,$data[46]);
				$l6_2=encrypt($l6_2, "");
				$l6_3 = mysqli_real_escape_string($db,$data[47]);
				$l6_3=encrypt($l6_3, "");
				$l6_4 = mysqli_real_escape_string($db,$data[48]);
				$l6_4=encrypt($l6_4, "");
				$blank=encrypt("", "");
				$import="INSERT into directory (picture,firstname,lastname,middlename,ss,dob,address,city,state,zip,phone,email,title,classification,location,doh,senioritydate,effectivedate,step,salary,hours,probationreportdate,statebackgroundcheck,federalbackgroundcheck,stateeducatorid,licensetype1,licenseissuedate1,licenseexpirationdate1,licenseterm1,licensetype2,licenseissuedate2,licenseexpirationdate2,licenseterm2,licensetype3,licenseissuedate3,licenseexpirationdate3,licenseterm3,licensetype4,licenseissuedate4,licenseexpirationdate4,licenseterm4,licensetype5,licenseissuedate5,licenseexpirationdate5,licenseterm5,licensetype6,licenseissuedate6,licenseexpirationdate6,licenseterm6) values ('$picture','$firstname','$lastname','$middlename','$ss','$dob','$address','$city','$state','$zip','$phone','$email' ,'$title','$classification','$location','$doh','$senioritydate','$effectivedate','$step','$salary','$hours','$probationreportdate','$statebackgroundcheck','$federalbackgroundcheck','$stateeducatorid','$l1_1','$l1_2','$l1_3','$l1_4','$l2_1','$l2_2','$l2_3','$l2_4','$l3_1','$l3_2','$l3_3','$l3_4','$l4_1','$l4_2','$l4_3','$l4_4','$l5_1','$l5_2','$l5_3','$l5_4','$l6_1','$l6_2','$l6_3','$l6_4')";
				mysqli_query($db,$import);
			}
			fclose($handle);
			
			//Response Message
			echo "Import Complete!"; 
		}
		else
		{
			echo "No file was chosen."; 			
		}
			  	
	}

?>