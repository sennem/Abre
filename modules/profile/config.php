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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');

	//Setup tables if new module
	if(!$resultprofile = $db->query("SELECT *  FROM profiles"))
	{
			$sql = "CREATE TABLE `profiles` (`id` int(11) NOT NULL,`email` text NOT NULL,`startup` int(11) NOT NULL DEFAULT '1',`streams` text NOT NULL,`card_mail` int(11) NOT NULL DEFAULT '1',`card_drive` int(11) NOT NULL DEFAULT '1',`card_calendar` int(11) NOT NULL DEFAULT '1',`card_classroom` int(11) NOT NULL DEFAULT '1',`card_apps` int(11) NOT NULL DEFAULT '1',`apps_order` text NOT NULL,`work_calendar` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
  			$sql .= "ALTER TABLE `profiles` ADD PRIMARY KEY (`id`);";
  			$sql .= "ALTER TABLE `profiles` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
  			$sql .= "INSERT INTO `profiles` (`id`, `email`, `startup`, `streams`, `card_mail`, `card_drive`, `card_calendar`, `card_classroom`, `card_apps`, `apps_order`, `work_calendar`) VALUES (NULL, '".$_SESSION['useremail']."', '0', '', '1', '1', '1', '1', '1', '', '');";
  		if ($db->multi_query($sql) === TRUE) { }
	}

	$pageview=1;
	$drawerhidden=1;
	$pageorder=6;
	$pagetitle="Profile";
	$pageicon="account_circle";
	$pagepath="profile";
	$pagerestrictions="";

?>

	<!--Profile modal-->
	<div id='viewprofile_arrow' class='hide-on-small-only'></div>
	<div id="viewprofile" class="modal apps_modal modal-mobile-full">
		<div class="modal-content" id="modal-content-section">
			<a class="modal-close black-text hide-on-med-and-up" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<?php
				echo "<div class='row' style='margin-bottom:0;'>";
					echo "<p style='text-align:center; font-weight:600; margin-bottom:0;' class='truncate'>".$_SESSION['displayName']."</p>";
					echo "<p style='text-align:center;' class='truncate'>".$_SESSION['useremail']."</p>";
					echo "<p style='text-align:center; font-weight:600;' class='truncate'><img src='".$_SESSION['picture']."?sz=100' class='circle'></p>";
					echo "<hr style='margin-bottom:20px;'>";
					echo "<p style='text-align:center;'><a class='waves-effect btn-flat white-text myprofilebutton' href='#profile' style='margin-right:5px; background-color:"; echo sitesettings("sitecolor"); echo "'>My Profile</a>";
					echo "<a class='waves-effect btn-flat white-text' href='?signout' style='background-color:"; echo sitesettings("sitecolor"); echo "'>Sign Out</a></p>";
				echo "</div>";
			?>
    	</div>
	</div>

<script>

	$(function()
	{
    	$('.modal-viewprofile').leanModal({
	    	in_duration: 0,
			out_duration: 0,
			opacity: 0,
	    	ready: function() {
		    	$("#viewprofile_arrow").show();
		    	$( "#viewprofile" ).scrollTop(0);
		    	$('#viewapps').closeModal({
			    	in_duration: 0,
					out_duration: 0,
			   	});
		    	$("#viewapps_arrow").hide();
		    },
	    	complete: function() { $("#viewprofile_arrow").hide(); }
	   	});

	  	//Make the Profile Icon Clickable/Closeable
		$(".myprofilebutton").unbind().click(function()
		{
			 //Close the app modal
			$("#viewprofile_arrow").hide();
	    	$('#viewprofile').closeModal({
		    	in_duration: 0,
				out_duration: 0,
		   	});
		});

  	});

</script>

<!--Stream Editor-->
	<?php
	if(superadmin())
	{
	?>

	<link rel="stylesheet" href='core/css/image-picker.0.3.0.css'>
	<script src='core/js/image-picker.0.0.3.min.js'></script>

	<div id='streameditor' class='modal modal-fixed-footer modal-mobile-full'>
		<div class='modal-content'>
			<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<div class='row'>
				<div class='col s12'>
					<h4>Stream Editor</h4>
					<?php
						include "stream_editor_content.php";
					?>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<a class='modal-action waves-effect btn-flat white-text modal-addeditstream' href='#addeditstream' data-streamtitle='Add New Stream' style='background-color: <?php echo sitesettings("sitecolor"); ?>'>Add</a>
		</div>
	</div>

	<div id='addeditstream' class='modal modal-fixed-footer modal-mobile-full' style="width: 90%">
		<form id='addeditstreamform' method="post" action='#'>
		<div class='modal-content'>
			<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<div class='row'>
				<div class='col s12'><h4 id='editstreammodaltitle'></h4></div>
				<div class='input-field col s12'>
					<input placeholder="Enter Stream Name" id="stream_name" name="stream_name" type="text" autocomplete="off" required>
					<label for="stream_name">Name</label>
				</div>
				<div class='input-field col s12'>
					<input placeholder="Enter RSS Link" id="rss_link" name="rss_link" type="text" autocomplete="off" required>
					<label for="rss_link">Link</label>
				</div>
			</div>
			<div class='row'>
				<div class='col m4 s12'>
						<input type="radio" name="streamradio" id="stream_staff" value="staff" required>
						<label for="stream_staff">Staff</label>
				</div>
				<div class='col m4 s12'>
					<input type="radio" name="streamradio" id="stream_students" value="students">
					<label for="stream_students">Students</label>
				</div>
			</div>
			<input id="stream_id" name="stream_id" type="hidden">
		</div>
		<div class='modal-footer'>
			<button type="submit" class='modal-action waves-effect btn-flat white-text' id='saveupdatestream' style='background-color: <?php echo sitesettings("sitecolor"); ?>'>Save</button>
			<a class='modal-action modal-close waves-effect btn-flat white-text' style='background-color: <?php echo sitesettings("sitecolor"); ?>; margin-right:5px;'>Cancel</a>
		</div>
		</form>
	</div>
	<?php
 	}
 	?>

	<script>

		$(function()
		{

		   	<?php
			if(superadmin())
			{
			?>

				//Add/Edit Stream
				$('.modal-addeditstream').leanModal({
					in_duration: 0,
					out_duration: 0,
					ready: function()
					{
						$('.modal-content').scrollTop(0);
						$("#editstreammodaltitle").text('Add New Stream');
						$("#stream_name").val('');
						$("#rss_link").val('');
						$("#stream_id").val('');
						$('#stream_staff').prop('checked', false);
						$('#stream_students').prop('checked', false);
					}
				});

				//Save/Update Stream
				$('#addeditstreamform').submit(function(event)
				{
					event.preventDefault();

					var streamtitle = $('#stream_name').val();
					var rsslink = $('#rss_link').val();
					var streamgroup= $('input[name=streamradio]:checked').val();

					var streamid = $('#stream_id').val();
					//Make the post request
					$.ajax({
						type: 'POST',
						url: 'modules/profile/update_stream.php',
						data: { title: streamtitle, link: rsslink, id: streamid, group: streamgroup }
					})

					.done(function(){
						$('#addeditstream').closeModal({ in_duration: 0, out_duration: 0 });
						$('#streamsort').load('modules/profile/stream_editor_content.php');
						$('#content_holder').load( 'modules/profile/profile.php');
					});
				});

			<?php
			}
			?>

		});

	</script>
