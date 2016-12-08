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
	
	mysqli_query($db, "DELETE FROM Swoca_HA_OnHands_Contacts WHERE Id>0");

	$handle = fopen("../../../swoca/HA_OnHands_Contacts.txt", "r");
		
	$count=0;
	
	while (($data = fgetcsv($handle, 1000000, "\t")) !== FALSE)
	{
		if($count!=0)
		{
			$StudentId = $data[0];
			$FirstName = $data[1];
			$MiddleName = $data[2];
			$LastName = $data[3];
			$AddressLine1 = $data[4];
			$AddressLine2 = $data[5];
			$City = $data[6];
			$State = $data[7];
			$Zip = $data[8];
			$Phone1 = $data[9];
			$Phone2 = $data[10];
			$Email1 = $data[11];
			$SchoolYear = $data[12];
			
			$import="INSERT into Swoca_HA_OnHands_Contacts (StudentId,FirstName,MiddleName,LastName,AddressLine1,AddressLine2,City,State,Zip,Phone1,Phone2,Email1,SchoolYear) values ('$StudentId','$FirstName','$MiddleName','$LastName','$AddressLine1','$AddressLine2','$City','$State','$Zip','$Phone1','$Phone2','$Email1','$SchoolYear')";
			mysqli_query($db,$import);
		}
		$count++;
	}
		
	fclose($handle);

?>