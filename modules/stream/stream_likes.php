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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	
	//Get Stream Limit
	$StreamStartResult = 0;
	if(isset($_GET["StreamStartResult"])){ $StreamStartResult = $_GET["StreamStartResult"]; }
	$StreamEndResult = 20;
	if(isset($_GET["StreamEndResult"])){ $StreamEndResult = $_GET["StreamEndResult"]; }
	
	//Determine total number of likes
	$query = "SELECT * FROM streams_comments WHERE user = '".$_SESSION['useremail']."' AND liked = '1' GROUP BY url ORDER BY ID DESC";
	$result=mysqli_query($db,$query);
	$totallikes=mysqli_num_rows($result);

	//Find what streams to display
	$query = "SELECT * FROM streams_comments WHERE user = '".$_SESSION['useremail']."' AND liked = '1' GROUP BY url ORDER BY ID DESC LIMIT $StreamStartResult, $StreamEndResult";
	$dbreturn = databasequery($query);
	$counter = 0;
	foreach($dbreturn as $value){
		$title = $value['title'];
		$titleencoded = base64_encode($title);
		$image = htmlspecialchars($value ['image'], ENT_QUOTES);
		$imagebase = base64_encode($image);
		$linkbase = base64_encode($value['url']);
		$linkescaped = htmlspecialchars($value['url'], ENT_QUOTES);
		$link = mysqli_real_escape_string($db, $value['url']);
		$creationtime = $value['creationtime'];
		$creationtime = date('F jS, Y',strtotime($creationtime));
		$counter++;

		//Comment count
		$query = "SELECT * FROM streams_comments WHERE url = '$link' AND comment != ''";
		$dbreturn = databasequery($query);
		$num_rows_comment = count($dbreturn);

		//Like count
		$query2 = "SELECT * FROM streams_comments WHERE url = '$link' AND comment = '' AND liked = '1'";
		$dbreturn2 = databasequery($query2);
		$num_rows_like = count($dbreturn2);

		//Display Card
		echo "<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>";
		
			//Feed
			echo "<div class='truncate' style='padding:16px 16px 0 16px; font-size: 12px; color: #999; font-weight: 500;'>You Liked This</div>";
		
			//Title
			echo "<div class='cardtitle' style='height:60px; padding:5px 16px 0 16px;'>";
				echo "<div class='mdl-card__title-text ellipsis-multiline cardclick pointer' data-link='$linkescaped' style='font-weight:700; font-size:20px; line-height:24px;'>$title</div>";
			echo "</div>";
			
			//Date
			echo "<div class='truncate' style='padding:0 16px 10px 16px; font-size: 12px; color: #999;'>$creationtime</div>";
	
			//Card Image
			if($image != ""){
				echo "<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' data-link='$linkescaped' style='height:200px; background-image: url($image);'></div>";
			}
			else
			{
					
				if(strlen($title) > 100){ 
					$body = substr($title, 0, strrpos( substr($title , 0, 100), ' ' ));
					$body = substr($title, 0, 97) . ' ...';
				}
				else
				{
					$body = $title;
				}
					
				echo "<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand valign-wrapper cardclick pointer' data-link='$linkescaped' style='height:200px; background-image: url(/core/images/abre_pattern.png); background-color: ".getSiteColor()." !important; overflow:hidden;'>";
					echo "<span style='width:100%; color:#fff; padding:32px; font-size:18px; line-height:normal; font-weight:700; text-align:center;'>$body</span>";
				echo "</div>";
				
			}
	
			//Card Actions
			echo "<div class='mdl-card__actions'>";
			
				//Read Button
				echo "<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='$linkescaped' style='color: ".getSiteColor()."' target='_blank'>Read</a>";
	
				//Share, Likes, Comments for Staff Only
				if($_SESSION['usertype'] == 'staff'){
					
					echo "<div class='mdl-layout-spacer'></div>";
					
					//Share
					echo "<a class='material-icons mdl-color-text--grey-600 modal-sharecard commenticon shareinfo' style='margin-right:30px;' data-url='$linkbase' title='Share' href='#sharecard'>share</a>";
	
					//Likes
					$query = "SELECT * FROM streams_comments WHERE url = '$link' AND liked = '1' AND user = '".$_SESSION['useremail']."'";
					$dbreturn = databasequery($query);
					$num_rows_like_current_user = count($dbreturn);
					if($num_rows_like == 0){
						echo "<a class='material-icons mdl-color-text--grey-600 likeicon' data-title='$titleencoded' data-url='$linkbase' data-image='$imagebase' title='Like' href='#'>favorite</a> <span class='mdl-color-text--grey-600' style='font-size:12px; font-weight:600; width:30px; padding-left:5px;'>$num_rows_like</span>";
					}else{
						if($num_rows_like_current_user == 0){
							echo "<a class='material-icons mdl-color-text--grey-600 likeicon' data-title='$titleencoded' data-url='$linkbase' data-image='$imagebase' href='#'>favorite</a> <span class='mdl-color-text--grey-600' style='font-size:12px; font-weight:600; width:30px; padding-left:5px;'>$num_rows_like</span>";
						}else{
							echo "<a class='material-icons mdl-color-text--red likeicon' data-title='$titleencoded' data-url='$linkbase' data-image='$imagebase' href='#'>favorite</a> <span class='mdl-color-text--red' style='font-size:12px; font-weight:600; width:30px; padding-left:5px;'>$num_rows_like</span>";
						}
					}
	
					//Comments
					if($num_rows_comment == 0){
						echo "<a class='material-icons mdl-color-text--grey-600 modal-addstreamcomment commenticon' data-commenticonid='comment_$counter' data-image='$imagebase' data-redirect='likes' data-title='$titleencoded' data-url='$linkbase' title='Add a comment' href='#addstreamcomment'>insert_comment</a><span id='comment_$counter' style='font-size:12px; font-weight:600; width:30px; padding-left:5px; color:grey'>$num_rows_comment</span>";
					}else{
						echo "<a class='material-icons modal-addstreamcomment commenticon' style='color: ".getSiteColor().";' data-commenticonid='comment_$counter' data-image='$imagebase' data-redirect='likes' data-title='$titleencoded' data-url='$linkbase' title='Add a comment' href='#addstreamcomment'>insert_comment</a> <span id='comment_$counter' style='font-size:12px; font-weight:600; width:30px; padding-left:5px; color: ".getSiteColor()."'>$num_rows_comment</span>";
					}
				}
	
			echo "</div>";
	
		echo "</div>";	
		
	}

	echo "<div id='noLikesMessage' class='row center-align' style='display:none;'><div class='col s12'><h6>No Likes yet</h6></div><div class='col s12'>Click the like button on a stream card to save the post to this page.</div></div>";
		

