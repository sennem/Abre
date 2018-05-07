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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	$boardcode = $_GET["code"];
	$boardcode = preg_replace("/[^0-9]/","", $boardcode);

	if($boardcode != NULL){
		$sql = "SELECT ID, Code, Title FROM guide_boards WHERE Code = '$boardcode' LIMIT 1";
		$result = $db->query($sql);
		$rowcount = mysqli_num_rows($result);
		while($row = $result->fetch_assoc()){
			$Board_ID = htmlspecialchars($row["ID"], ENT_QUOTES);
			$Code = htmlspecialchars($row["Code"], ENT_QUOTES);
			$Title = html_entity_decode($row['Title']);

			$sql2 = "SELECT Data FROM guide_links WHERE Board_ID = '$Board_ID'";
			$result2 = $db->query($sql2);
			while($row2 = $result2->fetch_assoc()){
				$jsondata = $row2["Data"];
				$json = json_decode($jsondata, true);

				$website_1 = $json['Website 1']; $link_1 = $json['Link 1']; $image_1 = $json['Image 1'];
				$website_2 = $json['Website 2']; $link_2 = $json['Link 2']; $image_2 = $json['Image 2'];
				$website_3 = $json['Website 3']; $link_3 = $json['Link 3']; $image_3 = $json['Image 3'];
				$website_4 = $json['Website 4']; $link_4 = $json['Link 4']; $image_4 = $json['Image 4'];
				$website_5 = $json['Website 5']; $link_5 = $json['Link 5']; $image_5 = $json['Image 5'];
				$website_6 = $json['Website 6']; $link_6 = $json['Link 6']; $image_6 = $json['Image 6'];
				$website_7 = $json['Website 7']; $link_7 = $json['Link 7']; $image_7 = $json['Image 7'];
				$website_8 = $json['Website 8']; $link_8 = $json['Link 8']; $image_8 = $json['Image 8'];
				$favoritesite = $json['Favorite'];
				$restrictionmode = $json['RestrictionMode'];

				$array = array(
					'Website1' => $website_1, 'Website2' => $website_2, 'Website3' => $website_3, 'Website4' => $website_4,
					'Website5' => $website_5, 'Website6' => $website_6, 'Website7' => $website_7, 'Website8' => $website_8,
					'Link1' => $link_1, 'Link2' => $link_2, 'Link3' => $link_3, 'Link4' => $link_4,
					'Link5' => $link_5, 'Link6' => $link_6, 'Link7' => $link_7, 'Link8' => $link_8,
					'Image1' => $image_1, 'Image2' => $image_2, 'Image3' => $image_3, 'Image4' => $image_4,
					'Image5' => $image_5, 'Image6' => $image_6, 'Image7' => $image_7, 'Image8' => $image_8,
					'Favorite' => $favoritesite,
					'RestrictionMode' => $restrictionmode
				);
				$jsondata = json_encode($array);
				print_r($jsondata);
			}
		}

		if($rowcount == 0){
			echo "Nothing Found";
		}
	}else {
		echo "Invalid Code";
	}

	$db->close();

?>