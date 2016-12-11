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
		
		//Delete a folder
		function rrmdir($dir) {
	        if (is_dir($dir)) {
	            $files = scandir($dir);
	            foreach ($files as $file)
	                if ($file != "." && $file != "..") rrmdir("$dir/$file");
	            rmdir($dir);
	        }
	        else if (file_exists($dir)) unlink($dir);
		}
		
		//Retrieve last repo link and zip file
		$link=$_POST["link"];
		$repo=$_POST["repo"];
		
		if(($pos = strpos($repo, '/')) !== false)
		{
		   $repo = substr($repo, $pos + 1);
		}
		
		$linkfile=basename($link);
		$linkfile=substr($linkfile, 0, -4);
		file_put_contents("$portal_path_root/modules/$repo.zip", file_get_contents($link));
		
		//Upzip the file
		$zip = new ZipArchive;
		if ($zip->open("$portal_path_root/modules/$repo.zip") === TRUE) {
		    $zip->extractTo("$portal_path_root/modules/");
		    $zip->close();
		}
		
		//Delete old module
		rrmdir(realpath(dirname(__FILE__))."/../$repo");
		
		//Rename folder
		rename(realpath(dirname(__FILE__))."/../$repo-$linkfile",realpath(dirname(__FILE__))."/../$repo");
		
		//Delete zipped files
    	unlink("$portal_path_root/modules/$repo.zip");

	}
	
?>