?>

<script>

	$(function(){

		var likedPosts = <?php echo $totallikes; ?>;
		if(likedPosts == 0){
			$("#noLikesMessage").show();
		}else{
			$("#noLikesMessage").hide();
		}
		
	  	//Make Streams Feeds Clickable
		$( ".cardclick" ).unbind().click(function(){
			window.open($(this).data('link'), '_blank');
		});

		//Like a Stream Post
		$(".likeicon").unbind().click(function(){

			event.preventDefault();

			var result = confirm("Remove from your likes?");
			if(result){

				var Stream_Title = $(this).data('title');
				var Stream_Url = $(this).data('url');
				var Stream_Image = $(this).data('image');

				var elementCount = $(this).next();
				var elementIcon = $(this);
				var card = $(this).closest('.card_stream');

				$.post("modules/stream/stream_like.php?url="+Stream_Url+"&title="+Stream_Title+"&image="+Stream_Image)
				.done(function(data) {
					$.post( "modules/<?php echo basename(__DIR__); ?>/update_card.php", {url: Stream_Url, type: "like"})
					.done(function(data) {
						if(data.count == 0){
							elementIcon.addClass("mdl-color-text--grey-600");
							elementCount.removeClass("mdl-color-text--red");
							elementCount.addClass("mdl-color-text--grey-600");
							card.hide();
							likedPosts--;
							elementCount.html(data.count);
						}else{
							if(data.currentusercount == 0){
								elementIcon.addClass("mdl-color-text--grey-600");
								elementIcon.removeClass("mdl-color-text--red");
								elementCount.addClass("mdl-color-text--grey-600");
								elementCount.removeClass("mdl-color-text--red");
								card.hide();
								likedPosts--;
								elementCount.html(data.count);
							}else{
								elementIcon.removeClass("mdl-color-text--grey-600");
								elementIcon.addClass("mdl-color-text--red");
								elementCount.removeClass("mdl-color-text--grey-600");
								elementCount.addClass("mdl-color-text--red");
								elementCount.html(data.count);
							}
						}
						if(likedPosts == 0){
							$("#noLikesMessage").show();
						}
					});
				});
			}
		});

		//Comment Modal
		$('.modal-addstreamcomment').leanModal({
			in_duration: 0,
			out_duration: 0,
			ready: function()
			{
				$("#streamComment").focus();
			}
		});

		//Fill comment modal
		$(document).off().on("click", ".modal-addstreamcomment", function (event){
			event.preventDefault();
			$("#commentloader").show();
			$("#streamComments").empty();
			var Stream_Title = $(this).data('title');
			Stream_Title_Decoded = atob(Stream_Title);
			$(".modal-content #streamTitle").text(Stream_Title_Decoded);
			$(".modal-content #streamTitleValue").val(Stream_Title_Decoded);
			var Stream_Url = $(this).data('url');
			$(".modal-content #streamUrl").val(Stream_Url);
			var commentID = $(this).data('commenticonid');
			$(".modal-content #commentID").val(commentID);
			var streamImage = $(this).data('image');
			$(".modal-content #streamImage").val(streamImage);
			var redirect = $(this).data('redirect');
			$(".modal-content #redirect").val(redirect);

			$( "#streamComments" ).load( "modules/stream/comment_list.php?url="+Stream_Url, function() {
				$("#commentloader").hide();
			});
		});

	});

</script>