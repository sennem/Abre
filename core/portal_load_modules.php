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
	
	require_once('portal_verification.php');
	
	//Create the Modules Array
	$modules = array();
	$modulecount=0;
	
	
	//Display Available Modules Based On Module Permissions
	$moduledirectory = dirname(__FILE__) . '/../modules';
	$modulefolders = scandir($moduledirectory);
	foreach ($modulefolders as $result) {	
		if ($result == '.' or $result == '..') continue;
		if (is_dir($moduledirectory . '/' . $result)) {
			$pageview="";
			$drawerhidden="";
			$pageorder="";
			$pagetitle="";
			$pageicon="";
			$pagepath="";
			$pagerestrictions="";
			$subpages="";
			require_once(dirname(__FILE__) . '/../modules/'.$result.'/config.php');

			$access=strpos($pagerestrictions, $_SESSION['usertype']);
			if($access === false)
			{
				array_push($modules, array("$pageorder","$pagetitle","$pageview","$pageicon","$pagepath","$drawerhidden","$subpages"));
				$modulecount++;
			}
		}  
	}
	sort($modules, SORT_DESC);

	
?>