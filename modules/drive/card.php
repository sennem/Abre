<?php

	/*
	* Copyright (C) 2016-2017 Abre.io LLC
	*
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the Affero General Public License version 3
    * as published by the Free Software Foundation.
	*
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU Affero General Public License for more details.
	*
    * You should have received a copy of the Affero General Public License
    * version 3 along with this program.  If not, see https://www.gnu.org/licenses/agpl-3.0.en.html.
    */

	//Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_google_login.php');

	try{

		//Set access token
		if(isset($_SESSION['access_token']) && $_SESSION['access_token']){	$client->setAccessToken($_SESSION['access_token']); }

		//Get Gmail content
		if($client->getAccessToken()){

			$_SESSION['access_token'] = $client->getAccessToken();
?>

			<div class='mdl-card__title'>
				<div class='valign-wrapper'>
					<a href='https://drive.google.com' target='_blank'><img src='core/images/icon_drive.png' class='icon_small'></a>
					<div><div class='mdl-card__title-text'>Drive</div><div class='card-text-small'>Your Recent Files</div></div>
				</div>
			</div>

			<?php
			$userData = $Service_Oauth2->userinfo->get();
			$lastWeek = date("c",strtotime("-1 week"));
			$hour_ago = strtotime('-1 day');

			$parameters['pageSize'] = 3;
			$parameters['orderBy'] = "modifiedByMeTime desc";
			$parameters['fields'] = "files(modifiedTime,name,owners/displayName,webViewLink)";
			$parameters['q'] = "trashed=false and '".$_SESSION['useremail']."' in writers";

			$Drive_Results = $Service_Drive->files->listFiles($parameters);
			?>

			<div class='hide-on-small-only'>
			<div class='row' style='margin-bottom:0;'>

			<?php
			foreach($Drive_Results as $file){
				$json = json_encode($file);
				$json = json_decode($json, true);
				$drivetitle = $json['name'];
				$drivelink = $json['webViewLink'];
				$drivemodifydate = $json['modifiedTime'];
				$drivemodifydate = date("m/d g:i A", strtotime($drivemodifydate));

				echo "<hr>";
				echo "<div class='valign-wrapper'>";
					echo "<div class='col s10'>";
						echo "<div class='mdl-card__supporting-text subtext truncate demotext_dark'><b>$drivetitle</b><br>".$_SESSION['displayName']."<br>$drivemodifydate</div>";
					echo "</div>";
					echo "<div class='col s2'>";
						echo "<a href='$drivelink' target='_blank'><i class='material-icons mdl-color-text--grey-600'>play_circle_filled</i></a>";
					echo "</div>";
				echo "</div>";

			}
			?>

			</div>
			</div>

<?php
		}
	}catch(Exception $e){ }
?>