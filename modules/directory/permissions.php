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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	
	//Check for Admin Authentication
	$userEmailencrypt=encrypt($_SESSION['useremail'], "");
	$pageaccess=0;
	$superadmin=0;
	$sql = "SELECT *  FROM directory where email='$userEmailencrypt' and admin=1 and archived=0";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{
		$pageaccess=1;
	}
	
	$sql = "SELECT *  FROM users where email='".$_SESSION['useremail']."' and superadmin=1";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{
		$pageaccess=1;
		$superadmin=htmlspecialchars($row["superadmin"], ENT_QUOTES);
	}
	
	$sql = "SELECT *  FROM directory where email='$userEmailencrypt' and admin=2 and archived=0";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{
		$pageaccess=2;
	}

?>