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

	echo "<option value='' disabled='disabled' selected>Select a Bank</option>";

	if(!empty($subjectvalue))
	{

		$subjectvalue = mysqli_real_escape_string($db, $subjectvalue);

		$sql = "SELECT returnId, document_title FROM `Abre_Standards_Jurisdictions_StandardSets` WHERE standardSets_subject='$subjectvalue' GROUP BY document_title ORDER BY document_title";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc())
		{
			$standardSets_document_title=htmlspecialchars($row["document_title"], ENT_QUOTES);
			echo "<option value='$standardSets_document_title'>$standardSets_document_title</option>";
		}
	}
	else
	{
		echo "<option value=''></option>";
	}

?>
