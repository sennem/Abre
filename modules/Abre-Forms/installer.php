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

	if(superadmin() && !isAppInstalled("Abre-Forms"))
	{
		//Check for forms table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM forms"))
		{
			$sql = "CREATE TABLE `forms` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `forms` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `forms` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Session field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Session FROM forms"))
		{
			$sql = "ALTER TABLE `forms` ADD `Session` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Owner field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Owner FROM forms"))
		{
			$sql = "ALTER TABLE `forms` ADD `Owner` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for LastOpened field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT LastModified FROM forms"))
		{
			$sql = "ALTER TABLE `forms` ADD `LastModified` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `ID`;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Name field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Name FROM forms"))
		{
			$sql = "ALTER TABLE `forms` ADD `Name` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for FormFields field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT FormFields FROM forms"))
		{
			$sql = "ALTER TABLE `forms` ADD `FormFields` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Settings field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Settings FROM forms"))
		{
			$sql = "ALTER TABLE `forms` ADD `Settings` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Template field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Template FROM forms"))
		{
			$sql = "ALTER TABLE `forms` ADD `Template` INT NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Public field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Public FROM forms"))
		{
			$sql = "ALTER TABLE `forms` ADD `Public` INT NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Template field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Plan FROM forms"))
		{
			$sql = "ALTER TABLE `forms` ADD `Plan` INT NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Restrictions field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Restrictions FROM forms"))
		{
			$sql = "ALTER TABLE `forms` ADD `Restrictions` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Owner field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Editors FROM forms"))
		{
			$sql = "ALTER TABLE `forms` ADD `Editors` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Owner field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT ResponseAccess FROM forms"))
		{
			$sql = "ALTER TABLE `forms` ADD `ResponseAccess` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for forms_responses table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM forms_responses"))
		{
			$sql = "CREATE TABLE `forms_responses` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `forms_responses` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `forms_responses` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for FormID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT FormID FROM forms_responses"))
		{
			$sql = "ALTER TABLE `forms_responses` ADD `FormID` int(11) NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for SubmissionTime field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT SubmissionTime FROM forms_responses"))
		{
			$sql = "ALTER TABLE `forms_responses` ADD `SubmissionTime` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `ID`;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Submitter field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Submitter FROM forms_responses"))
		{
			$sql = "ALTER TABLE `forms_responses` ADD `Submitter` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for UserType field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT UserType FROM forms_responses"))
		{
			$sql = "ALTER TABLE `forms_responses` ADD `UserType` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for FirstName field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT FirstName FROM forms_responses"))
		{
			$sql = "ALTER TABLE `forms_responses` ADD `FirstName` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for LastName field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT LastName FROM forms_responses"))
		{
			$sql = "ALTER TABLE `forms_responses` ADD `LastName` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for UniqueID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT UniqueID FROM forms_responses"))
		{
			$sql = "ALTER TABLE `forms_responses` ADD `UniqueID` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Response field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Response FROM forms_responses"))
		{
			$sql = "ALTER TABLE `forms_responses` ADD `Response` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		if(!file_exists($portal_path_root . "/../$portal_private_root/Abre-Forms/")){
			mkdir($portal_path_root . "/../$portal_private_root/Abre-Forms/", 0775);
		}

		//Mark app as installed
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql = "UPDATE apps_abre SET installed = 1 WHERE app = 'Abre-Forms'";
		$db->multi_query($sql);
		$db->close();

	}

?>
