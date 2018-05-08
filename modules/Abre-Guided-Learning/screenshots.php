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
	require_once('/home/hcsdohorg/public_html/core/abre_dbconnect.php');

	//Save Screenshot to server
	function savescreenshot($website, $filename)
	{
		//Get Image and Use Google Page Speed API
		$website = $website;
		$api = "https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$website&screenshot=true";
		$string = file_get_contents($api);
		$json = json_decode($string, true);

		//Get Data from JSON
		$data=$json['screenshot']['data'];

		//Replace characters for correct decode
		$data=str_replace("_","/",$data);
		$data=str_replace("-","+",$data);

		//Decode base64
		$data = base64_decode($data);

		//Save image to server
		$im = imagecreatefromstring($data);

		if (!file_exists("/home/hcsdohorg/private/guide")) {
			mkdir("/home/hcsdohorg/private/guide", 0777, true);
		}

		imagejpeg($im, "/home/hcsdohorg/private/guide/$filename");
	}

	//Add the book to user library
	$query = "SELECT ID, Data FROM guide_links where Screenshots='0'";
	$result = $db->query($query);
	while($value = $result->fetch_assoc())
	{
		$ID=$value['ID'];
		$datajson=$value['Data'];
		$json=json_decode($datajson, true);

		$link_1=$json['Link 1']; $image_1=$json['Image 1']; if($link_1!="" && $image_1!=""){ savescreenshot($link_1, $image_1); }
		$link_2=$json['Link 2']; $image_2=$json['Image 2']; if($link_2!="" && $image_2!=""){ savescreenshot($link_2, $image_2); }
		$link_3=$json['Link 3']; $image_3=$json['Image 3']; if($link_3!="" && $image_3!=""){ savescreenshot($link_3, $image_3); }
		$link_4=$json['Link 4']; $image_4=$json['Image 4']; if($link_4!="" && $image_4!=""){ savescreenshot($link_4, $image_4); }
		$link_5=$json['Link 5']; $image_5=$json['Image 5']; if($link_5!="" && $image_5!=""){ savescreenshot($link_5, $image_5); }
		$link_6=$json['Link 6']; $image_6=$json['Image 6']; if($link_6!="" && $image_6!=""){ savescreenshot($link_6, $image_6); }
		$link_7=$json['Link 7']; $image_7=$json['Image 7']; if($link_7!="" && $image_7!=""){ savescreenshot($link_7, $image_7); }
		$link_8=$json['Link 8']; $image_8=$json['Image 8']; if($link_8!="" && $image_8!=""){ savescreenshot($link_8, $image_8); }

		//Update record
		mysqli_query($db, "UPDATE guide_links set Screenshots='1' where ID='$ID'") or die (mysqli_error($db));
	}
	$db->close();


?>