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

	if(superadmin() && !file_exists("$portal_path_root/modules/profile/setup.txt")){

    //Setup tables if new module
    require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
    if(!$resultprofile = $db->query("SELECT * FROM profiles")){
      $sql = "CREATE TABLE `profiles` (`id` int(11) NOT NULL,`email` text NOT NULL,`startup` int(11) NOT NULL DEFAULT '1',`streams` text NOT NULL,`apps_order` text NOT NULL,`work_calendar` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
      $sql .= "ALTER TABLE `profiles` ADD PRIMARY KEY (`id`);";
      $sql .= "ALTER TABLE `profiles` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
      $sql .= "INSERT INTO `profiles` (`id`, `email`, `startup`, `streams`, `apps_order`, `work_calendar`) VALUES (NULL, '".$_SESSION['useremail']."', '', '');";
      if ($db->multi_query($sql) === TRUE) { }
    }
    $db->close();

	}


  //Write the Setup File
  $myfile = fopen("$portal_path_root/modules/profile/setup.txt", "w");
  fwrite($myfile, '');
  fclose($myfile);
?>