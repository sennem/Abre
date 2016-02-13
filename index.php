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
	
	//Configutation
	include "configuration.php";
	
	//PHP Session
	if(session_id() == ''){ session_start(); }

	//Authentication
	require_once('core/abre_google_login.php');
	
	//Header
	require_once('core/abre_header.php');

	//Page Content
	if(isset($authUrl))
	{
		//User is NOT logged in
		require_once('core/abre_login.php');
	}
	else
	{
		//User is LOGGED in
		require_once('core/abre_load_modules.php');
		require_once('core/abre_layout_page.php');
	}

	//Footer
	require_once('core/abre_footer.php');
	
?>