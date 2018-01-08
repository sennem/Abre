<?php

	/*
	* Copyright (C) 2016-2018 Abre.io Inc.
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

	if($_SESSION['usertype'] != 'parent'){

		try{
	
			//Set Access Token
			if(isset($_SESSION['access_token']) && $_SESSION['access_token']){ $client->setAccessToken($_SESSION['access_token']); }
	
			//Get Drive content
			$userData = $Service_Oauth2->userinfo->get();
			$lastWeek = date("c",strtotime("-1 week"));
			$hour_ago = strtotime('-1 day');

			$parameters['pageSize'] = 3;
			$parameters['orderBy'] = "modifiedByMeTime desc";
			$parameters['fields'] = "files(modifiedTime,name,owners/displayName,webViewLink)";
			$parameters['q'] = "trashed=false and '".$_SESSION['useremail']."' in writers";

			$Drive_Results = $Service_Drive->files->listFiles($parameters);
			
			$counter=0;
			foreach($Drive_Results as $file){
				$counter++;
				$json = json_encode($file);
				$json = json_decode($json, true);
				$drivetitle = $json['name'];
				$drivelink = $json['webViewLink'];
				$drivemodifydate = $json['modifiedTime'];
				$drivemodifydate = date("m/d g:i A", strtotime($drivemodifydate));
				
				
				if($counter==1){
					echo "<hr class='widget_hr'>";
					echo "<div class='widget_holder'>";
						echo "<div class='widget_container widget_body' style='color:#666;'>Your Recent Files <i class='right material-icons widget_holder_refresh pointer' data-path='/modules/drive/widget_content.php' data-reload='true'>refresh</i></div>";
					echo "</div>";
				}
				
				echo "<hr class='widget_hr'>";
					echo "<div class='widget_holder widget_holder_link pointer' data-link='$drivelink' data-path='/modules/drive/widget_content.php' data-reload='false'>";
					echo "<div class='widget_container widget_heading_h1 truncate'>$drivetitle</div>";
					echo "<div class='widget_container widget_body truncate'>$drivemodifydate</div>";
				echo "</div>";
				

			}
			
			if(empty($Drive_Results))
			{
				echo "<hr class='widget_hr'>";
				echo "<div class='widget_holder pointer'>";
					echo "<div class='widget_container widget_body truncate' style='color:#666;'>No Drive files <i class='right material-icons widget_holder_refresh pointer' data-path='/modules/drive/widget_content.php' data-reload='true'>refresh</i></div>";
				echo "</div>";
			}	

		}catch(Exception $e){ }
	
	}
	
?>

<script>

	$(function(){


		
	});

</script>