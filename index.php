<?php

	/*
	* Copyright (C) 2016-2018 Abre.io Inc.
	*
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the Affero General Public License version 3
    * as published by the Free Software Foundation.
	*
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU Affero General Public License for more details.
	*
    * You should have received a copy of the Affero General Public License
    * version 3 along with this program.  If not, see https://www.gnu.org/licenses/agpl-3.0.en.html.
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

		//Display login if user is not logged in
		if(isset($_GET["usertype"])){

			if($_GET["usertype"]=="Staff"){ require_once('core/abre_staff_login.php'); }
			if($_GET["usertype"]=="Student"){ require_once('core/abre_student_login.php'); }
			if($_GET["usertype"]=="Parent"){ $_SESSION['usertype'] = "parent"; require_once('core/abre_parent_login.php'); }

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
