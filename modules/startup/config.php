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

	//Module Settings
	$drawerhidden=1;
	
	//Login Validation
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	
	//Check to see if user needs startup screen
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');	
	
	$sql = "SELECT * FROM profiles where email='".$_SESSION['useremail']."'";
	$result = $db->query($sql);
	$setting_startup_count=mysqli_num_rows($result);
	while($row = $result->fetch_assoc()) {
		$setting_startup=htmlspecialchars($row['startup'], ENT_QUOTES);
	}
	
	if($setting_startup==1 or $setting_startup_count==0)
	{
		
?>
	
		<div class='startup'>
			<div class="slider fullscreen">
				<ul class="slides mdl-color--blue-800">
					<li>
						<img src="modules/startup/startup_stream.jpg" class='hide-on-small-only'>
						<div class="caption center-align">
							<span class="startup_title">Stream</span><br><br>
							<span class="startup_text">Your stream displays cards that are tailored to your interests.<br>Customize your interests by updating your profile.</span>
						</div>
						<div class='startupbutton'><button class="mdl-button mdl-js-button mdl-button--raised mdl-color--grey-100 mdl-color-text--black next">Next</button></div>
					</li>
					<li>
						<img src="modules/startup/startup_apps.jpg" class='hide-on-small-only'>
						<div class="caption center-align">
							<span class="startup_title">Apps</span><br><br>
							<span class="startup_text">Your apps are available at the top of your stream and on the apps page.<br>Apps are displayed based on your role.</span>
						</div>
						<div class='startupbutton'><button class="mdl-button mdl-js-button mdl-button--raised mdl-color--grey-100 mdl-color-text--black next">Next</button></div>
					</li>
					<li>
						<img src="modules/startup/startup_profile.jpg" class='hide-on-small-only'>
						<div class="caption center-align">
							<span class="startup_title">Profile</span><br><br>
							<span class="startup_text">Your profile allows you to customize your experience.<br>Visit your profile page to update your settings.</span>
						</div>
						<div class='startupbutton'><button class="mdl-button mdl-js-button mdl-button--raised mdl-color--grey-100 mdl-color-text--black next">Next</button></div>
					</li>
					<li>
						<img src="modules/startup/startup_navigation.jpg" class='hide-on-small-only'>
						<div class="caption center-align">
							<span class="startup_title">Navigation</span><br><br>
							<span class="startup_text">To access your profile and other district portal features,<br>click the hamburger menu at the top left of your portal.</span>
						</div>
						<div class='startupbutton'><button class="mdl-button mdl-js-button mdl-button--raised mdl-color--grey-100 mdl-color-text--black next">Next</button></div>
					</li>
					<li>
						<img src="modules/startup/startup_feedback.jpg" class='hide-on-small-only'>
						<div class="caption center-align">
							<span class="startup_title">Feedback</span><br><br>
							<span class="startup_text">We welcome feedback!<br>Please leave feedback by clicking the question mark in the bottom left corner.</span>
						</div>
						<div class='startupbutton'><button class="mdl-button mdl-js-button mdl-button--raised mdl-color--grey-100 mdl-color-text--black close">Get Started</button></div>
					</li>					
    			</ul>
  			</div>  
		</div>
	
	
		<script>
		
			$(document).ready(function(){
				
				//Begin Startup
				$('.slider').slider({
					interval:999999,
					transition: 300
				});
				$('.slider').slider('pause');
				
				$( ".next" ).click(function() {
					$('.slider').slider('next');
					$('.slider').slider('pause');
				});
				
				$( ".close" ).click(function() {
					$('.startup').fadeOut();
					$('.slider').slider('pause');
					<?php 
						echo "$.ajax('$portal_root/modules/startup/setup.php');";	
						echo "window.location.href = '$portal_root/#';"; 
					?>
				});
			
			});
		        
		</script>
	
<?php
		
	}
	
?>