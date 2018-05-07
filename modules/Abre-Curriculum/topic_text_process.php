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
	$topic_id=$_POST["topicID"];
	$courseid=$_POST["courseID"];
	$resourceid=$_POST["resourceID"];
	$topic_text_title=mysqli_real_escape_string($db, $_POST["topic_text_title"]);
	$topic_text_category=$_POST["topic_text_category"];
	$stmt = $db->stmt_init();
	$topic_text_content=mysqli_real_escape_string($db, $_POST["topic_text_content"]);
	if($resourceid=="")
	{
		$sql = "INSERT INTO curriculum_resources (TopicID, Title, Text, Type) VALUES ('$topic_id', '$topic_text_title', '$topic_text_content', '$topic_text_category');";
	}
	else
	{
		$sql = "UPDATE curriculum_resources set Title='$topic_text_title', Text='$topic_text_content', Type='$topic_text_category' WHERE ID='$resourceid';";
	}
	$stmt->prepare($sql);
	$stmt->execute();
	$stmt->close();
	$db->close();

	$person = array("topicid"=>$topic_id,"courseid"=>$courseid,"message"=>"The text has been added.");
	header("Content-Type: application/json");
	echo json_encode($person);
	
?>