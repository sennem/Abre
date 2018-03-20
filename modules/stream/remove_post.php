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

  if($_POST['id'] != ""){
    $id = $_POST['id'];
  }else{
    $response = array("status" => "Error", "message" => "There was a problem deleting your post. Try again!");
    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
  }
  
  	//Look Up Post and Delete Image from Server if one exists
  	$query = "SELECT post_image FROM stream_posts WHERE id = '$id'";
	$result = $db->query($query);
	while($resultrow = $result->fetch_assoc()){
		$post_image = $resultrow["post_image"];
		
		$filepath = "$portal_path_root/../$portal_private_root/stream/cache/images/$post_image";
		if(file_exists($filepath)){
			unlink($filepath);
		}		
	}

  //Delete Post
  $stmt = $db->stmt_init();
  $sql = "DELETE FROM stream_posts WHERE id = ?";
  $stmt->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  if($stmt->error != ""){
    $response = array("status" => "Error", "message" => "There was a problem deleting your post.");
    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
  }
  $stmt->close();
  $db->close();

  $response = array("status" => "Success", "message" => "Your post has been deleted.");
  header("Content-Type: application/json");
  echo json_encode($response);




?>