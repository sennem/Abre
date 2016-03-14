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

	$pageview=1;
	$drawerhidden=0;
	$pageorder=1;
	$pagetitle="Stream";
	$pageicon="dashboard";
	$pagepath="";
	$pagerestrictions="";
	
	?>
	
	<!-- Commenting Modal -->
	<?php
	if($_SESSION['usertype']=='staff')
	{
	?>
	<div id="addstreamcomment" class="modal modal-fixed-footer modal-mobile-full">
		<form id="form-addstreamcomment" method="post" action="modules/stream/addcomment.php">
		<div class="modal-content" id="modal-content-section">
			<div id="commentloader" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="width:100%"></div>
			<div name="streamComments" id="streamComments"></div>
			<div class="input-field col s12">
				<h4 name="streamTitle" id="streamTitle"></h4>
				<b class="mdl-color-text--blue-800" id="commentstatustext">Write a comment</b>
				<textarea id="streamComment" name="streamComment" class="materialize-textarea"></textarea>
			</div>
			<input type="hidden" name="streamUrl" id="streamUrl">
    	</div>
	    <div class="modal-footer">
			<button class="btn waves-effect btn-flat blue darken-3 white-text" type="submit" name="action" style="margin-left:5px;">Post</button>
			<button class="modal-action modal-close waves-effect btn-flat blue darken-3 white-text">Close</button>
		</div>
		</form>
	</div>
	<?php
	}
	?>
<script>
	
		//Comments
	$(document).ready(function(){
		//Save Form Data
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
				$( "#streamComments" ).load( "modules/stream/listcomments.php?url="+response, function() {
					$("textarea").val('');
					$("#commentstatustext").text("Write a comment");
					$(".modal-content #streamUrl").val(response);
					var element = document.getElementById("commentthreadbox");
					element.scrollTop = element.scrollHeight;
					$('#streamcards').load("modules/stream/stream_cards.php", function () {	
						$('.grid').masonry( 'reloadItems' );
						$('.grid').masonry( 'layout' );
						mdlregister();
					});
				});			
			})						
		});
	});

//Page Locations
routie({
    '': function() {
	    //Load Streams
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $( "#titletext" ).text("Stream");
	    document.title = 'HCSD Portal - Stream';
		$( "#content_holder" ).load( "modules/stream/stream.php", function() {		
			init_page(loader);	
		});		
		
		//Load Stream Apps
		$( "#navigation_top" ).show();
		$( "#navigation_top" ).load( "modules/apps/card.php", function() {	
			$( "#navigation_top" ).show();
		});
    }
});

</script>