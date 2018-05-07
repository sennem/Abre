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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require(dirname(__FILE__) . '/../../core/abre_version.php');

	//Verify Superadmin
	$sql = "SELECT * FROM users WHERE email = '".$_SESSION['useremail']."' AND superadmin = 1";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc()){

		//Retrieve the repo
		$repoaddress = $_POST["repoaddress"];
		$repoaddress = str_replace('https://github.com/', '', $repoaddress);
		$project = strstr($repoaddress, '/');

		$opts = ['http' => ['method' => 'GET','header' => ['User-Agent: PHP']]];
		$context = stream_context_create($opts);
		$content = file_get_contents("https://api.github.com/repos/$repoaddress/releases/latest", false, $context);
		$json = json_decode($content, true);
		$currentversion = $json['name'];

		$currentlink = "https://github.com/$repoaddress/archive/".$currentversion.".zip";
		file_put_contents("$portal_path_root/modules/$project.zip", file_get_contents($currentlink));

		//Upzip the file
		$zip = new ZipArchive;
		if ($zip->open("$portal_path_root/modules/$project.zip") === TRUE) {
			$zip->extractTo("$portal_path_root/modules/");
			$zip->close();
		}

		//Rename folder
		rename(realpath(dirname(__FILE__))."/../$project-$currentversion",realpath(dirname(__FILE__))."/../$project");

		//Delete zipped files
    unlink("$portal_path_root/modules/$project.zip");

		echo "Module Added";
	}
?>