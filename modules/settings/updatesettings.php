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

	//Update system settings
	if(superadmin())
	{
		//Retrieve settings and group as json
		$sitetitle=$_POST["sitetitle"];
		$sitecolor=$_POST["sitecolor"];
		$sitedescription=$_POST["sitedescription"];
		$sitelogintext=$_POST["sitelogintext"];
		$siteanalytics=$_POST["siteanalytics"];
		$siteadminemail=$_POST["siteadminemail"];
		$sitevendorlinkurl=$_POST["sitevendorlinkurl"];
		$studentdomain=$_POST["studentdomain"];
		$studentdomainrequired=$_POST["studentdomainrequired"];
		$sitevendorlinkidentifier=$_POST["sitevendorlinkidentifier"];
		$siteparentaccess = $_POST["parentaccess"];
		$sitegoogleclientid = $_POST["googleclientid"];
		if($_POST["googleclientsecret"]!=""){ $sitegoogleclientsecret = encrypt($_POST["googleclientsecret"], ''); }else{ $sitegoogleclientsecret=""; }
		$sitefacebookclientid = $_POST["facebookclientid"];
		if($_POST["facebookclientid"]!=""){ $sitefacebookclientsecret = encrypt($_POST["facebookclientsecret"], ''); }else{ $sitefacebookclientsecret=""; }
		$sitemicrosoftclientid = $_POST["microsoftclientid"];
		if($_POST["microsoftclientid"]!=""){ $sitemicrosoftclientsecret = encrypt($_POST["microsoftclientsecret"], ''); }else{ $sitemicrosoftclientsecret=""; }
		$sitevendorlinkkey=$_POST["sitevendorlinkkey"];
		$sitelogoexisting=$_POST["sitelogoexisting"];
		$abre_community = $_POST['abre_community'];
		$community_first_name = $_POST['community_first_name'];
		$community_last_name = $_POST['community_last_name'];
		$community_email = $_POST['community_email'];
		$community_users = $_POST['community_users'];

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
			if($sitelogoexisting!='/core/images/abre_glyph.png'){ unlink($oldimagelocation); }

			//Upload new image
			if (!file_exists("$portal_path_root/content/")){ mkdir("$portal_path_root/content/"); }
			$sitelogo = $uploaddir . $sitelogofilename;
			move_uploaded_file($_FILES['sitelogo']['tmp_name'], $sitelogo);
		}
		else
		{
			if (strpos($sitelogoexisting, '/content/') !== false)
			{
				$sitelogoexisting = ltrim($sitelogoexisting,"/content/");
			}
			$sitelogofilename=$sitelogoexisting;
		}

		$array = [ "sitetitle" => "$sitetitle", "sitecolor" => "$sitecolor", "sitedescription" => "$sitedescription", "sitelogintext" => "$sitelogintext", "siteanalytics" => "$siteanalytics", "siteadminemail" => "$siteadminemail", "sitevendorlinkurl" => "$sitevendorlinkurl", "sitevendorlinkidentifier" => "$sitevendorlinkidentifier", "sitevendorlinkkey" => "$sitevendorlinkkey", "sitelogo" => "$sitelogofilename", "studentdomain" => "$studentdomain", "studentdomainrequired" => "$studentdomainrequired", "parentaccess" => "$siteparentaccess", "googleclientid" => "$sitegoogleclientid", "googleclientsecret" => "$sitegoogleclientsecret", "facebookclientid" => "$sitefacebookclientid", "facebookclientsecret" => "$sitefacebookclientsecret", "microsoftclientid" => "$sitemicrosoftclientid", "microsoftclientsecret" => "$sitemicrosoftclientsecret", "abre_community" => "$abre_community", "community_first_name" => "$community_first_name", "community_last_name" => "$community_last_name", "community_email" => "$community_email", "community_users" => "$community_users" ];
		$json = json_encode($array);

		//Update the database
		mysqli_query($db, "UPDATE settings set options='$json'") or die (mysqli_error($db));

		//Notification message
		echo "Settings have been updated.";
	}

?>
