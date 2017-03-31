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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	
	if($_SESSION['usertype']=='staff')
	{
		
		$articletitle="";
		if(isset($_GET['url'])){ $url=base64_decode($_GET['url']); }else{ $url=""; }	
		if($url!=""){ $sql = "(SELECT * FROM streams_comments where url='$url' and comment!='' ORDER BY id DESC) ORDER BY id ASC LIMIT 100"; }
			
		//Display comments
		echo "<div id='commentthreadbox'><table cellpadding='0'>";
		$dbreturn = databasequery($sql);
		foreach ($dbreturn as $row)
		{
			$User=htmlspecialchars($row["user"], ENT_QUOTES);
			$Comment=htmlspecialchars($row["comment"], ENT_QUOTES);
			$Comment=nl2br(strip_tags(html_entity_decode($Comment)));
			$Comment=linkify($Comment);
			$articletitle=html_entity_decode($row["title"]);
			$CommentID=htmlspecialchars($row["id"], ENT_QUOTES);
			$CommentCreationTime=htmlspecialchars($row["creationtime"], ENT_QUOTES);
			
			//Display comment creation in correct format
			if(strtotime($CommentCreationTime) < strtotime('-7 days'))
			{
				$CommentCreationTime=date( "F j", strtotime($CommentCreationTime))." at ".date( "g:i A", strtotime($CommentCreationTime));
		 	}
		 	else
		 	{
				$CommentCreationTime=date( "l", strtotime($CommentCreationTime))." at ".date( "g:i A", strtotime($CommentCreationTime));
			}
				
			//Look up name given email from directory
			$User2=encrypt($User, "");
			$picture="";
			$sql = "SELECT firstname, lastname, picture FROM directory where email='$User2'";
			$dbreturn = databasequery($sql);
			foreach ($dbreturn as $row)
			{
				$firstname=htmlspecialchars($row["firstname"], ENT_QUOTES);
				$firstname=stripslashes(htmlspecialchars(decrypt($firstname, ""), ENT_QUOTES));
				$lastname=htmlspecialchars($row["lastname"], ENT_QUOTES);
				$lastname=stripslashes(htmlspecialchars(decrypt($lastname, ""), ENT_QUOTES));
				$picture=htmlspecialchars($row["picture"], ENT_QUOTES);
			}
					
			echo "<tr class='commentwrapper'>";
				if(empty($picture)){ 
					$picture=$portal_root."/modules/directory/images/user.png";
				}
				else
				{
					$picture=$portal_root."/modules/directory/serveimage.php?file=$picture";
				}
				echo "<td width='60px' style='vertical-align: top;'><img src='$picture' class='profile-avatar-small'></td>";
				echo "<td width='100%'>";
			
					if(!empty($firstname))
					{
						echo "<span style='font-weight:700; font-size:16px;'>$firstname $lastname</span>";
					}
					else
					{
						echo "<span style='font-weight:700; font-size:16px;'>$User</span>";
					}
					
					if($User==$_SESSION['useremail'])
					{
						echo "<span style='position:relative; top:5px; left:10px'><a href='#' data-commentid='$CommentID' class='mdl-color-text--grey commentdelete pointer'><i class='material-icons' style='font-size:20px'>clear</i></a></span>";
					}
					
					echo "<p style='margin-bottom:0px;' class='wrap-links'>$Comment</p><p style='color:#888; font-size:14px'>$CommentCreationTime</p>";
				echo "<td>";
			echo "</tr>";
		}
		echo "</table></div>";
			
		?>
		
		<script>
			
			$(function()
			{
				
				//Fill modal with content
				<?php if($articletitle!=""){ ?>
					$(".modal-content #streamTitle").text("<?php echo $articletitle; ?>");
					$(".modal-content #streamUrl").val("<?php echo base64_encode($url); ?>");
					$(".modal-content #streamTitleValue").val("<?php echo $articletitle; ?>");
				<?php } ?>
				
				//Scroll to bottom of the div
				var element = document.getElementById("modal-content-section");
				element.scrollTop = element.scrollHeight;
				
				//Delete a comment
				$(".commentdelete").unbind().click(function(event)
				{				
					event.preventDefault();
					var result = confirm("Are you sure?");
					if (result)
					{
						$(this).closest(".commentwrapper").hide();
						var CommentID = $(this).data('commentid');
						$.ajax({
							type: 'POST',
							url: 'modules/stream/comment_remove.php?commentid='+CommentID,
							data: '',
						})
									
						.done(function() {
							$('#streamcards').load("modules/stream/stream_feeds.php", function () {	
								$('.grid').masonry( 'reloadItems' );
								$('.grid').masonry( 'layout' );
								mdlregister();
							});
							$('#streamlikes').load("modules/stream/stream_likes.php", function () {	
								mdlregister();
							});
						});
					}
				});
								
			});
				
		</script>
		
<?php } ?>