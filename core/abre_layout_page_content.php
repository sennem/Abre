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
	require_once('abre_verification.php');

?>

	<!--Display page content-->
	<main class='mdl-layout__content'>
		<div id='navigation_top'></div>
		<div class='content' id='content'>
			<div id='loader'><?php include "abre_loader_spinner.php"; ?></div>
			<div id='content_holder'></div>
			<div aria-live="assertive" aria-atomic="true" aria-relevant="text" class="mdl-snackbar mdl-js-snackbar">
			    <div class="mdl-snackbar__text"></div>
			    <button type="button" class="mdl-snackbar__action"></button>
			</div>
		</div>
	</main>