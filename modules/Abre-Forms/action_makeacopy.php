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
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once("functions.php");

	//Update system settings
	if($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator())
	{

		//Get Variables
		$id=mysqli_real_escape_string($db, $_POST["formid"]);

		//Duplicate the course
		$sqllookup = "SELECT Name, FormFields FROM forms WHERE ID = '$id'";
		$result = $db->query($sqllookup);
		while($row = $result->fetch_assoc())
		{

			$Name=mysqli_real_escape_string($db, $row["Name"]);
			$Name = "$Name - Copy";
			$FormFields=mysqli_real_escape_string($db, $row["FormFields"]);
			$Owner=$_SESSION['useremail'];

			$timedate=time();
			$string=$timedate.$_SESSION['useremail'];
			$Session=sha1($string);

			if($Owner == $_SESSION['useremail'])
			{

				$stmt = $db->stmt_init();
				$sql3 = "INSERT INTO forms (Name, FormFields, Owner, Session, Settings, Template) VALUES ('$Name', '$FormFields', '$Owner', '$Session', '', '0');";
				$stmt->prepare($sql3);
				$stmt->execute();
				$stmt->close();

				//Notification message
				echo "The form has been copied";

			}
		}
	}

?>