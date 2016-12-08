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
	
	mysqli_query($db, "DELETE FROM Swoca_HA_OnHands_StudentSchools WHERE Id>0");

	$handle = fopen("../../../swoca/HA_OnHands_StudentSchools.txt", "r");
		
	$count=0;
	while (($data = fgetcsv($handle, 1000000, "\t")) !== FALSE)
	{
		if($count!=0)
		{
			$StudentId = $data[0];
			$SchoolCode = $data[1];
			$SchoolName = $data[2];
			$CurrentGrade = $data[3];
			$CurrentHomeroom = $data[4];
			$EnrollDate = $data[5];
			$SchoolYear = $data[6];
			$Status = $data[7];
			
			$import="INSERT into Swoca_HA_OnHands_StudentSchools (StudentId,SchoolCode,SchoolName,CurrentGrade,CurrentHomeroom,EnrollDate,SchoolYear,Status) values ('$StudentId','$SchoolCode','$SchoolName','$CurrentGrade','$CurrentHomeroom','$EnrollDate','$SchoolYear','$Status')";
			mysqli_query($db,$import);
		}
		$count++;
	}
		
	fclose($handle);

?>