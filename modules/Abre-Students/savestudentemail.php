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
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');
	require_once('permissions.php');

	if(admin())
	{

		$Email=$_POST["Email"];
		$StudentID=$_POST["StudentID"];

		//Add/Update Student Email
		$EmailFound=0;
	    $query = "SELECT * FROM Abre_AD WHERE StudentID = '$StudentID'";
		$dbreturn = databasequery($query);
		foreach ($dbreturn as $value){
			$EmailFound=1;
			mysqli_query($db, "UPDATE Abre_AD SET Email='$Email' WHERE StudentID='$StudentID'") or die (mysqli_error($db));
		}

		if($EmailFound==0){
			mysqli_query($db, "INSERT INTO Abre_AD (Email, StudentID) VALUES ('$Email', '$StudentID')") or die (mysqli_error($db));
		}

		$db->close();

	}

?>
