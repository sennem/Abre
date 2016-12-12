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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	
?>

	<div class='fixed-action-btn buttonpin'>
		<a class='modal-addmodule btn-floating btn-large waves-effect waves-light' style='background-color: <?php echo sitesettings("sitecolor"); ?>' id='addmodules' data-position='left' href='#addmodule'><i class='large material-icons'>add</i></a>
		<div class="mdl-tooltip mdl-tooltip--left" for="addmodules">Add Module</div>
	</div>

<script>
	
	$(function() 
	{
		//Github Modal
		$('.modal-addmodule').leanModal(
		{
			in_duration: 0,
			out_duration: 0,
			ready: function() {  }
		});
	});
</script>