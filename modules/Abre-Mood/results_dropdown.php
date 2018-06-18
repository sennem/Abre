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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('../../core/abre_functions.php');
	require_once('functions.php');
	require_once('permissions.php');

	if($pagerestrictions=="")
	{

		$category=htmlspecialchars($_GET["category"], ENT_QUOTES);
		$StaffIDDropdown=htmlspecialchars($_GET["staffid"], ENT_QUOTES);
		$StaffId=GetStaffID($_SESSION['useremail']);
		$CurrentSememester=GetCurrentSemester();
		$emailencrypted=encrypt($_SESSION['useremail'],"");
		$email=$_SESSION['useremail'];

		//If Course, Display all Courses
		if($category=="course")
		{
			echo "<option value='' disabled selected>Choose a Course</option>";
			$query = "SELECT CourseCode, SchoolCode, SectionCode, CourseName, Period FROM Abre_StaffSchedules WHERE StaffID='$StaffId' AND (TermCode='$CurrentSememester' OR TermCode='Year') ORDER BY Period";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value)
			{
				$CourseCode=$value['CourseCode'];
				$SchoolCode=$value['SchoolCode'];
				$SectionCode=$value['SectionCode'];
				$CourseName=$value['CourseName'];
				$Period=$value['Period'];

				echo "<option value='$CourseCode,$SectionCode'>$CourseName (Period: $Period)</option>";
			}
		}

		//If Course, Display all Courses
		if($category=="courseteacher")
		{
			echo "<option value='' disabled selected>Choose a Course</option>";
			$query = "SELECT CourseCode, SchoolCode, SectionCode, CourseName, Period FROM Abre_StaffSchedules WHERE StaffID='$StaffIDDropdown' AND (TermCode='$CurrentSememester' OR TermCode='Year') ORDER BY Period";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value)
			{
				$CourseCode=$value['CourseCode'];
				$SchoolCode=$value['SchoolCode'];
				$SectionCode=$value['SectionCode'];
				$CourseName=$value['CourseName'];
				$Period=$value['Period'];

				echo "<option value='$CourseCode,$SectionCode'>$CourseName (Period: $Period)</option>";
			}
		}

		//If Group, Display all Groups
		if($category=="group")
		{
			echo "<option value='' disabled selected>Choose a Group</option>";
			$query = "SELECT Name, ID FROM students_groups WHERE StaffId='$StaffId'";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value)
			{
				$GroupName=$value['Name'];
				$GroupID=$value['ID'];

				echo "<option value='$GroupID'>$GroupName</option>";
			}
		}

		//If Teacher, Display all Students for Teacher
		if($category=="teacher")
		{
			//Find what building the admin has access to
			echo "<option value='' disabled selected>Choose a Teacher</option>";
				$query = "SELECT SchoolName FROM Abre_VendorLink_SIS_Staff WHERE EmailList LIKE '%$email%' LIMIT 1";
				$dbreturn = databasequery($query);
				$usersfound=count($dbreturn);
				foreach ($dbreturn as $value)
				{
					$SchoolName=$value['SchoolName'];

					//Find all students in the building
					$query2 = "SELECT LocalId, LastName, FirstName FROM Abre_VendorLink_SIS_Staff WHERE SchoolName LIKE '%$SchoolName%' GROUP BY LocalId ORDER BY LastName";
					$dbreturn2 = databasequery($query2);
					foreach ($dbreturn2 as $value2)
					{
						$LocalId=$value2['LocalId'];
						$LastName=$value2['LastName'];
						$FirstName=$value2['FirstName'];

						echo "<option value='$LocalId'>$LastName, $FirstName</option>";
					}

				}

				if($usersfound==0)
				{
					$query2 = "SELECT LocalId, LastName, FirstName FROM Abre_VendorLink_SIS_Staff GROUP BY LocalId ORDER BY LastName";
					$dbreturn2 = databasequery($query2);
					foreach ($dbreturn2 as $value2)
					{
						$LocalId=$value2['LocalId'];
						$LastName=$value2['LastName'];
						$FirstName=$value2['FirstName'];

						echo "<option value='$LocalId'>$LastName, $FirstName</option>";
					}
				}
		}

		//If Building, Display all Buildings
		if($category=="building")
		{
			echo "<option value='' disabled selected>Choose a Building</option>";
			$query = "SELECT SchoolName, SchoolCode FROM Abre_Students GROUP BY SchoolName ORDER BY SchoolName";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value)
			{
				$SchoolName=$value['SchoolName'];
				$SchoolCode=$value['SchoolCode'];

				echo "<option value='$SchoolCode'>$SchoolName</option>";
			}
		}

	}

?>