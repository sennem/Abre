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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	if(superadmin() && !isAppInstalled("Abre-Students"))
	{

		//Check for students_groups table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM students_groups LIMIT 1"))
		{
			$sql = "CREATE TABLE `students_groups` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `students_groups` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `students_groups` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Owner field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT StaffId FROM students_groups LIMIT 1"))
		{
			$sql = "ALTER TABLE `students_groups` ADD `StaffId` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Name field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Name FROM students_groups LIMIT 1"))
		{
			$sql = "ALTER TABLE `students_groups` ADD `Name` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for students_groups_students table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM students_groups_students LIMIT 1"))
		{
			$sql = "CREATE TABLE `students_groups_students` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `students_groups_students` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `students_groups_students` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for StaffId field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT StaffId FROM students_groups_students LIMIT 1"))
		{
			$sql = "ALTER TABLE `students_groups_students` ADD `StaffId` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Group_ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Group_ID FROM students_groups_students LIMIT 1"))
		{
			$sql = "ALTER TABLE `students_groups_students` ADD `Group_ID` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Student_ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Student_ID FROM students_groups_students LIMIT 1"))
		{
			$sql = "ALTER TABLE `students_groups_students` ADD `Student_ID` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Mark app as installed
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql = "UPDATE apps_abre SET installed = 1 WHERE app = 'Abre-Students'";
		$db->multi_query($sql);
		$db->close();

	}

?>
