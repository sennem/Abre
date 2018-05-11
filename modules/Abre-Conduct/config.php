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
	require(dirname(__FILE__) . '/../../core/abre_version.php');

	//Check for installation
	if(admin()){ require('installer.php'); }

	echo "<link rel='stylesheet' type='text/css' href='/modules/Abre-Conduct/style/style.0.0.8.css'>";

	$pageview = 1;
	$drawerhidden = 1;
	$pageorder = 4;
	$pagetitle = "Conduct";
	$description = "Record, store, & track student behavior.";
	$version = $abre_version;
	$repo = NULL;
	$pageicon = "gavel";
	$pagepath = "conduct/discipline/open";
	require_once('permissions.php');
?>