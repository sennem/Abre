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
	require(dirname(__FILE__) . '/../../core/abre_version.php');
	
	//Verify Superadmin
	$sql = "SELECT *  FROM users where email='".$_SESSION['useremail']."' and superadmin=1";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{	
	
		//Retrieve the repo
		$repoaddress=$_POST["repoaddress"];
		
		$opts = ['http' => ['method' => 'GET','header' => ['User-Agent: PHP']]];
		$context = stream_context_create($opts);
		$content = file_get_contents("https://api.github.com/repos/$repoaddress/releases/latest", false, $context);
		$json = json_decode($content, true);
		$currentversion = $json['name'];
			
		$currentlink = "https://github.com/$repoaddress/archive/".$currentversion.".zip";
		file_put_contents("$portal_path_root/modules/newmodule.zip", file_get_contents($currentlink));
		
		//Upzip the file
		/*
		$zip = new ZipArchive;
		if ($zip->open("$portal_path_root/modules/newmodule.zip") === TRUE) {
			$zip->extractTo("$portal_path_root/modules/");
			$zip->close();
		}
		*/
		
		echo "Module Added";
		
	}
	
?>