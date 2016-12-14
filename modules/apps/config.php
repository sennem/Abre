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
	
	//Check for installation
	if(superadmin()){ require('installer.php'); }	
	
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
		
		$(function()
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
	  	
		});
	
	</script>