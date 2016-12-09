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
    
	//Start PHP session
	if(session_id() == ''){ session_start(); }
	
	//Check for configuration fil
	if (file_exists('configuration.php'))
	{
		require('configuration.php');
		require_once('core/abre_google_login.php');
		require_once('core/abre_header.php');
	
		//Display content based on logged in status
		if(isset($authUrl))
		{
			require_once('core/abre_login.php');
		}
		else
		{
			require_once('core/abre_load_modules.php');
			require_once('core/abre_layout_page.php');
		}
		
		require_once('core/abre_footer.php');
	}
	else
	{
		require('core/abre_installer.php');
		require_once('core/abre_footer.php');
	}
	
?>