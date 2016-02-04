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
	
	$db_host=constant("DB_HOST");
	$db_user=constant("DB_USER");
	$db_password=constant("DB_PASSWORD");
	$db_name=constant("DB_NAME");

	$db = new mysqli($db_host, $db_user, $db_password, $db_name);
	if($db->connect_errno > 0){ die('Unable to connect to database [' . $db->connect_error . ']'); }
	
?>