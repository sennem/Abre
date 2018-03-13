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


  $postAuthor = $_SESSION['useremail'];
  $sql = "SELECT firstname, lastname FROM directory WHERE email = '$postAuthor'";
  $result = $db->query($sql);
  $resultrow = $result->fetch_assoc();
  $authorFirstName = $resultrow['firstname'];
  $authorLastName = $resultrow['lastname'];

  if(isset($_POST['post_title'])){
    $postTitle = $_POST['post_title'];
  }else{

  }
  if(isset($_POST['post_stream'])){
    $postStream = $_POST['post_stream'];
  }else{

  }

	$sql = "SELECT `group`, staff_building_restrictions, student_building_restrictions FROM streams WHERE title = '$postStream' LIMIT 1";
	$result = $db->query($sql);
	$value = $result->fetch_assoc();
	$postGroup = $value['group'];
	$staffRestrictions = $value['staff_building_restrictions'];
	$studentRestrictions = $value['student_building_restrictions'];

	if($staffRestrictions == ""){
		$staffRestrictions = "No Restrictions";
	}

	if($studentRestrictions == ""){
		$studentRestrictions = "No Restrictions";
	}

  if(isset($_POST['post_content'])){
    $postContent = $_POST['post_content'];
  }else{

  }

  $stmt = $db->stmt_init();
  $sql = "INSERT INTO stream_posts (post_author, author_firstname, author_lastname, post_groups, post_title, post_stream, post_content, staff_building_restrictions, student_building_restrictions) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt->prepare($sql);
  $stmt->bind_param("sssssssss", $postAuthor, $authorFirstName, $authorLastName, $postGroup, $postTitle, $postStream, $postContent, $staffRestrictions, $studentRestrictions);
  $stmt->execute();
  $stmt->close();

  $db->close();
  $response = array("status" => "Success", "message" => "Your post was saved successfully!");
  header("Content-Type: application/json");
  echo json_encode($response);


  ?>