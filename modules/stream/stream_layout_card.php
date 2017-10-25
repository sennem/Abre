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

	$linkbase = base64_encode($link);
	$imagebase = base64_encode($image);
	$displaydate = date("F jS, Y", $date);

	$titleencoded = base64_encode($title);
	//Shorten Excerpt if needed
  if (strlen($excerpt) >= 200) {
      $excerpt = substr($excerpt, 0, 200). " ... " . substr($excerpt, -5);
  }

	echo "<div class='mdl-card mdl-shadow--2dp card_stream'>";

		if($image != ""){
			echo "<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand' style='height:200px; background-image: url($image);'></div>";
		};

		echo "<div class='mdl-card__title'><div class='mdl-card__title-text'>$title</div></div>";
		echo "<div class='mdl-card__supporting-text-subtitle' style='margin:0 0 25px 15px;'><span>$displaydate</span></div>";
		echo "<div class='mdl-card__supporting-text-subtitle'><a href='$feedlink' style='color: ".getSiteColor()."' target='_blank'>$feedtitle</a></div>";
		if($excerpt != ""){ echo "<div class='mdl-card__supporting-text'>$excerpt</div>"; }
		echo "<div class='mdl-card__actions mdl-card--border'>";
			echo "<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='$link' style='color: ".getSiteColor()."' target='_blank'>$linklabel</a>";

			if($_SESSION['usertype'] == 'staff'){
				echo "<div class='mdl-layout-spacer'></div>";

				echo "<a class='material-icons mdl-color-text--grey-600 modal-sharecard commenticon shareinfo' style='margin-right:30px;' data-url='$linkbase' title='Share' href='#sharecard'>share</a>";

				$query = "SELECT * FROM streams_comments WHERE url = '$link' AND liked = '1' AND user = '".$_SESSION['useremail']."'";
				$dbreturn = databasequery($query);
				$num_rows_like_current_user = count($dbreturn);

				if($num_rows_like == 0){
					echo "<a class='material-icons mdl-color-text--grey-600 likeicon' style='margin-right:30px;' data-title='$titleencoded' data-category='$feedtitle' data-excerpt='$excerpt' data-url='$linkbase' data-image='$imagebase' title='Like' href='#'>favorite</a>";
				}else{
					if($num_rows_like_current_user == 0){
						echo "<a class='material-icons mdl-color-text--grey-600 likeicon' data-title='$titleencoded' data-category='$feedtitle' data-excerpt='$excerpt' data-url='$linkbase' data-image='$imagebase' href='#'>favorite</a> <span class='mdl-color-text--grey-600' style='font-size:12px; font-weight:600; width:30px; padding-left:5px;'>$num_rows_like</span>";
					}else{
						echo "<a class='material-icons mdl-color-text--red likeicon' data-title='$titleencoded' data-category='$feedtitle' data-excerpt='$excerpt' data-url='$linkbase' data-image='$imagebase' href='#'>favorite</a> <span class='mdl-color-text--red' style='font-size:12px; font-weight:600; width:30px; padding-left:5px;'>$num_rows_like</span>";
					}
				}

				if($num_rows_comment == 0){
					echo "<a class='material-icons mdl-color-text--grey-600 modal-addstreamcomment commenticon' data-title='$titleencoded' data-category='$feedtitle' data-excerpt='$excerpt' data-url='$linkbase' title='Add a comment' href='#addstreamcomment' style='padding-right:30px;'>insert_comment</a>";
				}else{
					echo "<a class='material-icons modal-addstreamcomment commenticon' style='color: ".getSiteColor()."' data-title='$titleencoded' data-category='$feedtitle' data-excerpt='$excerpt' data-url='$linkbase' title='Add a comment' href='#addstreamcomment'>insert_comment</a> <span style='font-size:12px; font-weight:600; width:30px; padding-left:5px; color: ".getSiteColor()."'>$num_rows_comment</span>";
				}
			}

		echo "</div>";

		//Get Last Comment
		$querycomment = "SELECT * FROM streams_comments WHERE url = '$link' and comment != '' ORDER BY ID DESC LIMIT 1";
		$dbreturncomment = databasequery($querycomment);
		$dbreturncomment_count = count($dbreturncomment);
		foreach($dbreturncomment as $value){
			$useremail = htmlspecialchars($value ['user'], ENT_QUOTES);
			$comment = htmlspecialchars($value ['comment'], ENT_QUOTES);

			//Look up name given email from directory
			$User2 = encrypt($useremail, "");
			$picture = "";
			$sql = "SELECT firstname, lastname, picture FROM directory WHERE email = '$User2'";
			$dbreturn = databasequery($sql);
			$firstname = NULL;
			$lastname = NULL;
			foreach($dbreturn as $row){
				$firstname = htmlspecialchars($row["firstname"], ENT_QUOTES);
				$firstname = stripslashes(htmlspecialchars(decrypt($firstname, ""), ENT_QUOTES));
				$lastname = htmlspecialchars($row["lastname"], ENT_QUOTES);
				$lastname = stripslashes(htmlspecialchars(decrypt($lastname, ""), ENT_QUOTES));
				$picture = htmlspecialchars($row["picture"], ENT_QUOTES);
			}

				if(empty($picture)){
					$picture = $portal_root."/modules/directory/images/user.png";
				}else{
					$picture = $portal_root."/modules/directory/serveimage.php?file=$picture";
				}

			echo "<div class='mdl-card__actions modal-addstreamcomment commenticon pointer' style='background-color:#f9f9f9; padding:20px;' href='#addstreamcomment' data-title='$titleencoded' data-category='$feedtitle' data-excerpt='$excerpt' data-url='$linkbase'>";
				echo "<span style='font-weight:500; font-size:12px;' class='truncate'><img src='$picture' class='profile-avatar-small' style='margin-right:5px;'>";

					if($firstname == NULL && $lastname == NULL){
						echo "A comment was added";
					}else{
						echo "$firstname $lastname added a comment";
					}
				echo "</span>";
			echo "</div>";
		}
	echo "</div>";

?>