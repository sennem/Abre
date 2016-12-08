<?php
	
	/*
	* Copyright 2015 Hamilton City School District	
	* 		
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	* 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	* 
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */
	
	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 	
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');	
	
	echo "<div class='page_container_limit'><div class='row'>";
	//Find what streams to display
	$query = "SELECT * FROM streams_comments where user='".$_SESSION['useremail']."' and liked='1' group by url order by ID DESC";
	$dbreturn = databasequery($query);
	$counter=0;
	foreach ($dbreturn as $value) {
		$title=htmlspecialchars($value ['title'], ENT_QUOTES);
		$titleencoded=base64_encode($title);
		$image=htmlspecialchars($value ['image'], ENT_QUOTES);
		$imagebase=base64_encode($image);
		$link=htmlspecialchars($value ['url'], ENT_QUOTES);
		$linkbase=base64_encode($link);
		$counter++;
		
		//Comment count
		$query = "SELECT * FROM streams_comments where url='$link' and comment!=''";
		$dbreturn = databasequery($query);
		$num_rows_comment = count($dbreturn);
		
		//Like count
		$query2 = "SELECT * FROM streams_comments where url='$link' and comment='' and liked='1'";
		$dbreturn2 = databasequery($query2);
		$num_rows_like = count($dbreturn2);
		
		echo "<div class='likes_$counter'>";
			$imagepath=$portal_root."/".$image;
			echo "<div class='col l3 m4 s6 nopaddingmarginsmall' style='margin-bottom:20px;'>";
				echo "<div class='mdl-card mdl-card__media mdl-shadow--2dp waves-effect waves-light' style='background-image: url($imagepath); background-color:#999; width:100%; height:100%;'>";
					echo "<div class='mdl-color-text--white valign-wrapper unlikelikedpost' data='$link' style='position:absolute; bottom:0; top: 0; left: 0; right: 0; padding:20px; background-color: rgba(0, 0, 0, 0.7);'>";
						echo "<span style='font-size:16px; line-height:22px; width:100%' class='valign center-align'>$title</span>";
					echo "</div>";
					
					echo "<a class='material-icons mdl-color-text--red unlikeicon' style='position:absolute; bottom:10px; right:100px;' data-title='$titleencoded' data-url='$linkbase' data-image='$imagebase' data-page='likes' data-resultcounter='likes_$counter' href='#'>favorite</a> <span class='mdl-color-text--white truncate' style='position:absolute; bottom:12px; right:10px; font-size:12px; font-weight:600; width:90px; padding-left:5px; text-align: left;'>$num_rows_like</span>";
					echo "<a class='material-icons modal-addstreamcomment commenticon' style='position:absolute; bottom:10px; right:40px; color: ".sitesettings("sitecolor")."' data-title='$titleencoded' data-url='$linkbase' title='Add a comment' href='#addstreamcomment'>insert_comment</a> <span class='mdl-color-text--white' style='position:absolute; bottom:12px; right:10px; font-size:12px; font-weight:600; width:30px; padding-left:5px; text-align: left;'>$num_rows_comment</span>";
					
				echo "</div>";
			echo "</div>";
		echo "</div>";
	}
	
	if($counter==0)
	{
		echo "<div class='row center-align'><div class='col s12'><h6>No Likes yet</h6></div><div class='col s12'>Click the like button on a stream card to save the post to this page.</div></div>";
	}
	
	echo "</div></div>";
		
?>

<script>
	
	$(function()
	{
	
	  	//Make the Likes clickable
		$( ".unlikelikedpost" ).click(function()
		{
			window.open($(this).attr("data"), '_blank');
		});
		
		//UnLike a Stream Post
		$(".unlikeicon").unbind().click(function()
		{
			
			event.preventDefault();
						
			var Stream_Title = $(this).data('title');
			var Stream_Url = $(this).data('url');
			var Stream_Image = $(this).data('image');
			var ResultCounter = $(this).data('resultcounter');
			$("."+ResultCounter).hide();
			$.post( "modules/stream/stream_like.php?url="+Stream_Url+"&title="+Stream_Title+"&image="+Stream_Image, function() { });
		
		});
		
	});
	
</script>

<script src='/modules/stream/commenting.js'></script>