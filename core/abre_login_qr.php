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
    
    require_once(dirname(__FILE__) . '/../configuration.php'); 
	
	include "abre_dbconnect.php";
	$cookie_name=constant("PORTAL_COOKIE_NAME");
	$HCSDOHcookievalue=$_POST["identifier"];
	
	if($result=$db->query("SELECT * from users where cookie_token='$HCSDOHcookievalue'"))
	{
		//Make sure the user is a student
		setcookie("$cookie_name","$HCSDOHcookievalue", time() + (86400 * 7), "/"); 
		echo "Authenticated";
	}
	else
	{
		echo "Invalid";
	}
	$db->close();
	
?>