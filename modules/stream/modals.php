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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	//Check for variable in url
	if(isset($_GET['discussion'])){
		$discussionid = $_GET['discussion'];
		$discussionid = preg_replace("/[^0-9]/","",$discussionid);
	}

?>

	<!-- Comments -->
	<?php
	if($_SESSION['usertype']=='staff'){
	?>
		<div id="addstreamcomment" class="modal modal-fixed-footer modal-mobile-full">
			<div id="commentloader" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="width:100%"></div>
			<form id="form-addstreamcomment" method="post" action="modules/stream/comment_add.php">
				<div class="modal-content" id="modal-content-section">
					<h4 name="streamTitle" id="streamTitle" style='margin-right:50px;'></h4>
					<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>

					<div class="input-field">
						<textarea placeholder="Add a comment..." id="streamComment" name="streamComment" class="materialize-textarea" required></textarea>
					</div>
					<button class="btn waves-effect btn-flat white-text" type="submit" name="action" style='margin-top:-20px; background-color:<?php echo getSiteColor(); ?>'>Post</button><br><br>
					
					<div name="streamComments" id="streamComments"></div>
					
					<input type="hidden" name="streamUrl" id="streamUrl">
					<input type="hidden" name="streamTitleValue" id="streamTitleValue">
					<input type="hidden" name="commentID" id="commentID">
					<input type="hidden" name="streamImage" id="streamImage">
					<input type="hidden" name="redirect" id="redirect">
		    </div>
			  <div class="modal-footer">
					<button class="modal-action modal-close waves-effect btn-flat white-text" style='background-color: <?php echo getSiteColor(); ?>'>Close</button>
				</div>
			</form>
		</div>

		<!-- Social Sharing -->
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
	 	
	 	<!-- Edit Widgets -->
		<div id="editwidgets" class="modal modal-mobile-full" style="max-width: 600px;">
			<form>
				<div class="modal-content">
					<h4>Edit Widgets</h4>
					<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
					
					<?php
						
						//Check to see if there is hidden widgets
						$sql = "SELECT * FROM profiles WHERE email = '".$_SESSION['useremail']."'";
						$result = $db->query($sql);
						$widgets_order = NULL;
						while($row = $result->fetch_assoc()) {
							$widgets_hidden = htmlspecialchars($row["widgets_hidden"], ENT_QUOTES);
						}

						//Show All Widgets
						echo "<table class='bordered'>";
						$widgetsdirectory = dirname(__FILE__) . '/../';
						$widgetsfolders = scandir($widgetsdirectory);
						foreach($widgetsfolders as $result){
							
							$pagetitle = NULL;
				
							if(file_exists(dirname(__FILE__) . '/../'.$result.'/widget.php')){

								include(dirname(__FILE__) . '/../'.$result.'/config.php');
									
								echo "<tr style='background-color:#f9f9f9'>";
									echo "<td><b>$pagetitle</b><td>";
									echo "<td style='width:30px'>";
								
										echo "<div class='switch'><label><input type='checkbox' class='widgetclick' name='$result' id='$result' value='1' ";
										
										//Check if a widget should be hidden
										if($widgets_hidden==NULL){
											
											echo "checked";
											
										}
										else
										{
											
											//Check to see if widget was hidden by use selection
											$HiddenWidgets = explode(',',$widgets_hidden);
											if(!in_array($result, $HiddenWidgets)){
												
												echo "checked";
													
											}
											
										}
											
										echo "/><span class='lever'></span></label></div>";

									echo "</td>";
								echo "</tr>";

							}
				
						}
						echo "</table>";	
						
					?>
					
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
		
		//Update Widget Setting
		$(".widgetclick").unbind().click(function(e){
			var widget = $(this).attr('id');
			var selectedWidgets = "";
			
			$("input:checkbox[class=widgetclick]:not(:checked)").each(function () {
           		selectedWidgets = $(this).attr("id") + "," + selectedWidgets;
        	});
        	
        	selectedWidgets = selectedWidgets.replace(/^,|,$/g,'');

			$.post("modules/stream/save_widget_status.php", {widgets: selectedWidgets}, function() {
				$("#streamwidgets").load("modules/<?php echo basename(__DIR__); ?>/widgets.php");
			});
			
		});

		//Save comment
		var form = $('#form-addstreamcomment');
		$(form).submit(function(event) {
			event.preventDefault();
			$("#commentstatustext").text("Posting comment...");
			var url = $("#streamUrl").val();
			var id = $("#commentID").val();
			var redirect = $("#redirect").val();
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
					$.post( "modules/<?php echo basename(__DIR__); ?>/update_card.php", {url: url, redirect: redirect, type: "comment"})
					.done(function(data) {
						$("#"+id).prev().removeClass("mdl-color-text--grey-600");
						$("#"+id).prev().css("color", "<?php echo getSiteColor(); ?>");
						$("#"+id).css("color", "<?php echo getSiteColor(); ?>");
						$("#"+id).html(data.count);
						if(redirect == "comments"){
							if(data.currentusercount > 0){
								$("#"+id).closest(".card_stream").show();
							}
							if(data.streamcardsleft > 0){
								$("#noCommentsMessage").hide();
							}
						}
					});
				});
			})
		});

	});

</script>