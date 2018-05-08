<?php

	/*
	* Copyright (C) 2016-2017 Abre.io LLC
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
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');

	require_once('permissions.php');

	if($pagerestrictions == ""){

		$id = mysqli_real_escape_string($db, $_GET["id"]);

		//Remove the Generated Images from Server
		$sql = "SELECT Data FROM guide_links WHERE Board_ID = '$id'";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc()){
			$jsondata = $row["Data"];
			$json = json_decode($jsondata, true);

			$image_1 = $json['Image 1'];
			$image_2 = $json['Image 2'];
			$image_3 = $json['Image 3'];
			$image_4 = $json['Image 4'];
			$image_5 = $json['Image 5'];
			$image_6 = $json['Image 6'];
			$image_7 = $json['Image 7'];
			$image_8 = $json['Image 8'];

			for($x = 1; $x <= 8; $x++){
				$imagepath = ${"image_" . $x};
				$img = $portal_path_root.'/../private/guide/'.$imagepath;
				if($imagepath != ""){
					if(file_exists($img)){
						unlink($img);
					}
				}
			}
		}

		//Remove from Inventory
		include "../../core/abre_dbconnect.php";
		$stmt = $db->stmt_init();
		$sql = "DELETE FROM guide_links WHERE Board_ID = '$id'";
		$stmt->prepare($sql);
		$stmt->execute();
		$stmt->close();
		$db->close();

		//Remove from Libraries
		include "../../core/abre_dbconnect.php";
		$stmt = $db->stmt_init();
		$sql = "DELETE FROM guide_boards WHERE ID = '$id' LIMIT 1";
		$stmt->prepare($sql);
		$stmt->execute();
		$stmt->close();
		$db->close();

		echo "Lesson Deleted!";

	}

?>