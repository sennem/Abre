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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('permissions.php');

	if($pagerestrictions=="")
	{

		//Add the book to user library
		$lesson_title=htmlspecialchars($_POST["lesson_title"], ENT_QUOTES);
		$lesson_id=$_POST["lesson_id"];
		$website_title_0=htmlspecialchars($_POST["website_title_0"], ENT_QUOTES);	$website_link_0=$_POST["website_link_0"];
		$website_title_1=htmlspecialchars($_POST["website_title_1"], ENT_QUOTES);	$website_link_1=$_POST["website_link_1"];
		$website_title_2=htmlspecialchars($_POST["website_title_2"], ENT_QUOTES);	$website_link_2=$_POST["website_link_2"];
		$website_title_3=htmlspecialchars($_POST["website_title_3"], ENT_QUOTES);	$website_link_3=$_POST["website_link_3"];
		$website_title_4=htmlspecialchars($_POST["website_title_4"], ENT_QUOTES);	$website_link_4=$_POST["website_link_4"];
		$website_title_5=htmlspecialchars($_POST["website_title_5"], ENT_QUOTES);	$website_link_5=$_POST["website_link_5"];
		$website_title_6=htmlspecialchars($_POST["website_title_6"], ENT_QUOTES);	$website_link_6=$_POST["website_link_6"];
		$website_title_7=htmlspecialchars($_POST["website_title_7"], ENT_QUOTES);	$website_link_7=$_POST["website_link_7"];

		$favorite_link=$_POST["favorite_link"];
		$restrictionsetting=$_POST["restrictionsetting"];

		if($lesson_title!="")
		{
			$email=$_SESSION['useremail'];

			$allCodes = array();
			$sql = "SELECT Code FROM guide_boards";
			$dbreturn = databasequery($sql);
			foreach($dbreturn as $value){
				array_push($allCodes, $value["Code"]);
			}

			do{
				//Create coupon code
				$code = mt_rand(10000, 99999);
			}while(in_array($code, $allCodes));

			//Add to board
			if($lesson_id=="")
			{
				$stmt = $db->stmt_init();
				$sql = "INSERT INTO guide_boards (Title, Code, Creator) VALUES ('$lesson_title', '$code', '$email');";
				$stmt->prepare($sql);
				$stmt->execute();
				$boardid = $stmt->insert_id;
				$stmt->close();
			}
			else
			{
				mysqli_query($db, "UPDATE guide_boards set Title='$lesson_title' where ID='$lesson_id'") or die (mysqli_error($db));
			}

			//Add to links
			$time=time();
			$filename="$time.jpg";

			if($website_link_0!=""){ $website_image_0="0_".$filename; }else{ $website_image_0=""; };
			if($website_link_1!=""){ $website_image_1="1_".$filename; }else{ $website_image_1=""; };
			if($website_link_2!=""){ $website_image_2="2_".$filename; }else{ $website_image_2=""; };
			if($website_link_3!=""){ $website_image_3="3_".$filename; }else{ $website_image_3=""; };
			if($website_link_4!=""){ $website_image_4="4_".$filename; }else{ $website_image_4=""; };
			if($website_link_5!=""){ $website_image_5="5_".$filename; }else{ $website_image_5=""; };
			if($website_link_6!=""){ $website_image_6="6_".$filename; }else{ $website_image_6=""; };
			if($website_link_7!=""){ $website_image_7="7_".$filename; }else{ $website_image_7=""; };

			$array = [	"Website 1" => "$website_title_0",
						"Website 2" => "$website_title_1",
						"Website 3" => "$website_title_2",
						"Website 4" => "$website_title_3",
						"Website 5" => "$website_title_4",
						"Website 6" => "$website_title_5",
						"Website 7" => "$website_title_6",
						"Website 8" => "$website_title_7",
						"Link 1" => "$website_link_0",
						"Link 2" => "$website_link_1",
						"Link 3" => "$website_link_2",
						"Link 4" => "$website_link_3",
						"Link 5" => "$website_link_4",
						"Link 6" => "$website_link_5",
						"Link 7" => "$website_link_6",
						"Link 8" => "$website_link_7",
						"Image 1" => "$website_image_0",
						"Image 2" => "$website_image_1",
						"Image 3" => "$website_image_2",
						"Image 4" => "$website_image_3",
						"Image 5" => "$website_image_4",
						"Image 6" => "$website_image_5",
						"Image 7" => "$website_image_6",
						"Image 8" => "$website_image_7",
						"Favorite" => "$favorite_link",
						"RestrictionMode" => "$restrictionsetting"
					];

			$json = json_encode($array);

			if($lesson_id=="")
			{
				$stmt = $db->stmt_init();
				$sql = "INSERT INTO guide_links (Board_ID, Data) VALUES ('$boardid', '$json');";
				$stmt->prepare($sql);
				$stmt->execute();
				$guidelinkid = $stmt->insert_id;
				$stmt->close();
				$db->close();
				$person = array("queryid"=>$guidelinkid,"message"=>"Lesson created!");
			}
			else
			{

				//Remove the Generated Images from Server
				$sql3 = "SELECT Data FROM guide_links where Board_ID='$lesson_id'";
				$result3 = $db->query($sql3);
				while($row3 = $result3->fetch_assoc())
				{
					$jsondata=$row3["Data"];
					$jsonold=json_decode($jsondata, true);

					$image_1=$jsonold['Image 1'];
					$image_2=$jsonold['Image 2'];
					$image_3=$jsonold['Image 3'];
					$image_4=$jsonold['Image 4'];
					$image_5=$jsonold['Image 5'];
					$image_6=$jsonold['Image 6'];
					$image_7=$jsonold['Image 7'];
					$image_8=$jsonold['Image 8'];

					for ($x = 1; $x <= 8; $x++)
					{
						$imagepath=${"image_" . $x};
						$img=$portal_path_root.'/../private/guide/'.$imagepath;
						if($imagepath!="")
						{
							if (file_exists($img)) {
								unlink($img);
		    				}
						}
					}
				}

				mysqli_query($db, "UPDATE guide_links set Data='$json', Screenshots='0' where Board_ID='$lesson_id'") or die (mysqli_error($db));
				$sql = "SELECT ID FROM guide_links where Board_ID='$lesson_id' LIMIT 1";
				$result = $db->query($sql);
				while($row = $result->fetch_assoc())
				{
					$ID=htmlspecialchars($row["ID"], ENT_QUOTES);
					$person = array("queryid"=>$ID,"message"=>"Lesson updated");
				}
			}

		}
		header("Content-Type: application/json");
		echo json_encode($person);
	}

?>