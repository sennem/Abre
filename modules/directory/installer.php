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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	if(superadmin() && !file_exists("$portal_path_root/modules/directory/setup.txt"))
	{
		//Check for directory settings table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM directory_settings"))
		{
			$sql = "CREATE TABLE `directory_settings` (`id` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `directory_settings` ADD PRIMARY KEY (`id`);";
			$sql .= "ALTER TABLE `directory_settings` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for dropdown title field
		if(!$db->query("SELECT dropdownID FROM directory_settings"))
		{
			$sql = "ALTER TABLE `directory_settings` ADD `dropdownID` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for options field
		if(!$db->query("SELECT options FROM directory_settings"))
		{
			$sql = "ALTER TABLE `options` ADD `directory_settings` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Write the Setup File
		$myfile = fopen("$portal_path_root/modules/directory/setup.txt", "w");
		fwrite($myfile, '');
		fclose($myfile);

	}

?>
