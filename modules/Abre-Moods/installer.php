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
	//findme
	if(superadmin() && !isAppInstalled("Abre-Moods"))
	{

		//Create Books folder if one does not exist
		if (!file_exists("$portal_path_root/content/books")){ mkdir("$portal_path_root/content/books", 0700); }

		//Create Private Directory for Books
		if (!file_exists("$portal_path_root/../$portal_private_root/books")){
			if (!mkdir("$portal_path_root/../$portal_private_root/books", 0775)) {
			}
		}

		//Check for books table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM books LIMIT 1"))
		{
			$sql = "CREATE TABLE `books` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `books` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `books` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Code field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Code FROM books LIMIT 1"))
		{
			$sql = "ALTER TABLE `books` ADD `Code` varchar(11) NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Code field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Code FROM books LIMIT 1"))
		{
			$sql = "ALTER TABLE `books` ADD `Code` varchar(11) NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Code_Limit field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Code_Limit FROM books LIMIT 1"))
		{
			$sql = "ALTER TABLE `books` ADD `Code_Limit` int(11) DEFAULT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Title field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Title FROM books LIMIT 1"))
		{
			$sql = "ALTER TABLE `books` ADD `Title` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Author field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Author FROM books LIMIT 1"))
		{
			$sql = "ALTER TABLE `books` ADD `Author` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Slug field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Slug FROM books LIMIT 1"))
		{
			$sql = "ALTER TABLE `books` ADD `Slug` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Cover field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Cover FROM books LIMIT 1"))
		{
			$sql = "ALTER TABLE `books` ADD `Cover` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for File field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT File FROM books LIMIT 1"))
		{
			$sql = "ALTER TABLE `books` ADD `File` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Students_Required field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Students_Required FROM books LIMIT 1"))
		{
			$sql = "ALTER TABLE `books` ADD `Students_Required` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Staff_Required field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Staff_Required FROM books LIMIT 1"))
		{
			$sql = "ALTER TABLE `books` ADD `Staff_Required` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for books_libraries table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM books_libraries LIMIT 1"))
		{
			$sql = "CREATE TABLE `books_libraries` (`ID` int(11) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `books_libraries` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `books_libraries` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for User_ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT User_ID FROM books_libraries LIMIT 1"))
		{
			$sql = "ALTER TABLE `books_libraries` ADD `User_ID` int(11) NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Parent_ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Parent_ID FROM books_libraries LIMIT 1"))
		{
			$sql = "ALTER TABLE `books_libraries` ADD `Parent_ID` int(11) NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Book_ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Book_ID FROM books_libraries LIMIT 1"))
		{
			$sql = "ALTER TABLE `books_libraries` ADD `Book_ID` int(11) NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Mark app as installed
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql = "UPDATE apps_abre SET installed = 1 WHERE app = 'Abre-Books'";
		$db->multi_query($sql);
		$db->close();

	}

?>
