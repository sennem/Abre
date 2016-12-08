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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	require_once('permissions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	
	if($pageaccess==1)
	{	
		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=staffworkcalendars.csv');		
		$output = fopen('php://output', 'w');
				
		fputcsv($output, array('Completion Status', 'First Name', 'Last Name', 'Email', 'Contracted Days', 'Selected Day Count', 'Selected Days'));
		include "../../core/abre_dbconnect.php";
		$rows = mysqli_query($db, 'SELECT * FROM directory where archived=0');
				
		while ($row = mysqli_fetch_assoc($rows)) {
			$email=htmlspecialchars($row["email"], ENT_QUOTES); 
			$email=stripslashes(decrypt($email, ""));
			$firstname=htmlspecialchars($row["firstname"], ENT_QUOTES); 
			$firstname=stripslashes(decrypt($firstname, ""));
			$lastname=htmlspecialchars($row["lastname"], ENT_QUOTES); 
			$lastname=stripslashes(decrypt($lastname, ""));
			$contractdays=htmlspecialchars($row["contractdays"], ENT_QUOTES); 
			$contractdays=stripslashes(decrypt($contractdays, ""));
			if($contractdays!="")
			{
				$rowsselected = mysqli_query($db, "SELECT * FROM profiles where email='$email'");		
				while ($rowselect = mysqli_fetch_assoc($rowsselected))
				{
					$work_calendar=htmlspecialchars($rowselect["work_calendar"], ENT_QUOTES); 
					$work_calendar_count=substr_count($work_calendar, ",");
					if($work_calendar_count!=0){ $work_calendar_count=$work_calendar_count+1; }
					if($work_calendar_count>=$contractdays){ $status="Completed"; }else{ $status="Not Completed"; }
					$data = [$status, $firstname,$lastname,$email,$contractdays,$work_calendar_count,$work_calendar];
					fputcsv($output, $data);
				}
			}
		}
		
		fclose($output);
		mysqli_close($db);
		exit();
		
	}
  
?>