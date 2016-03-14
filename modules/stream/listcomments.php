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
	
	$url=$_GET['url'];


	$sql = "(SELECT * FROM streams_comments where url='$url' ORDER BY id DESC) ORDER BY id ASC LIMIT 100";
	$result = $db->query($sql);
	$num_rows = mysql_num_rows($result);
	echo "<div id='commentthreadbox'><table cellpadding='0'>";
	while($row = $result->fetch_assoc())
	{
		$User=htmlspecialchars($row["user"], ENT_QUOTES);
		$Comment=htmlspecialchars($row["comment"], ENT_QUOTES);
		$Comment=strip_tags(html_entity_decode($Comment));
		$CommentID=htmlspecialchars($row["id"], ENT_QUOTES);
		$CommentCreationTime=htmlspecialchars($row["creationtime"], ENT_QUOTES);
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
		$sql2 = "SELECT firstname, lastname, picture FROM directory where email='$User2'";
		$result2 = $db->query($sql2);
		$num_rows2 = mysql_num_rows($result2);
		$picture="";
		while($row2 = $result2->fetch_assoc())
		{
			$firstname=htmlspecialchars($row2["firstname"], ENT_QUOTES);
			$firstname=stripslashes(htmlspecialchars(decrypt($firstname, ""), ENT_QUOTES));
			$lastname=htmlspecialchars($row2["lastname"], ENT_QUOTES);
			$lastname=stripslashes(htmlspecialchars(decrypt($lastname, ""), ENT_QUOTES));
			$picture=htmlspecialchars($row2["picture"], ENT_QUOTES);
			$num_rows2=1;
		}
			
			echo "<tr class='commentwrapper'>";
				if($picture==""){ 
					$picture='user.png'; 
					$picture=$portal_root."/modules/directory/serveimage.php?file=$picture&ext=.png";
				}
				else
				{
					$fileExtension = strrchr($picture, ".");
					$picture=$portal_root."/modules/directory/serveimage.php?file=$picture&ext=$fileExtension";
				}
				echo "<td width='60px' style='vertical-align: top;'><img src='$picture' class='profile-avatar-small'></td>";
				echo "<td width='100%'>";
	
					if($num_rows2!=0)
					{
						echo "<span style='font-weight:700; font-size:16px;'>$firstname $lastname</span><p style='margin-bottom:0px;'>$Comment</p><p style='color:#888; font-size:14px'>$CommentCreationTime</p>";
					}
					else
					{
						echo "<span style='font-weight:700; font-size:16px;'>$User</span><p>$Comment</p><p style='margin-bottom:0px;'>$CommentCreationTime</p>";
					}
				echo "<td>";
					if($User==$_SESSION['useremail'])
					{
						echo "<td style='vertical-align: top; width=30px;'><a href='modules/stream/removecomment.php?commentid=".$CommentID."' class='mdl-color-text--grey commentdeletebutton pointer'><i class='material-icons'>clear</i></a></td>";
					}
					else
					{
						echo "<td></td>"; 
					}
			echo "</tr>";
			$num_rows=1;
	}
	
	echo "</table></div>";
	
?>

<script>
	$(document).ready(function(){
		var element = document.getElementById("modal-content-section");
		element.scrollTop = element.scrollHeight;
	});
	
	$( ".commentdeletebutton" ).click(function() {
		
			event.preventDefault();
			$(this).closest(".commentwrapper").hide();
			var address = $(this).attr("href");
			$.ajax({
				type: 'POST',
				url: address,
				data: '',
			})
		
			.done(function() {
				$('#streamcards').load("modules/stream/stream_cards.php", function () {	
					$('.grid').masonry( 'reloadItems' );
					$('.grid').masonry( 'layout' );
					mdlregister();
				});
			});
	});
</script>