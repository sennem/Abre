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

	if($_SESSION['usertype'] == 'staff'){

		$articletitle = "";
		if(isset($_GET['url'])){
			$url = base64_decode($_GET['url']);
			$url = mysqli_real_escape_string($db, $url);
		}else{
			$url = "";
		}
		if($url != ""){ $sql = "(SELECT * FROM streams_comments WHERE url = '$url' and comment != '' ORDER BY id DESC) ORDER BY id ASC LIMIT 100"; }

		//Display comments
		echo "<div id='commentthreadbox'><table cellpadding='0'>";
		$dbreturn = databasequery($sql);
		foreach($dbreturn as $row){
			$User = htmlspecialchars($row["user"], ENT_QUOTES);
			$Comment = htmlspecialchars($row["comment"], ENT_QUOTES);
			$Comment = nl2br(strip_tags(html_entity_decode($Comment)));
			$Comment = linkify($Comment);
			$articletitle = html_entity_decode($row["title"]);
			$CommentID = htmlspecialchars($row["id"], ENT_QUOTES);
			$CommentCreationTime = htmlspecialchars($row["creationtime"], ENT_QUOTES);

			//Display comment creation in correct format
			if(strtotime($CommentCreationTime) < strtotime('-7 days')){
				$CommentCreationTime = date( "F j", strtotime($CommentCreationTime))." at ".date( "g:i A", strtotime($CommentCreationTime));
		 	}else{
				$CommentCreationTime = date( "l", strtotime($CommentCreationTime))." at ".date( "g:i A", strtotime($CommentCreationTime));
			}

			//Look up name given email from directory
			$User2 = encrypt($User, "");
			$picture = "";
			$sql = "SELECT firstname, lastname, picture FROM directory WHERE email = '$User2'";
			$dbreturn = databasequery($sql);
			foreach($dbreturn as $row){
				$firstname = htmlspecialchars($row["firstname"], ENT_QUOTES);
				$firstname = stripslashes(htmlspecialchars(decrypt($firstname, ""), ENT_QUOTES));
				$lastname = htmlspecialchars($row["lastname"], ENT_QUOTES);
				$lastname = stripslashes(htmlspecialchars(decrypt($lastname, ""), ENT_QUOTES));
				$picture = htmlspecialchars($row["picture"], ENT_QUOTES);
			}

			echo "<tr class='commentwrapper'>";
				if(empty($picture)){
					$picture = $portal_root."/modules/directory/images/user.png";
				}else{
					$picture = $portal_root."/modules/directory/serveimage.php?file=$picture";
				}
				echo "<td width='60px' style='vertical-align: top;'><img src='$picture' class='profile-avatar-small'></td>";
				echo "<td width='100%'>";

					if(!empty($firstname)){
						echo "<span style='font-weight:700; font-size:16px;'>$firstname $lastname</span>";
					}else{
						echo "<span style='font-weight:700; font-size:16px;'>$User</span>";
					}

					if($User == $_SESSION['useremail']){
						echo "<span style='position:relative; top:5px; left:10px'><a href='#' data-commentid='$CommentID' class='mdl-color-text--grey commentdelete pointer'><i class='material-icons' style='font-size:20px'>clear</i></a></span>";
					}

					echo "<p style='margin-bottom:0px;' class='wrap-links'>$Comment</p><p style='color:#888; font-size:14px'>$CommentCreationTime</p>";
				echo "<td>";
			echo "</tr>";
			$firstname = "";
			$lastname = "";
			$picture = "";
		}
		echo "</table></div>";

?>

<script>

		$(function(){

			//Fill modal with content
			<?php if($articletitle != ""){ ?>
				$(".modal-content #streamTitle").text("<?php echo $articletitle; ?>");
				$(".modal-content #streamUrl").val("<?php echo base64_encode($url); ?>");
				$(".modal-content #streamTitleValue").val("<?php echo $articletitle; ?>");
			<?php } ?>

			//Scroll to bottom of the div
			var element = document.getElementById("modal-content-section");
			element.scrollTop = element.scrollHeight;

			//Delete a comment
			$(".commentdelete").unbind().click(function(event){
				event.preventDefault();
				var result = confirm("Remove this comment?");
				if(result){
					var url = $("#streamUrl").val();
					var id = $("#commentID").val();
					var redirect = $("#redirect").val();
					$(this).closest(".commentwrapper").hide();
					var CommentID = $(this).data('commentid');
					$.ajax({
						type: 'POST',
						url: 'modules/stream/comment_remove.php?commentid='+CommentID,
						data: '',
					})
					.done(function() {
						$.post( "modules/<?php echo basename(__DIR__); ?>/update_card.php", {url: url, redirect: redirect, type: "comment"})
						.done(function(data) {
							if(data.count == 0){
								$("#"+id).prev().addClass("mdl-color-text--grey-600");
								$("#"+id).prev().css("color", "");
								$("#"+id).css("color", "grey");
								$("#"+id).html(data.count);
							}else{
								$("#"+id).prev().removeClass("mdl-color-text--grey-600");
								$("#"+id).prev().css("color", "<?php echo getSiteColor(); ?>");
								$("#"+id).css("color", "<?php echo getSiteColor(); ?>");
								$("#"+id).html(data.count);
							}
							if(redirect == "comments"){
								if(data.currentusercount == 0){
									$("#"+id).closest('.card_stream').hide();
								}
								if(data.streamcardsleft == 0){
									$("#noCommentsMessage").show();
								}
							}
						});
					});
				}
			});

		});

</script>

<?php } ?>