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

	if(superadmin() && !file_exists("$portal_path_root/modules/settings/setup.txt"))
	{
		
		//Ping Update
		require(dirname(__FILE__) . '/../../core/abre_ping.php');
		
		//Check for users_parents table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM users_parent"))
		{
			 $sql = "CREATE TABLE `users_parent` (`id` int(11) NOT NULL,`email` text NOT NULL,`students` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			 $sql .= "ALTER TABLE `users_parent` ADD PRIMARY KEY (`id`);";
			 $sql .= "ALTER TABLE `users_parent` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
			 $db->multi_query($sql);
		}
		$db->close();

		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT studentId FROM users_parent"))
		{
			$sql = "ALTER TABLE `users_parent` ADD `studentId` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();
  }

  //Write the Setup File
  $myfile = fopen("$portal_path_root/modules/settings/setup.txt", "w");
  fwrite($myfile, '');
  fclose($myfile);
?>
