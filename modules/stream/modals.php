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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');	
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');	
	
	//Check for variable in url
	if(isset($_GET['discussion'])){ 
		$discussionid=$_GET['discussion']; 
		$discussionid=preg_replace("/[^0-9]/","",$discussionid);
	}
	
	?>
	
	<!-- Commenting Modal -->
	<?php
	if($_SESSION['usertype']=='staff')
	{
	?>
		<div id="addstreamcomment" class="modal modal-fixed-footer modal-mobile-full">
			<form id="form-addstreamcomment" method="post" action="modules/stream/comment_add.php">
			<div class="modal-content" id="modal-content-section">
				<div id="commentloader" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="width:100%"></div>
				<div name="streamComments" id="streamComments"></div>
				<div class="input-field col s12">
					<h4 name="streamTitle" id="streamTitle"></h4>
					<b style='color: <?php echo sitesettings("sitecolor"); ?>;' id="commentstatustext">Write a comment</b>
					<textarea id="streamComment" name="streamComment" class="materialize-textarea" required></textarea>
				</div>
				<input type="hidden" name="streamUrl" id="streamUrl">
				<input type="hidden" name="streamTitleValue" id="streamTitleValue">
	    	</div>
		    <div class="modal-footer">
				<button class="btn waves-effect btn-flat white-text" type="submit" name="action" style='margin-left:5px; background-color:<?php echo sitesettings("sitecolor"); ?>'>Post</button>
				<button class="modal-action modal-close waves-effect btn-flat white-text" style='background-color: <?php echo sitesettings("sitecolor"); ?>'>Close</button>
			</div>
			</form>
		</div>
	<?php
	}
	?>
	
<script>
	
	//Save comment
	var form = $('#form-addstreamcomment');			
	$(form).submit(function(event) {
		event.preventDefault();
		$("#commentstatustext").text("Posting comment...");
		var formData = $(form).serialize();
		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),
			data: formData
		})
							
		//Show the notification
		.done(function(response) {
			$( "#streamComments" ).load( "modules/stream/comment_list.php?url="+response, function() {
				$("textarea").val('');
				$("#commentstatustext").text("Write a comment");
				$(".modal-content #streamUrl").val(response);
				var element = document.getElementById("commentthreadbox");
				element.scrollTop = element.scrollHeight;
				$('#streamcards').load("modules/stream/stream_feeds.php", function () {	
					$('.grid').masonry( 'reloadItems' );
					$('.grid').masonry( 'layout' );
					mdlregister();
				});
				$('#streamlikes').load("modules/stream/stream_likes.php", function () {
					mdlregister();
				});
			});			
		})						
	});
	
</script>