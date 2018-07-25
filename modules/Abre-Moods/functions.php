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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');

	//Find user ID given an email
	function finduseridparent($email)
	{
		include(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql = "SELECT id FROM users_parent WHERE email = '".$_SESSION['useremail']."'";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc()){
			$id = $row["id"];
			return $id;
		}
	}

	

?>
