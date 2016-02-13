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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	
	$list = $_POST['list'];
	
	$output = array();
	$list = parse_str($list, $output);
	$a = implode(',', $output['item']);

	include "../../core/abre_dbconnect.php";
	$stmt = $db->stmt_init();
	$sql = "Update profiles set apps_order='$a' where email='".$_SESSION['useremail']."'";
	$stmt->prepare($sql);
	$stmt->execute();
	$stmt->close();
	$db->close();	
	
	
?>