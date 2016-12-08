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
	
	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php'); 
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	require(dirname(__FILE__) . '/../../core/abre_functions.php');
	
	mysqli_query($db, "DELETE FROM Swoca_HA_gifted_student WHERE Id>0");

	$handle = fopen("../../../swoca/HA_gifted_student.txt", "r");
		
	$count=0;
	while (($data = fgetcsv($handle, 1000000, "\t")) !== FALSE)
	{
		if($count!=0)
		{
			$StudentNumber = mysqli_real_escape_string($db,$data[0]);
			$StateStudentid = mysqli_real_escape_string($db,$data[1]);
			$LastName = mysqli_real_escape_string($db,$data[2]);
			$FirstName = mysqli_real_escape_string($db,$data[3]);
			$MiddleName = mysqli_real_escape_string($db,$data[4]);
			$Address = mysqli_real_escape_string($db,$data[5]);
			$City = mysqli_real_escape_string($db,$data[6]);
			$State = mysqli_real_escape_string($db,$data[7]);
			$Zip = mysqli_real_escape_string($db,$data[8]);
			$Ethnicity = mysqli_real_escape_string($db,$data[9]);
			$StudentHomePhone = mysqli_real_escape_string($db,$data[10]);
			$PrimaryContact = mysqli_real_escape_string($db,$data[11]);
			$ParentAddress = mysqli_real_escape_string($db,$data[12]);
			$ParentCity = mysqli_real_escape_string($db,$data[13]);
			$ParentState = mysqli_real_escape_string($db,$data[14]);
			$ParentZip = mysqli_real_escape_string($db,$data[15]);
			$Homeroom = mysqli_real_escape_string($db,$data[16]);
			$HomeroomTeacher = mysqli_real_escape_string($db,$data[17]);
			$Birthdate = mysqli_real_escape_string($db,$data[18]);
			$Gender = mysqli_real_escape_string($db,$data[19]);
			$HandicapCondition = mysqli_real_escape_string($db,$data[20]);
			$LimitedEnglishCode = mysqli_real_escape_string($db,$data[21]);
			$Disadvantagement = mysqli_real_escape_string($db,$data[22]);
			$Status = mysqli_real_escape_string($db,$data[23]);
			$DistrictAdmissionDate = mysqli_real_escape_string($db,$data[24]);
			$AttendancePercentage = mysqli_real_escape_string($db,$data[25]);
			$NativeLanguage = mysqli_real_escape_string($db,$data[26]);
			$RetainedStatus = mysqli_real_escape_string($db,$data[27]);
			$GradeLevel = mysqli_real_escape_string($db,$data[28]);
			$BuildingCode = mysqli_real_escape_string($db,$data[29]);
			$SchoolYear = mysqli_real_escape_string($db,$data[30]);
			
			$import="INSERT into Swoca_HA_gifted_student (StudentNumber,StateStudentid,LastName,FirstName,MiddleName,Address,City,State,Zip,Ethnicity,StudentHomePhone,PrimaryContact,ParentAddress,ParentCity,ParentState,ParentZip,Homeroom,HomeroomTeacher,Birthdate,Gender,HandicapCondition,LimitedEnglishCode,Disadvantagement,Status,DistrictAdmissionDate,AttendancePercentage,NativeLanguage,RetainedStatus,GradeLevel,BuildingCode,SchoolYear) values ('$StudentNumber','$StateStudentid','$LastName','$FirstName','$MiddleName','$Address','$City','$State','$Zip','$Ethnicity','$StudentHomePhone','$PrimaryContact','$ParentAddress','$ParentCity','$ParentState','$ParentZip','$Homeroom','$HomeroomTeacher','$Birthdate','$Gender','$HandicapCondition','$LimitedEnglishCode','$Disadvantagement','$Status','$DistrictAdmissionDate','$AttendancePercentage','$NativeLanguage','$RetainedStatus','$GradeLevel','$BuildingCode','$SchoolYear')";
			mysqli_query($db,$import);
		}
		$count++;
	}
		
	fclose($handle);

?>