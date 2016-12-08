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
	require_once('abre_feedback.php');

?>
	
	<!--Display page content-->
	<div class='layout mdl-layout mdl-js-layout mdl-layout--fixed-header'>		
	  	<?php
			require_once('abre_navigation_top.php'); 
			require_once('abre_navigation_drawer.php');
			require_once('abre_layout_page_content.php');
	    ?>
	</div>