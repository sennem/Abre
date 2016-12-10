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
	
	if (!headers_sent())
	{
	
		//Start PHP session if not loaded
		if(session_id() == ''){ session_start(); }
		
		//Include required files
		include(dirname(__FILE__) . '/../configuration.php');
		$cookie_name=constant("PORTAL_COOKIE_NAME");
		
		//Require login script if there is a cookie but not session
		if(isset($_COOKIE[$cookie_name]) && !isset($_SESSION['access_token'])){ require_once 'abre_google_login.php'; }
		
		//Check to make sure they are logged in
		if(!(isset($_SESSION['usertype']) && $_SESSION['usertype'] != "")){ header("Location: $portal_root/?signout"); };
	
	}

?>