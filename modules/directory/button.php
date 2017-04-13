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
	require_once('permissions.php');
	
?>

	<div class="fixed-action-btn buttonpin">
		<?php 
			echo "<button class='btn-floating btn-large waves-effect waves-light employeeview' style='background-color: ".sitesettings("sitecolor")."' data-position='left' data-employeeid='new' data-searchquerysaved=''><i class='large material-icons'>add</i></button>";
			echo "<div class='mdl-tooltip mdl-tooltip--left' for='newentry'>New</div>";
		?>
	</div>