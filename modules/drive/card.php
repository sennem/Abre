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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_google_login.php'); 

	//Set access token
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']){	$client->setAccessToken($_SESSION['access_token']); }
	
	//Get Gmail content
	if ($client->getAccessToken()){
		
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
		$lastWeek=date("c",strtotime("-1 week"));
		$parameters['q'] = "trashed = false and mimeType != 'application/vnd.google-apps.folder' and '".$_SESSION['useremail']."' in owners and modifiedDate > '$lastWeek'";
		$userData = $Service_Oauth2->userinfo->get();
		$hour_ago = strtotime('-1 day');
		$parameters['maxResults'] = "3";
		$parameters['q'] = "trashed = false and mimeType != 'application/vnd.google-apps.folder' and '".$_SESSION['useremail']."' in owners";
		$Drive_Results = $Service_Drive->files->listFiles($parameters);
		?>
		
		<div class='hide-on-small-only'>
		<div class='row' style='margin-bottom:0;'>
		
			<?php
			foreach ($Drive_Results->getItems() as $event)
			{
				
				$drivelink=$event->getAlternateLink();
				$drivetitle=$event->getTitle();
				$driveicon=$event->getIconLink();
				$drivelasteditedby=$event->getLastModifyingUserName();
				$drivemodifydate=$event->getModifiedDate();
				$drivemodifydate = date("m/d g:i A", strtotime($drivemodifydate));
				$icon=$event->getIconLink();
				$embedlink=$event->getEmbedLink();
	
				echo "<hr>";
				echo "<div class='valign-wrapper'>";
					echo "<div class='col s10'>";
						echo "<div class='mdl-card__supporting-text subtext truncate'><b>$drivetitle</b><br>$drivelasteditedby<br>$drivemodifydate</div>";
					echo "</div>";
					echo "<div class='col s2'>";
						echo "<a href='$drivelink' target='_blank'><i class='material-icons mdl-color-text--grey-400'>play_circle_filled</i></a>";
					echo "</div>";
				echo "</div>";
			}
			?>	
		
		</div>
		</div>
	
	<?php	
	}
	
?>