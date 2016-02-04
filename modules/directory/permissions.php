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
	
	//Configuration
	require(dirname(__FILE__) . '/../../configuration.php'); 
	
	//Login Validation
	require_once(dirname(__FILE__) . '/../../core/portal_verification.php'); 
	
	//Check Authentication for Directory
	require_once('../../core/portal_functions.php');
	
	//Check for Admin Authentication
	$userEmailencrypt=encrypt($_SESSION['useremail'], "");
	$pageaccess=0;
	$superadmin=0;
	include "../../core/portal_dbconnect.php";
	$sql = "SELECT *  FROM directory where email='$userEmailencrypt' and admin=1 and archived=0";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{
		$pageaccess=1;
		$superadmin=htmlspecialchars($row["superadmin"], ENT_QUOTES);
	}
	
?>