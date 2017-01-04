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
	require_once('permissions.php');
	
?>

	<!-- Display Profile Buttons -->
	<div class="fixed-action-btn buttonpin">
		<?php 
			if($firstname=="" && $lastname==""){ $firstname="New"; $lastname="User"; }
			echo "<a class='btn-floating btn-large waves-effect waves-light' style='background-color: ".sitesettings("sitecolor")."' id='name'><i class='large material-icons'>person</i></a><div class='mdl-tooltip mdl-tooltip--left demotext_dark' for='name'>$firstname $lastname</div>"; ?>
	    <ul>
			<li><a class="btn-floating btn-large waves-effect waves-light" style='background-color: <?php echo sitesettings("sitecolor"); ?>' id='archiveuser' id='archiveuser'><i class="large material-icons">system_update_alt</i></a><div class='mdl-tooltip mdl-tooltip--left' for='archiveuser'>Archive</div></li>
			<li><a class="btn-floating btn-large waves-effect waves-light" style='background-color: <?php echo sitesettings("sitecolor"); ?>' id='discard' href='#directory'><i class="large material-icons">close</i></a><div class='mdl-tooltip mdl-tooltip--left' for='discard'>Discard</div></li>
			<li><button class="btn-floating btn-large waves-effect waves-light" style='background-color: <?php echo sitesettings("sitecolor"); ?>' id='save'><i class="large material-icons" type='submit'>check</i></button><div class='mdl-tooltip mdl-tooltip--left' for='save'>Save</div></li>
		</ul>
	</div>