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

	if(superadmin() && getUpdateRequiredDbValue()){

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

		//Check for installed field
		require('abre_dbconnect.php');
		if(!$db->query("SELECT installed FROM apps_abre LIMIT 1")){
			$sql = "ALTER TABLE `apps_abre` ADD `installed` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		$apps_abre = array("Abre-Assessments", "Abre-Books", "Abre-Conduct", "Abre-Curriculum", "Abre-Forms", "Abre-Guided-Learning", "Abre-Students", "apps", "directory", "profile", "settings", "stream");

		require('abre_dbconnect.php');
		$stmt = $db->stmt_init();
		$insertSql = "INSERT INTO apps_abre (app, active, installed) VALUES (?, ?, ?)";
		$stmt->prepare($insertSql);
		$active = 1;
		$installed = 0;
		foreach($apps_abre as $app){
			$sql = "SELECT COUNT(*) FROM apps_abre WHERE app = '$app'";
			$query = $db->query($sql);
			$result = $query->fetch_assoc();
			$count = $result["COUNT(*)"];
			if($count == 0){
				$stmt->bind_param("sii", $app, $active, $installed);
				$stmt->execute();
			}
		}
		$stmt->close();

		$stmt = $db->stmt_init();
		$sql = "UPDATE settings SET update_required = ?";
		$stmt->prepare($sql);
		$i = 0;
		$stmt->bind_param("i", $i);
		$stmt->execute();
		$stmt->close();
		$db->close();

	}

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

			require('abre_dbconnect.php');
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
