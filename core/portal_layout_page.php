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
	
	//Check Authentication
	require_once('portal_verification.php');
	
	require_once('portal_feedback.php');

	//Display the Page Content
	echo "<div class='layout mdl-layout mdl-js-layout mdl-layout--fixed-header'>";
	  		
		require_once('portal_navigation_top.php'); 
		require_once('portal_navigation_drawer.php');
		require_once('portal_layout_page_content.php');
	    	
	echo "</div>";
	
	
?>