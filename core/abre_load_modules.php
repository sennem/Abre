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

	//Include required files
	require_once('abre_verification.php');

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

			require_once(dirname(__FILE__) . '/../modules/'.$result.'/config.php');
			$access = strpos($pagerestrictions, $_SESSION['usertype']);
			if($access === false){
				array_push($modules, array($pageorder, $pagetitle, $pageview, $pageicon, $pagepath, $drawerhidden, $subpages));
				$modulecount++;
			}
		}
	}
	sort($modules, SORT_DESC);
?>