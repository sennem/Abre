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

	//Update book information
	$bookId = $_POST["modifiedbookid"];
  $bookTitle = $_POST["modifiedbooktitle"];
  $bookAuthor = $_POST["modifiedbookauthor"];
  if(isset($_POST["modifiedbookstudentrequired"])){
    $studentRequired = $_POST["modifiedbookstudentrequired"];
  }else{
    $studentRequired = 0;
  }
  if(isset($_POST["modifiedbookstaffrequired"])){
    $staffRequired = $_POST["modifiedbookstaffrequired"];
  }else{
    $staffRequired = 0;
  }

  $stmt = $db->stmt_init();
  $sql = "UPDATE books SET Title = ?, Author = ?, Students_Required = ?, Staff_Required = ? WHERE ID = ?";
  $stmt->prepare($sql);
  $stmt->bind_param("ssiii", $bookTitle, $bookAuthor, $studentRequired, $staffRequired, $bookId);
  $stmt->execute();
  $stmt->close();

  echo "The book has been updated.";

?>