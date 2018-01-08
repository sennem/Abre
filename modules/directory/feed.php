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

	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require(dirname(__FILE__) . '/../../core/abre_functions.php');

	$returnarray = array();

	$building = htmlspecialchars($_GET["building"]);
	$building = preg_replace("/[^ \w]+/", "", $building);
	if($building == "All"){
		$sql = "SELECT firstname, lastname, email, title, picture FROM directory WHERE archived = 0 ORDER BY lastname";
	}else{
		$school = encrypt("$building", "");
		$sql = "SELECT firstname, lastname, email, title, picture FROM directory WHERE location = '$school' and archived = 0 ORDER BY lastname";
	}
	$result = $db->query($sql);
	$numberofrows = $result->num_rows;
	while($row = $result->fetch_assoc()){
		$firstname = $row["firstname"];
		$firstname = stripslashes(decrypt($firstname, ""));
		$lastname = $row["lastname"];
		$lastname = stripslashes(decrypt($lastname, ""));
		$email = $row["email"];
		$email = stripslashes(decrypt($email, ""));
		$title = $row["title"];
		$title = stripslashes(decrypt($title, ""));
		$picture = $row["picture"];
		if($picture == ""){
			$picture='user.png';
		}
		$returnarray[] = array('firstname' => $firstname,'lastname' => $lastname,'email' => $email,'title' => $title,'picture' => $picture);
	}

	if (!empty($returnarray)){
		print_r(json_encode($returnarray));
	}
?>