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
					echo "<hr style='margin-bottom:20px;'>";
					echo "<p style='text-align:center; font-weight:600;' class='truncate'><img src='".$_SESSION['picture']."?sz=100' class='circle'></p>";
					echo "<p style='text-align:center;'><a class='mdl-button mdl-js-button mdl-js-ripple-effect myprofilebutton' href='#profile'>My Profile</a>";
					echo "<a class='mdl-button mdl-js-button mdl-js-ripple-effect' href='?signout'>Sign Out</a></p>";
				echo "</div>";
			?>
    	</div>
	</div>
	

<script>

	$(document).ready(function(){
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
  	});
  	
  	//Make the Icons Clickable
	$(".myprofilebutton").click(function()
	{
		 //Close the app modal
		$("#viewprofile_arrow").hide();
    	$('#viewprofile').closeModal({
	    	in_duration: 0,
			out_duration: 0,
	   	});
	});

</script>