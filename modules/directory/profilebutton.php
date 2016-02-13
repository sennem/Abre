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
	
	//Configuration
	require(dirname(__FILE__) . '/../../configuration.php'); 
	
	//Login Validation
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	
	require_once('permissions.php');
	
?>

	<!-- Display Profile Buttons -->
	<div class="fixed-action-btn buttonpin">
		<?php 
			if($firstname=="" && $lastname==""){ $firstname="New"; $lastname="User"; }
			echo "<a class='btn-floating btn-large waves-effect waves-light blue darken-3 tooltipped' data-position='left' data-tooltip='$firstname $lastname'><i class='large material-icons'>person</i></a>"; ?>
	    <ul>
			<li><a class="btn-floating btn-large waves-effect waves-light blue darken-3 tooltipped" data-position="left" data-tooltip="Archive Employee" id='archiveuser'><i class="large material-icons">system_update_alt</i></a></li>
			<?php echo "<li><a class='btn-floating btn-large waves-effect waves-light blue darken-3 tooltipped' data-position='left' data-tooltip='Welcome Letter' href='$portal_root/core/fpdf/welcome.php?id=$id' target='_blank'><i class='large material-icons'>print</i></a></li>"; ?>
			<li><a class="btn-floating btn-large waves-effect waves-light blue darken-3 tooltipped" data-position="left" data-tooltip="Discard Changes" href='#directory'><i class="large material-icons">close</i></a></li>
			<li><button class="btn-floating btn-large waves-effect waves-light blue darken-3 tooltipped" data-position="left" data-tooltip="Save Changes"><i class="large material-icons" type='submit'>check</i></button></li>
		</ul>
	</div>
  
  
<script>
	
   	$(document).ready(function(){  
	   	
	   	//Close FABs on Load
	  	$('.fixed-action-btn').openFAB();
	   	$('.fixed-action-btn').closeFAB();
		$('.tooltipped').tooltip({ delay: 0 }); 
    });	
    
</script>