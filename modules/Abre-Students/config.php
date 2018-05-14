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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('permissions.php');
	require(dirname(__FILE__) . '/../../core/abre_version.php');

	echo "<link rel='stylesheet' href='modules/".basename(__DIR__)."/css/style.1.0.css'>";

	//Check for installation
	if(admin()){ require('installer.php'); }

	$pageview = 1;
	$pageorder = 2;
	$pagetitle = "Students";
	$description = "A student data dashboard for staff and parents.";
	$version = $abre_version;
	$repo = NULL;
	$pageicon = "supervisor_account";
	if($isParent){
		$pagepath = "mystudents";
	}else{
		$pagepath = "students";
	}

?>
