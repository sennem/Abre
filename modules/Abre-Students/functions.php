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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('permissions.php');

	if($pagerestrictions=="" || $isParent)
	{

		function verifyStudent($id){
			$ids = explode(",", $_SESSION['auth_students']);
			foreach($ids as $compareid){
				if($id == $compareid){
					return true;
				}
			}
			return false;
		}

		//Get StaffID Given Email
		function GetStaffID($email){
			$email = strtolower($email);
			$query = "SELECT StaffID FROM Abre_Staff WHERE EMail1 LIKE '$email' LIMIT 1";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value)
			{
				$StaffId=htmlspecialchars($value["StaffID"], ENT_QUOTES);
				if($StaffId != "")
				{
					return $StaffId;
				}
			}
			return "ABREDEMO";
		}

		//Get SchoolCode Given Email
		function GetStaffSchoolCode($email){
			$email = strtolower($email);
			$query = "SELECT SchoolCode FROM Abre_Staff WHERE EMail1 LIKE '$email'";
			$dbreturn = databasequery($query);
			$SchoolCode = "";
			$SchoolCodeTotal = "";
			foreach ($dbreturn as $value)
			{
				$SchoolCode=htmlspecialchars($value["SchoolCode"], ENT_QUOTES);
				$SchoolCodeTotal="$SchoolCode, $SchoolCodeTotal";
			}
			$SchoolCodeTotal=substr($SchoolCodeTotal, 0, -2);
			return $SchoolCodeTotal;
		}

		//Get Student Name Given ID
		function GetStudentNameGivenID($studentid){
			$query = "SELECT FirstName, LastName FROM Abre_Students WHERE StudentId = '$studentid' LIMIT 1";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value)
			{
				$FirstName=htmlspecialchars($value["FirstName"], ENT_QUOTES);
				$LastName=htmlspecialchars($value["LastName"], ENT_QUOTES);
				return "$FirstName $LastName";
			}
		}

		//Get Current Semester
		function GetCurrentSemester(){
			$currentMonth = date("F");
			if(	$currentMonth=="January" 	or
				$currentMonth=="February" 	or
				$currentMonth=="March" 		or
				$currentMonth=="April" 		or
				$currentMonth=="May" 		or
				$currentMonth=="June" 		or
				$currentMonth=="July"
			)
			{
				return "Sem2";
			}
			else
			{
				return "Sem1";
			}
		}

		//Get Course Name
		function GetCourseName($CourseCode,$SchoolCode){
			$query = "SELECT LongCourseName FROM Swoca_HA_OnHands_Courses WHERE CourseCode='$CourseCode' AND SchoolCode='$SchoolCode'";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value)
			{
				$LongCourseName=$value["LongCourseName"];
				return $LongCourseName;
			}
		}

	}
?>
