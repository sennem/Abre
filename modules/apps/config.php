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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');	
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');	
	
	//Setup tables if new module
	if(!$resultapps = $db->query("SELECT *  FROM apps"))
	{
			$sql = "CREATE TABLE apps (id int(11) NOT NULL,icon text NOT NULL,student int(11) NOT NULL,staff int(11) NOT NULL,title text NOT NULL,image text NOT NULL,link text NOT NULL,required int(11) NOT NULL,sort int(11) NOT NULL,minor_disabled int(11) NOT NULL DEFAULT '0') ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `apps` ADD PRIMARY KEY (`id`);";
  			$sql .= "ALTER TABLE `apps` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
  			$sql .= "INSERT INTO `apps` (`id`, `icon`, `student`, `staff`, `title`, `image`, `link`, `required`, `sort`, `minor_disabled`) VALUES (NULL, 'icon_mail.png', '1', '1', 'Mail', 'icon_mail.png', 'https://mail.google.com/', '1', '1', '1');";
  			$sql .= "INSERT INTO `apps` (`id`, `icon`, `student`, `staff`, `title`, `image`, `link`, `required`, `sort`, `minor_disabled`) VALUES (NULL, 'icon_drive.png', '1', '1', 'Drive', 'icon_drive.png', 'https://drive.google.com/', '1', '2', '0');";
  			$sql .= "INSERT INTO `apps` (`id`, `icon`, `student`, `staff`, `title`, `image`, `link`, `required`, `sort`, `minor_disabled`) VALUES (NULL, 'icon_calendar.png', '1', '1', 'Calendar', 'icon_calendar.png', 'https://calendar.google.com/', '1', '3', '0');";
  			$sql .= "INSERT INTO `apps` (`id`, `icon`, `student`, `staff`, `title`, `image`, `link`, `required`, `sort`, `minor_disabled`) VALUES (NULL, 'icon_classroom.png', '1', '1', 'Classroom', 'icon_classroom.png', 'https://classroom.google.com/', '1', '4', '0');";
  		if ($db->multi_query($sql) === TRUE) { }
	}
	
	
	$pageview=1;
	$drawerhidden=1;
	$pagetitle="Apps";
	$pagepath="apps";
	
?>

	<!--Apps modal-->
	<div id='viewapps_arrow' class='hide-on-small-only'></div>
	<div id="viewapps" class="modal apps_modal modal-mobile-full">
		<div class="modal-content" id="modal-content-section">
			<a class="modal-close black-text hide-on-med-and-up" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<div id='loadapps'></div>
    	</div>
	</div>

	<script>
		
		$(document).ready(function()
		{
			//Load Apps into Modal
			$('#loadapps').load('modules/apps/apps.php');
		
			//Apps Modal
	    	$('.modal-viewapps').leanModal({
				in_duration: 0,
				out_duration: 0,
				opacity: 0,
		    	ready: function() { 
			    	$("#viewapps_arrow").show(); 
			    	$("#viewapps").scrollTop(0);
			    	$('#viewprofile').closeModal({
				    	in_duration: 0,
						out_duration: 0,
				   	});
			    	$("#viewprofile_arrow").hide();
			    },
		    	complete: function() { $("#viewapps_arrow").hide(); }
		   	});	  	
	  	
		   	//Make the App Icons Clickable
		   	$(document).on("click", ".app", function ()
		   	{
				window.open($(this).find("a").attr("href"), '_blank');			
				$("#viewapps_arrow").hide();
				
		    	$('#viewapps').closeModal({
			    	in_duration: 0,
					out_duration: 0,
			   	});
			});
		});
	
	</script>