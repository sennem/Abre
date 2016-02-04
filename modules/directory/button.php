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
	require_once(dirname(__FILE__) . '/../../core/portal_verification.php'); 
	
	require_once('permissions.php');
	
?>

	<div class="fixed-action-btn buttonpin">
		<?php 
			echo "<a class='btn-floating btn-large waves-effect waves-light blue darken-3'><i class='large material-icons'>person_add</i></a>"; ?>
	    <ul>
		    <?php echo "<li><a class='btn-floating btn-large waves-effect waves-light blue darken-3 tooltipped' data-position='left' data-tooltip='Maintenance' href='$portal_root/#directory/maintenance'><i class='large material-icons'>settings</i></a></li>"; ?>
			<?php echo "<li><a class='btn-floating btn-large waves-effect waves-light blue darken-3 tooltipped' data-position='left' data-tooltip='New' href='$portal_root/#directory/new'><i class='large material-icons'>add</i></a></li>"; ?>
			<?php echo "<li><a class='btn-floating btn-large waves-effect waves-light blue darken-3 tooltipped' data-position='left' data-tooltip='Search' href='$portal_root/#directory'><i class='large material-icons'>search</i></a></li>"; ?>
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