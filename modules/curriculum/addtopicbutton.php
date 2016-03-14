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

?>


	<div class='fixed-action-btn buttonpin'>
		<a class='modal-addtopic btn-floating btn-large waves-effect waves-light blue darken-3 tooltipped' data-position='left' data-tooltip='Create Topic' href='#curriculumtopic'><i class='large material-icons'>add</i></a>
	</div>


<script>
	
	$(document).ready(function(){
		
    	$('.modal-addtopic').leanModal({
	    	ready: function() { $("#topic_title").focus(); }
	   	}
	   	);
    	
    	//Close FABs on Load
	  	$('.fixed-action-btn').openFAB();
	   	$('.fixed-action-btn').closeFAB();
		$('.tooltipped').tooltip({ delay: 0 }); 
    	
  	});
  	
</script>