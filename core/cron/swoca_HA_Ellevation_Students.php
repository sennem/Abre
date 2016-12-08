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
	
	mysqli_query($db, "DELETE FROM Swoca_HA_Ellevation_Students WHERE Id>0");

	$handle = fopen("../../../swoca/HA_Ellevation_Students.txt", "r");
		
	$count=0;
	while (($data = fgetcsv($handle, 1000000, "\t")) !== FALSE)
	{
		if($count!=0)
		{
			$FirstName = $data[0];
			$MiddleName = $data[1];
			$LastName = $data[2];
			$StudentNumber = $data[3];
			$EMISID = $data[4];
			$Birthdate = $data[5];
			$BirthplaceCity = $data[6];
			$Gender = $data[7];
			$NativeLanguage = $data[8];
			$HomeLanguage = $data[9];
			$SchoolCode = $data[10];
			$BuildingGrade = $data[11];
			$AddressOfResidenceStreet = $data[12];
			$AddressOfResidenceCity = $data[13];
			$AddressOfResidenceState = $data[14];
			$AddressOfResidenceZip = $data[15];
			$StudentHomePhone = $data[16];
			$PrimaryContactFirstName = $data[17];
			$PrimaryContactLastName = $data[18];
			$StateStudentID = $data[19];
			$DistrictAdmissionDate = $data[20];
			$DisabilityCondition = $data[21];
			$LimitedEnglishProficiency = $data[22];
			$HomelessStatus = $data[23];
			$Section504Plan = $data[24];
			$LEPClassDate = $data[25];
			$MigrantStatus = $data[26];
			$ImmigrantStatus = $data[27];
			$EMISEthnicity = $data[28];
			$EnrolledinUS = $data[29];
			$YearsinUSSchools = $data[30];
			
			$import="INSERT into Swoca_HA_Ellevation_Students (FirstName,MiddleName,LastName,StudentNumber,EMISID,Birthdate,BirthplaceCity,Gender,NativeLanguage,HomeLanguage,SchoolCode,BuildingGrade,AddressOfResidenceStreet,AddressOfResidenceCity,AddressOfResidenceState,AddressOfResidenceZip,StudentHomePhone,PrimaryContactFirstName,PrimaryContactLastName,StateStudentID,DistrictAdmissionDate,DisabilityCondition,LimitedEnglishProficiency,HomelessStatus,Section504Plan,LEPClassDate,MigrantStatus,ImmigrantStatus,EMISEthnicity,EnrolledinUS,YearsinUSSchools) values ('$FirstName','$MiddleName','$LastName','$StudentNumber','$EMISID','$Birthdate','$BirthplaceCity','$Gender','$NativeLanguage','$HomeLanguage','$SchoolCode','$BuildingGrade','$AddressOfResidenceStreet','$AddressOfResidenceCity','$AddressOfResidenceState','$AddressOfResidenceZip','$StudentHomePhone','$PrimaryContactFirstName','$PrimaryContactLastName','$StateStudentID','$DistrictAdmissionDate','$DisabilityCondition','$LimitedEnglishProficiency','$HomelessStatus','$Section504Plan','$LEPClassDate','$MigrantStatus','$ImmigrantStatus','$EMISEthnicity','$EnrolledinUS','$YearsinUSSchools')";
			mysqli_query($db,$import);
		}
		$count++;
	}
		
	fclose($handle);

?>