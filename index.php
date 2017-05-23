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

	//Start PHP session if one does not exist
	if(session_id() == ''){ session_start(); }

	//Check for configuration file and run installer if one does not exist
	if (file_exists('configuration.php'))
	{

		//Load configuration file, google authentication, and site header
		require_once('configuration.php');

		//Look for redirected urls
		if(isset($_GET["url"]))
		{
			$_SESSION["redirecturl"]=htmlspecialchars($_GET["url"]);
		}

		//If there is a session redirect, load the redirect url
		if(isset($_GET["url"]) && isset($_SESSION['useremail']))
		{
			$_SESSION["redirecturl"]=htmlspecialchars($_GET["url"]);
			header("Location: $portal_root/#".$_SESSION["redirecturl"]);
		}

		//Include Google Login
		require_once('core/abre_google_login.php');

		//Include Site Header
		require_once('core/abre_header.php');
		
		    echo $_SESSION['forceauth'];

		//Display login if user is not logged in
		if(isset($_GET["usertype"])){
			require_once('core/abre_parent_login.php');
		}
		else if(isset($authUrl))
		{
			require_once('core/abre_login.php');
		}
		else
		{
			require_once('core/abre_load_modules.php');
			require_once('core/abre_layout_page.php');
		}

		//Display site close and footer
		require_once('core/abre_footer.php');
	}
	else
	{

		//Display the installer
		require('core/abre_installer.php');
		require_once('core/abre_footer.php');

	}

?>
