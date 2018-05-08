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

	$subjectvalue=$_GET["subject"];
	$bankvalue=$_GET["bank"];

	echo "<option value='' disabled='disabled' selected>Select a Grade</option>";

	if(!empty($subjectvalue) && !empty($bankvalue))
	{

		$subjectvalue = mysqli_real_escape_string($db, $subjectvalue);
		$bankvalue = mysqli_real_escape_string($db, $bankvalue);

		$sql = "SELECT returnId, standardSets_educationLevel FROM `Abre_Standards_Jurisdictions_StandardSets` WHERE (standardSets_subject='$subjectvalue' AND document_title='$bankvalue') GROUP BY standardSets_educationLevel ORDER BY standardSets_educationLevel";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc())
		{
			$returnId=htmlspecialchars($row["returnId"], ENT_QUOTES);
			$standardSets_educationLevel=htmlspecialchars($row["standardSets_educationLevel"], ENT_QUOTES);
			echo "<option value='$standardSets_educationLevel'>$standardSets_educationLevel</option>";
		}
	}
	else
	{
		echo "<option value=''></option>";
	}

?>
