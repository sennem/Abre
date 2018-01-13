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

	if(superadmin() && !file_exists("$portal_path_root/modules/stream/setup.txt")){

		//Setup tables if new module
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$resultstreams = $db->query("SELECT * FROM streams")){
			$sql = "CREATE TABLE `streams` (`id` int(11) NOT NULL,`group` text NOT NULL,`title` text NOT NULL,`slug` text NOT NULL,`type` text NOT NULL,`url` text NOT NULL,`required` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `streams` ADD PRIMARY KEY (`id`);";
			$sql .= "ALTER TABLE `streams` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
			if ($db->multi_query($sql) === TRUE) { }
		}
		$db->close();

		//Setup tables if new module
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$resultstreamscomments = $db->query("SELECT * FROM streams_comments")){
			$sql = "CREATE TABLE `streams_comments` (`id` int(11) NOT NULL AUTO_INCREMENT,`url` text NOT NULL,`title` text NOT NULL,`image` text NOT NULL,`user` text NOT NULL,`comment` text NOT NULL,`creationtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,`liked` int(11) NOT NULL DEFAULT '0', PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1";
				if ($db->multi_query($sql) === TRUE) { }
		}
		$db->close();

		//check for widgets_order column
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT widgets_order FROM profiles")){
			$sql = "ALTER TABLE `profiles` ADD `widgets_order` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//check for widgets_hidden column
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT widgets_hidden FROM profiles")){
			$sql = "ALTER TABLE `profiles` ADD `widgets_hidden` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();
		
		//check for widgets_open column
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT widgets_open FROM profiles")){
			$sql = "ALTER TABLE `profiles` ADD `widgets_open` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

	}


  //Write the Setup File
  $myfile = fopen("$portal_path_root/modules/stream/setup.txt", "w");
  fwrite($myfile, '');
  fclose($myfile);
?>
