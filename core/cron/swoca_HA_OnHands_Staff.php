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
	
	mysqli_query($db, "DELETE FROM Swoca_HA_OnHands_Staff WHERE Id>0");

	$handle = fopen("../../../swoca/HA_OnHands_Staff.txt", "r");
		
	$count=0;
	while (($data = fgetcsv($handle, 1000000, "\t")) !== FALSE)
	{
		if($count!=0)
		{
			$StaffId = $data[0];
			$SchoolCode = $data[1];
			$FirstName = $data[2];
			$MiddleName = $data[3];
			$LastName = $data[4];
			$Gender = $data[5];
			$DateOfBirth = $data[6];
			$Address1 = $data[7];
			$AddressLine2 = $data[8];
			$City = $data[9];
			$State = $data[10];
			$Zip = $data[11];
			$Phone1 = $data[12];
			$EMail1 = $data[13];
			$HiringDate = $data[14];
			
			$import="INSERT into Swoca_HA_OnHands_Staff (StaffId,SchoolCode,FirstName,MiddleName,LastName,Gender,DateOfBirth,Address1,AddressLine2,City,State,Zip,Phone1,EMail1,HiringDate) values ('$StaffId','$SchoolCode','$FirstName','$MiddleName','$LastName','$Gender','$DateOfBirth','$Address1','$AddressLine2','$City','$State','$Zip','$Phone1','$EMail1','$HiringDate')";
			mysqli_query($db,$import);
		}
		$count++;
	}
		
	fclose($handle);

?>