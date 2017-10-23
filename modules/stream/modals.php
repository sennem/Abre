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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	//Check for variable in url
	if(isset($_GET['discussion'])){
		$discussionid = $_GET['discussion'];
		$discussionid = preg_replace("/[^0-9]/","",$discussionid);
	}

?>

	<!-- Commenting Modal -->
	<?php
	if($_SESSION['usertype']=='staff'){
	?>
		<div id="addstreamcomment" class="modal modal-fixed-footer modal-mobile-full">
			<form id="form-addstreamcomment" method="post" action="modules/stream/comment_add.php">
				<div class="modal-content" id="modal-content-section">
					<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
					<div id="commentloader" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="width:100%"></div>
					<div name="streamComments" id="streamComments"></div>
					<div class="input-field col s12">
						<h4 name="streamTitle" id="streamTitle"></h4>
						<b style='color: <?php echo getSiteColor(); ?>;' id="commentstatustext">Write a comment</b>
						<textarea id="streamComment" name="streamComment" class="materialize-textarea" required></textarea>
					</div>
					<input type="hidden" name="streamUrl" id="streamUrl">
					<input type="hidden" name="streamTitleValue" id="streamTitleValue">
		    </div>
			  <div class="modal-footer">
					<button class="btn waves-effect btn-flat white-text" type="submit" name="action" style='margin-left:5px; background-color:<?php echo getSiteColor(); ?>'>Post</button>
					<button class="modal-action modal-close waves-effect btn-flat white-text" style='background-color: <?php echo getSiteColor(); ?>'>Cancel</button>
				</div>
			</form>
		</div>

		<div id="sharecard" class="modal modal-fixed-footer modal-mobile-full" style="max-width: 600px;">
			<form>
				<div class="modal-content">
					<h4>Share</h4>
					<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
					<div class="socialshare pointer" style="width:100%; background-color:#0084b4; padding:15px; text-align: center; color:#fff; font-size:16px;" data-link="http://twitter.com/share?url=">Twitter</div><br>
					<div class="socialshare pointer" style="width:100%; background-color:#3B5998; padding:15px; text-align: center; color:#fff; font-size:16px;" data-link="http://www.facebook.com/sharer.php?u=">Facebook</div><br>
					<div class="socialshare pointer" style="width:100%; background-color:#d34836; padding:15px; text-align: center; color:#fff; font-size:16px;" data-link="https://plus.google.com/share?url=">Google</div>
					<input type="hidden" name="share_url" id="share_url">
				</div>
	   </form>
	 </div>

	<?php
	}
	?>

<script>

	$(function(){

		//Social Share
		$(".socialshare").unbind().click(function(e){
			e.preventDefault();
			$('#sharecard').closeModal({ in_duration: 0, out_duration: 0 });
			var network = $(this).data('link');
			var link = $('#share_url').val();
			var finallink = network+link;
		    objWindow = window.open(finallink, 'Social Share', 'width=500,height=500,resizable=no').focus();
		});

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

	});

</script>