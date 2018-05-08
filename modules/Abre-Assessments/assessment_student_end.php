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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');

	//Variables
	$AssessmentID=mysqli_real_escape_string($db, $_POST["AssessmentID"]);
	$currenttime=date('Y-m-d H:i:s');

	//Check to see how many questions were on assessment
	$sql = "SELECT count(*) FROM assessments_questions WHERE Assessment_ID='$AssessmentID'";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{
		$totalquestions=$row["count(*)"];
	}

	//Check to see how many questions user has answered
	$sql = "SELECT count(*) FROM assessments_scores WHERE Assessment_ID='$AssessmentID' AND User='".$_SESSION['useremail']."'";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{
		$answeredquestions=$row["count(*)"];
	}

	//Complete assessment if user has answered all questions
	if($totalquestions == $answeredquestions)
	{

		//Close assessment
		mysqli_query($db, "UPDATE assessments_status set End_Time='$currenttime' where Assessment_ID='$AssessmentID' and User='".$_SESSION['useremail']."'") or die (mysqli_error($db));

		//Save final assessment result
		AssessmentResultsScore($AssessmentID, $_SESSION['useremail']);

		echo "yes";

	}
	else {

		echo "no";

	}

	//Close Database
	$db->close();

?>
