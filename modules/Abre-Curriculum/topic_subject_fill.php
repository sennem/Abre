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

	$jurisdictionvalue=$_GET["jurisdiction"];

	echo "<option value='' disabled='disabled' selected>Select a Subject</option>";

	if(!empty($jurisdictionvalue))
	{

		$jurisdictionvalue = mysqli_real_escape_string($db, $jurisdictionvalue);

		$sql = "SELECT standardSets_subject FROM `Abre_Standards_Jurisdictions_StandardSets` WHERE returnId = '$jurisdictionvalue' GROUP BY standardSets_subject ORDER BY standardSets_subject";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc())
		{
			$standardSets_subject=htmlspecialchars($row["standardSets_subject"], ENT_QUOTES);
			echo "<option value='$standardSets_subject'>$standardSets_subject</option>";
		}
	}
	else
	{
		echo "<option value=''></option>";
	}

?>
