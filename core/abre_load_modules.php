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

	//Include required files
	require_once('abre_verification.php');
	require_once('abre_functions.php');

	if(superadmin() && !file_exists("$portal_path_root/modules/modules/setup.txt")){

		//Check for apps table
		require('abre_dbconnect.php');
		if(!$db->query("SELECT * FROM apps_abre LIMIT 1")){
			$sql = "CREATE TABLE `apps_abre` (`id` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `apps_abre` ADD PRIMARY KEY (`id`);";
			$sql .= "ALTER TABLE `apps_abre` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for app field
		require('abre_dbconnect.php');
		if(!$db->query("SELECT app FROM apps_abre LIMIT 1")){
			$sql = "ALTER TABLE `apps_abre` ADD `app` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for active field
		require('abre_dbconnect.php');
		if(!$db->query("SELECT active FROM apps_abre LIMIT 1")){
			$sql = "ALTER TABLE `apps_abre` ADD `active` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Write the Setup File
		$myfile = fopen("$portal_path_root/modules/modules/setup.txt", "w");
		fwrite($myfile, '');
		fclose($myfile);

	}

	require('abre_dbconnect.php');
	//Used to load modals
	echo "<div id='modal_holder'></div>";

	//Load additional modules based on permissions
	$modules = array();
	$modulecount = 0;
	$moduledirectory = dirname(__FILE__) . '/../modules';
	$modulefolders = scandir($moduledirectory);
	foreach($modulefolders as $result){
		if($result == '.' or $result == '..') continue;
		if(is_dir($moduledirectory . '/' . $result)){
			$pageview = NULL;
			$drawerhidden = NULL;
			$pageorder = NULL;
			$pagetitle = NULL;
			$pageicon = NULL;
			$pagepath = NULL;
			$pagerestrictions = NULL;
			$subpages = NULL;

			//Load Abre app only if not turned off
			$sqlcountcheck = "SELECT COUNT(*) FROM apps_abre WHERE app='$result' AND active='0' LIMIT 1";
			$sqlcountcheckresult = $db->query($sqlcountcheck);
			$sqlcountcheckreturn = $sqlcountcheckresult->fetch_assoc();
			$apprecordexists = $sqlcountcheckreturn["COUNT(*)"];

			if($apprecordexists == 0)
			{
				require_once(dirname(__FILE__) . '/../modules/'.$result.'/config.php');
				$access = strpos($pagerestrictions, $_SESSION['usertype']);
				if($access === false){
					array_push($modules, array($pageorder, $pagetitle, $pageview, $pageicon, $pagepath, $drawerhidden, $subpages));
					$modulecount++;
				}
			}

		}

	}

	//Close Database
	$db->close();

	sort($modules, SORT_DESC);
?>
