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
	
	//Setup tables if new module
	if(!$resultstreams = $db->query("SELECT *  FROM streams"))
	{
		$sql = "CREATE TABLE `streams` (`id` int(11) NOT NULL,`group` text NOT NULL,`title` text NOT NULL,`slug` text NOT NULL,`type` text NOT NULL,`url` text NOT NULL,`required` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$sql .= "CREATE TABLE `streams_comments` (`id` int(11) NOT NULL,`url` text NOT NULL,`user` text NOT NULL,`comment` text NOT NULL,`creationtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `liked` int(11) NOT NULL DEFAULT '0') ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$sql .= "ALTER TABLE `streams` ADD PRIMARY KEY (`id`);";
  		$sql .= "ALTER TABLE `streams` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
  		$sql .= "INSERT INTO `streams` (`id`, `group`, `title`, `slug`, `type`, `url`, `required`) VALUES (NULL, 'staff', 'Resident Educator', 'residenteducator', 'flipboard', 'https://flipboard.com/@loripierson/hcsd-resident-educator-resources-ani2c718y.rss', '0');";
  		$sql .= "INSERT INTO `streams` (`id`, `group`, `title`, `slug`, `type`, `url`, `required`) VALUES (NULL, 'staff', 'Technology', 'technology', 'flipboard', 'https://flipboard.com/@chrisrose64f0/hcsd-technology-i29k1hsdy.rss', '0');";
  		$sql .= "INSERT INTO `streams` (`id`, `group`, `title`, `slug`, `type`, `url`, `required`) VALUES (NULL, 'staff', 'ESL', 'esl', 'flipboard', 'https://flipboard.com/@corbinmoores2ri/esl-education-of3dj066y.rss', '0');";
  		if ($db->multi_query($sql) === TRUE) { }
	}
	
	//Setup tables if new module
	if(!$resultstreamscomments = $db->query("SELECT *  FROM streams_comments"))
	{
		$sql = "CREATE TABLE `streams_comments` (`id` int(11) NOT NULL,`url` text NOT NULL,`title` text NOT NULL,`user` text NOT NULL,`comment` text NOT NULL,`creationtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,`liked` int(11) NOT NULL DEFAULT '0') ENGINE=InnoDB DEFAULT CHARSET=latin1;";
  		$sql .= "ALTER TABLE `streams_comments` ADD PRIMARY KEY (`id`);";
  		$sql .= "ALTER TABLE `streams_comments` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
  		if ($db->multi_query($sql) === TRUE) { }
	}

	$pageview=1;
	$drawerhidden=0;
	$pageorder=1;
	$pagetitle="Stream";
	$pageicon="dashboard";
	$pagepath="";
	$pagerestrictions="";
	
	
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
				<b class="mdl-color-text--blue-800" id="commentstatustext">Write a comment</b>
				<textarea id="streamComment" name="streamComment" class="materialize-textarea" required></textarea>
			</div>
			<input type="hidden" name="streamUrl" id="streamUrl">
			<input type="hidden" name="streamTitleValue" id="streamTitleValue">
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
		});			
	})						
});

//Add color to like on click
$(document).on("click", ".likeicon", function (event) {
	event.preventDefault();
		
	//Toggle icon color
	$(this).toggleClass("mdl-color-text--grey-600");
	$(this).toggleClass("mdl-color-text--red");
		
	var Stream_Title = $(this).data('title');
	var Stream_Url = $(this).data('url');

	$.post( "modules/stream/stream_like.php?url="+Stream_Url+"&title="+Stream_Title, function() {
		$('#streamcards').load("modules/stream/stream_feeds.php", function () {	
			$('.grid').masonry( 'reloadItems' );
			$('.grid').masonry( 'layout' );
			mdlregister();
		});
	});
});

//Page locations
routie({
    '': function() {
	    //Load Streams
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $( "#titletext" ).text("Stream");
	    document.title = 'HCSD Portal - Stream';
		$( "#content_holder" ).load( "modules/stream/stream.php", function() {
		});
		
    },
    'apps': function() {
	    //Load Streams
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $( "#titletext" ).text("Stream");
	    document.title = 'HCSD Portal - Stream';
		$( "#content_holder" ).load( "modules/stream/stream.php", function() {
		});
		
    },
    'discussion/?:name': function(discussionid){
		$(".lean-overlay").hide();
		$(".modal-content #streamTitle").text("");
		$(".modal-content #streamUrl").val("");
		$(".modal-content #streamTitleValue").val("");
		
	    //Load Streams
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $( "#titletext" ).text("Stream");
	    document.title = 'HCSD Portal - Stream';
		$( "#content_holder" ).load( "modules/stream/stream.php", function() {	
				
			init_page(loader);
			$('#addstreamcomment').openModal({
				in_duration: 0,
				out_duration: 0,
				complete: function() { routie('');  }
			});
			
			$("#commentloader").show();
			$("#streamComments").empty();
		    var Stream_Title = $(this).data('title');
		    $(".modal-content #streamTitle").text(Stream_Title);
		    var Stream_Url = $(this).data('url');
		    $(".modal-content #streamUrl").val(Stream_Url);
		    $( "#streamComments" ).load( "modules/stream/comment_list.php?url="+discussionid, function() {
				$("#commentloader").hide();
			});
			
		});		
		
    }
});


</script>