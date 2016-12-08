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
	
	mysqli_query($db, "DELETE FROM Swoca_HA_OnHands_Student WHERE Id>0");

	$handle = fopen("../../../swoca/HA_OnHands_Student.txt", "r");
		
	$count=0;
	while (($data = fgetcsv($handle, 1000000, "\t")) !== FALSE)
	{
		if($count!=0)
		{
			$StudentID = $data[0];
			$FirstName = $data[1];
			$MiddleName = $data[2];
			$LastName = $data[3];
			$Gender = $data[4];
			$EthnicityCode = $data[5];
			$EthnicityDescription = $data[6];
			$DateOfBirth = $data[7];
			$InitialEnrollDate = $data[8];
			$Email1 = $data[9];
			$Email2 = $data[10];
			$StateStudentId = $data[11];
			$IEP = $data[12];
			$Gifted = $data[13];
			$EconomicallyDisadvantaged = $data[14];
			$Title1 = $data[15];
			$Title3 = $data[16];
			$ELL = $data[17];
			$Schoolyear = $data[18];
			
			$import="INSERT into Swoca_HA_OnHands_Student (StudentID,FirstName,MiddleName,LastName,Gender,EthnicityCode,EthnicityDescription,DateOfBirth,InitialEnrollDate,Email1,Email2,StateStudentId,IEP,Gifted,EconomicallyDisadvantaged,Title1,Title3,ELL,Schoolyear) values ('$StudentID','$FirstName','$MiddleName','$LastName','$Gender','$EthnicityCode','$EthnicityDescription','$DateOfBirth','$InitialEnrollDate','$Email1','$Email2','$StateStudentId','$IEP','$Gifted','$EconomicallyDisadvantaged','$Title1','$Title3','$ELL','$Schoolyear')";
			mysqli_query($db,$import);
		}
		$count++;
	}
		
	fclose($handle);

?>