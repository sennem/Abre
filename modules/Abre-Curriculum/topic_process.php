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

	//Add the topic
	if(isset($_POST["topicID"])){ $topic_title=mysqli_real_escape_string($db, $_POST["topic_title"]); }else{ $topic_title=""; }
	if($topic_title==""){ $topic_title="New Topic"; }
	if(isset($_POST["topic_theme"])){ $topic_theme=mysqli_real_escape_string($db, $_POST["topic_theme"]); }else{ $topic_theme=""; }
	if(isset($_POST["topic_start_time"])){
		$topic_start_time=$_POST["topic_start_time"];

		//Start Timestamp (Get Year)
		$dateyear = substr($topic_start_time, -4);

		//End Timestamp
		$datetime=date("m-d H:i:s", strtotime($topic_start_time));

		//Piece Together Timestamp
		$topic_start_time_timestamp="$dateyear-$datetime";

		$Unit_Start_Month=date("M", strtotime($topic_start_time));
		$Unit_Start_Day=date("d", strtotime($topic_start_time));
	}else{ $topic_start_time_timestamp=""; $Unit_Start_Month=""; $Unit_Start_Day=""; }
	if(isset($_POST["topic_estimated_days"])){ $topic_estimated_days=$_POST["topic_estimated_days"]; }else{ $topic_estimated_days=""; }
	$courseid=$_POST["courseID"];
	if(isset($_POST["topicID"])){ $topic_id=$_POST["topicID"]; }else{ $topic_id=""; }
	if($topic_id=="blank" or $topic_id=="")
	{
		$stmt = $db->stmt_init();
		$sql = "INSERT INTO curriculum_unit (Course_ID, Title, Description, Start_Time, Start_Time_Month, Start_Time_Day, Length) VALUES ('$courseid', '$topic_title', '$topic_theme', '$topic_start_time_timestamp', '$Unit_Start_Month', '$Unit_Start_Day', '$topic_estimated_days');";
		$stmt->prepare($sql);
		$stmt->execute();
		$topic_id=$stmt->insert_id;
		$stmt->close();
		$db->close();
	}
	else
	{
		mysqli_query($db, "UPDATE curriculum_unit set Title='$topic_title', Description='$topic_theme', Start_Time='$topic_start_time_timestamp', Start_Time_Month='$Unit_Start_Month', Start_Time_Day='$Unit_Start_Day', Length='$topic_estimated_days' where ID='$topic_id'") or die (mysqli_error($db));
	}

	$person = array("courseid"=>$courseid,"topicid"=>$topic_id,"message"=>"The topic has been saved.");
	header("Content-Type: application/json");
	echo json_encode($person);

?>