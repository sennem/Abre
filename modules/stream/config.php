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
		$sql = "CREATE TABLE `streams_comments` (`id` int(11) NOT NULL AUTO_INCREMENT,`url` text NOT NULL,`title` text NOT NULL,`image` text NOT NULL,`user` text NOT NULL,`comment` text NOT NULL,`creationtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,`liked` int(11) NOT NULL DEFAULT '0', PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1";
  		if ($db->multi_query($sql) === TRUE) { }
	}

	$pageview=1;
	$drawerhidden=0;
	$pageorder=1;
	$pagetitle="Home";
	$pageicon="home";
	$pagepath="";
	$pagerestrictions="";
	
?>
	
<script>

//Page locations
routie({
	<?php
		if(!isset($_GET["dash"]))
		{
	?>
		    '': function() {
			    //Load Streams
			    $( "#navigation_top" ).hide();
			    $( "#content_holder" ).hide();
			    $( "#loader" ).show();
			    $( "#titletext" ).text("Home");
			    document.title = '<?php echo sitesettings("sitetitle"); ?> - Stream';
				$( "#content_holder" ).load( "modules/stream/stream.php", function() { });
				$( "#modal_holder" ).load( "modules/stream/modals.php" );
				
				<?php if($_SESSION['usertype']=='staff'){ ?>
					//Load Navigation
					$( "#navigation_top" ).show();
					$( "#navigation_top" ).load( "modules/stream/menu.php", function() {	
						$( "#navigation_top" ).show();
						$(".tab_1").addClass("tabmenuover");
					});
				<?php } ?>
				
		    },
		    'likes': function() {
			    //Load Streams
			    $( "#navigation_top" ).hide();
			    $( "#content_holder" ).hide();
			    $( "#loader" ).show();
			    $( "#titletext" ).text("Home");
			    document.title = '<?php echo sitesettings("sitetitle"); ?> - Stream';
				$( "#content_holder" ).load( "modules/stream/likes.php", function() { });
				$( "#modal_holder" ).load( "modules/stream/modals.php" );
				
				<?php if($_SESSION['usertype']=='staff'){ ?>
					//Load Navigation
					$( "#navigation_top" ).show();
					$( "#navigation_top" ).load( "modules/stream/menu.php", function() {	
						$( "#navigation_top" ).show();
						$(".tab_2").addClass("tabmenuover");
					});
				<?php } ?>
				
		    },
	<?php
		}
	?>
    'discussion/?:name': function(discussionid){
		$(".lean-overlay").hide();
		$(".modal-content #streamTitle").text("");
		$(".modal-content #streamUrl").val("");
		$(".modal-content #streamTitleValue").val("");
		
	    //Load Streams
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $( "#titletext" ).text("");
	    document.title = '<?php echo sitesettings("sitetitle"); ?> - Stream';
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
		$( "#modal_holder" ).load( "modules/stream/modals.php" );	
		
    }
});

	//Add color to like on click
	$(document).on("click", ".likeicon", function (event) {
		event.preventDefault();
			
		//Toggle icon color
		$(this).toggleClass("mdl-color-text--grey-600");
		$(this).toggleClass("mdl-color-text--red");
			
		var Stream_Title = $(this).data('title');
		var Stream_Url = $(this).data('url');
		var Stream_Image = $(this).data('image');
		var Page = $(this).data('page');
		var ResultCounter = $(this).data('resultcounter');
	
		$.post( "modules/stream/stream_like.php?url="+Stream_Url+"&title="+Stream_Title+"&image="+Stream_Image, function() {
			if(Page!=="likes")
			{
				$('#streamcards').load("modules/stream/stream_feeds.php", function () {	
					$('.grid').masonry( 'reloadItems' );
					$('.grid').masonry( 'layout' );
					mdlregister();
				});
			}
			else
			{
				$("."+ResultCounter).hide();
			}
		});
	});

</script>