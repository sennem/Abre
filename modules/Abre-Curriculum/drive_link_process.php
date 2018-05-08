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
	$topic_id = $_POST["topicID"];
	$course_id = $_POST["courseID"];
	$drive_link_title = mysqli_real_escape_string($db, $_POST["drive_link_title"]);
	$drive_link_url = mysqli_real_escape_string($db, $_POST["drive_link_url"]);
	$drive_link_category = "Drive";
	$stmt = $db->stmt_init();
	$sql = "INSERT INTO curriculum_resources (TopicID, Title, Link, Type) VALUES (?, ?, ?, ?);";
	$stmt->prepare($sql);
	$stmt->bind_param("isss", $topic_id, $drive_link_title, $drive_link_url, $drive_link_category);
	$stmt->execute();
	$stmt->close();
	$db->close();

	$response = array("topicId"=>$topic_id, "courseId"=>$course_id, "message"=>"The link has been added.");
	header("Content-Type: application/json");
	echo json_encode($response);

?>