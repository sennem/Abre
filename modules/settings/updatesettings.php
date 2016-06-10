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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	
	//Update system settings
	$sql = "SELECT *  FROM users where email='".$_SESSION['useremail']."' and superadmin=1";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{
		//Retrieve settings and group as json
		$sitetitle=$_POST["sitetitle"];
		$sitecolor=$_POST["sitecolor"];
		$sitedescription=$_POST["sitedescription"];
		$sitelogintext=$_POST["sitelogintext"];
		$siteanalytics=$_POST["siteanalytics"];
		$siteadminemail=$_POST["siteadminemail"];
		$sitevendorlinkurl=$_POST["sitevendorlinkurl"];
		$sitevendorlinkidentifier=$_POST["sitevendorlinkidentifier"];
		$sitevendorlinkkey=$_POST["sitevendorlinkkey"];
		$sitelogoexisting=$_POST["sitelogoexisting"];
		
		if($_FILES['sitelogo']['name'])
		{
			//Get file information
			$file=$_FILES['sitelogo']['name'];
			$fileextention=pathinfo($file, PATHINFO_EXTENSION);
			$cleanfilename=basename($file);
			$sitelogofilename = time() . "siteicon." . $fileextention;
			$uploaddir = $portal_path_root.'/content/';
			
			//Delete previous image
			$oldimagelocation = $portal_path_root.$sitelogoexisting;
			if($sitelogoexisting!='/core/images/abre_siteicon.png'){ unlink($oldimagelocation); }
			
			//Upload new image
			if (!file_exists("$portal_path_root/content/")){ mkdir("$portal_path_root/content/"); }
			$sitelogo = $uploaddir . $sitelogofilename;
			move_uploaded_file($_FILES['sitelogo']['tmp_name'], $sitelogo);
		}
		else
		{
			$sitelogofilename=$sitelogoexisting;
		}
		
		$array = [ "sitetitle" => "$sitetitle", "sitecolor" => "$sitecolor", "sitedescription" => "$sitedescription", "sitelogintext" => "$sitelogintext", "siteanalytics" => "$siteanalytics", "siteadminemail" => "$siteadminemail", "sitevendorlinkurl" => "$sitevendorlinkurl", "sitevendorlinkidentifier" => "$sitevendorlinkidentifier", "sitevendorlinkkey" => "$sitevendorlinkkey", "sitelogo" => "$sitelogofilename" ];
		$json = json_encode($array);
		
		//Update the database
		mysqli_query($db, "UPDATE settings set options='$json'") or die (mysqli_error($db));
		
		//Notification message
		echo "Settings have been updated.";		
	}
	
?>