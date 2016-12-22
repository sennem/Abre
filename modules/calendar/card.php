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
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']){ $client->setAccessToken($_SESSION['access_token']); }
	
	try {
	
		//Get calendar content
		if ($client->getAccessToken())
		{
			
			$_SESSION['access_token'] = $client->getAccessToken();
			$rightNow = date('c');
			$inOneDay = date('c', strtotime('+1 days'));
			$inTwoDays = date('c', strtotime('+2 days'));
			$params = array('singleEvents' => 'true', 'orderBy' => 'startTime', 'timeMin' => $rightNow, 'timeMax' => $inOneDay);
			$events = $Service_Calendar->events->listEvents('primary', $params);
			
			?>
		
			
			<div class='mdl-card__title'>
				<div class='valign-wrapper'>
					<a href='https://calendar.google.com' target='_blank'><img src='core/images/icon_calendar.png' class='icon_small'></a>
					<div><div class='mdl-card__title-text'>Calendar</div><div class='card-text-small'>Your Next 24 Hours</div></div>
				</div>
			</div>
		
			<div class='row' style='margin-bottom:0;'>
				
				<?php
					foreach ($events->getItems() as $event)
					{
						$eventitle=$event->getSummary();
						$eventlink=$event->getHtmlLink();
						$eventlocation=$event->getLocation();
						if($eventlocation==""){ $eventlocation="Location: None Listed"; }else{ $eventlocation="Location: $eventlocation"; }
						$eventdescription=$event->getDescription();
						if($eventdescription==""){ $eventdescription="No Description"; }else{ $eventdescription="Summary: $eventdescription"; }
						
						$AllDayCheck=$event->getStart()->getDate();
						if($AllDayCheck==NULL)
						{			
							$starttime=$event->getStart()->getDateTime();
							$starttime = date("m/d g:i A", strtotime($starttime));
							$endtime=$event->getEnd()->getDateTime();
							$endtime = date("m/d g:i A", strtotime($endtime));
							$timeofevent="$starttime to $endtime";
						}
						else
						{
							$timeofevent=substr($AllDayCheck , 5, 2)."/".substr($AllDayCheck , 8, 2);
							$timeofevent="$timeofevent - All Day Event";
						}
						
							echo "<hr>";
							echo "<div class='valign-wrapper'>";
							echo "<div class='col s10'>";
								echo "<div class='mdl-card__supporting-text subtext truncate demotext_dark'><b>$eventitle</b>";
								if($eventdescription!="No Description"){ echo "<br>$eventdescription"; }
								echo "<br>$timeofevent</div>";
							echo "</div>";
							echo "<div class='col s2'>";
								echo "<a href='$eventlink' target='_blank'><i class='material-icons mdl-color-text--grey-600'>play_circle_filled</i></a>";
							echo "</div>";
							echo "</div>";
		
					}
				?>
			
			</div>
		<?php
		}
		
	}
	
	catch(Exception $e){ }

?>