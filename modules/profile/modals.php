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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');	
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');	

?>

	<link rel="stylesheet" type="text/css" href="/modules/profile/css/calendar.css">
	<script type="text/javascript" src="/modules/profile/js/jquery-ui.multidatespicker.js"></script>

	<!--Work Schedule-->
	<div id="viewschedule" class="modal modal-fixed-footer modal-mobile-full" style='width: 80%'>
	    <div class="modal-content">
			<h4>Set Your Work Schedule</h4>
			<div class='row'>
				<div class='col m3 hide-on-small-only'>
					<?php include "calendarsidebar.php"; ?>
				</div>
				<div class='col m9 s12'>
					<?php echo "<form id='form-calendar' method='post'>"; ?>
						<input id="saveddates" type="hidden"></input>
					</form>
					<div id="workcalendardisplay"></div>
				</div>
			</div>
	    </div>
		<div class="modal-footer">
			<button class="modal-close waves-effect btn-flat blue darken-3 white-text">Close</button>
			<div id="selecteddays" style='margin:12px 0 0 20px; font-weight:500; font-size:16px;'></div>
	    </div>
	</div>