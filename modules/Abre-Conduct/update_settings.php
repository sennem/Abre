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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
  require(dirname(__FILE__) . '/../../core/abre_functions.php');

	//Update Directory Settings
	if(superadmin()){

    $sql = "SELECT COUNT(*) FROM conduct_settings";
    $query = $db->query($sql);
    $row = $query->fetch_assoc();
    $count = $row["COUNT(*)"];

    if(!isset($_POST["districtID"])){ $districtID = ""; }else{ $districtID = $_POST["districtID"]; }
    if(!isset($_POST["pdfSettings"])){ $pdf_options = ""; }else{ $pdf_options = $_POST["pdfSettings"]; }

		if($count > 0){
			$stmt = $db->stmt_init();
			$sql = "UPDATE `conduct_settings` SET districtID = ?, pdf_options = ?";
			$stmt->prepare($sql);
			$stmt->bind_param("ss", $districtID, $pdf_options);
			$stmt->execute();
		}else{
			$stmt = $db->stmt_init();
			$sql = "INSERT INTO `conduct_settings` (districtID, pdf_options) VALUES (?, ?);";
			$stmt->prepare($sql);
			$stmt->bind_param("ss", $districtID, $pdf_options);
			$stmt->execute();
		}

		$stmt->close();
		$db->close();
		echo "Settings have been updated.";
  }