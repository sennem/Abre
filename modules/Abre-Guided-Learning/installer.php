<?php

	/*
	* Copyright (C) 2016-2017 Abre.io LLC
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

	if(superadmin() && !isAppInstalled("Abre-Guided-Learning"))
	{
		//Check for guide_boards table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM guide_boards LIMIT 1"))
		{
			$sql = "CREATE TABLE `guide_boards` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `guide_boards` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `guide_boards` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Title field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Title FROM guide_boards LIMIT 1"))
		{
			$sql = "ALTER TABLE `guide_boards` ADD `Title` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Code field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Code FROM guide_boards LIMIT 1"))
		{
			$sql = "ALTER TABLE `guide_boards` ADD `Code` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Creator field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Creator FROM guide_boards LIMIT 1"))
		{
			$sql = "ALTER TABLE `guide_boards` ADD `Creator` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for guide_links table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM guide_links LIMIT 1"))
		{
			$sql = "CREATE TABLE `guide_links` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `guide_links` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `guide_links` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Board_ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Board_ID FROM guide_links LIMIT 1"))
		{
			$sql = "ALTER TABLE `guide_links` ADD `Board_ID` int(11) NOT NULL;";
			$sql .= "ALTER TABLE `guide_links` ADD FOREIGN KEY (`Board_ID`) REFERENCES guide_boards(`ID`);";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Data field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Data FROM guide_links LIMIT 1"))
		{
			$sql = "ALTER TABLE `guide_links` ADD `Data` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Screenshots field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Screenshots FROM guide_links LIMIT 1"))
		{
			$sql = "ALTER TABLE `guide_links` ADD `Screenshots` int(11) DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for guide_activity table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM guide_activity LIMIT 1"))
		{
			$sql = "CREATE TABLE `guide_activity` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `guide_activity` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `guide_activity` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Activity Code field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT `activity_code` FROM guide_activity LIMIT 1")){
			$sql = "ALTER TABLE `guide_activity` ADD `activity_code` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Student Email field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT `student_email` FROM guide_activity LIMIT 1")){
			$sql = "ALTER TABLE `guide_activity` ADD `student_email` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for start_time field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT `start_time` FROM guide_activity LIMIT 1")){
			$sql = "ALTER TABLE `guide_activity` ADD `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for end_time field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT `end_time` FROM guide_activity LIMIT 1")){
			$sql = "ALTER TABLE `guide_activity` ADD `end_time` timestamp;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for history field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT `history` FROM guide_activity LIMIT 1")){
			$sql = "ALTER TABLE `guide_activity` ADD `history` LONGTEXT NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for active field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT `active` FROM guide_activity LIMIT 1")){
			$sql = "ALTER TABLE `guide_activity` ADD `active` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Mark app as installed
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql = "UPDATE apps_abre SET installed = 1 WHERE app = 'Abre-Guided-Learning'";
		$db->multi_query($sql);
		$db->close();

	}

?>