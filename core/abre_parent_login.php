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

	//Include required files
	require_once(dirname(__FILE__) . '/../configuration.php');
	require_once('abre_functions.php');
  require(dirname(__FILE__). '/facebook/src/Facebook/autoload.php');

  if(getSiteFacebookClientId() !== '' && getSiteFacebookClientSecret() !== '' ){
		$fb = new Facebook\Facebook([
			'app_id' => getSiteFacebookClientId(),
			'app_secret' => getSiteFacebookClientSecret(),
      'default_graph_version' => 'v2.9',
		]);

    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['public_profile', 'email']; // Optional permissions
    $loginUrl = $helper->getLoginUrl($portal_root.'/core/abre_facebook_login_helper.php/', $permissions);
  }

	if(getSiteGoogleClientId() !== '' && getSiteGoogleClientSecret() !== '' ){
		require_once('abre_parent_google_authentication.php');
		$authUrl = $client->createAuthUrl();
	}
	$url = $portal_root . '/core/abre_microsoft_login_helper.php&response_mode=form_post&scope=openid%20profile&state=12345&prompt=consent';
	
	//Overlay Div
	echo "<div id='loadingcover' style='background-color:".getSiteColor()."; position:fixed; width:100%; height:100%; z-index:2'></div>";

	echo "<div class='mdl-layout mdl-js-layout login-card' style='background-color:".getSiteColor()."; background-image: url(/core/images/abre_pattern.png); '>";
?>
		<!-- Display the login -->
		<div class="login_wrapper">
			<div class="login-card-square mdl-card">
				
				<?php
					echo "<div style='height:240px; background:url(". getSiteLogo() .") center center no-repeat; margin-bottom:10px; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;'></div>";
				?>
				
				<?php
					echo "<div class='mdl-card-text mdl-color-text--grey-600' style='text-align:center;'>Please log in with one of the following services</div>";
					if(getSiteGoogleClientId() !== '' && getSiteGoogleClientSecret() !== '' ){
						echo "<div style='padding-top:1em'>";
							echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' style='text-align:left; width:100%; text-transform:none; background-color:#BF4434; font-size:14px' href='$authUrl'><i class='fa fa-google material-icons left' style='width:20px'></i>Login with Google</a>";
						echo "</div>";
					}
          if(getSiteFacebookClientId() !== '' && getSiteFacebookClientSecret() !== '' ){
						echo "<div style='padding-top:1em'>";
							echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' href='".htmlspecialchars($loginUrl)."' style='text-align:left; width:100%; text-transform:none; background-color:#1A60A2; font-size:14px'><i class='fa fa-facebook material-icons left' style='width:20px'></i>Login with Facebook</a>";
						echo "</div>";
          }
					if(getSiteMicrosoftClientId() !== '' && getSiteMicrosoftClientSecret() !== '' ){
						echo "<div style='padding-top:1em'>";
							echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' href='https://login.microsoftonline.com/common/oauth2/v2.0/authorize?client_id=".getSiteMicrosoftClientId()."&response_type=code&redirect_uri=$url 'style='text-align:left; width:100%; text-transform:none; background-color:#0078d7; font-size:14px'><i class='fa fa-windows material-icons left' style='width:20px'></i>Login with Microsoft</a>";
						echo "</div>";
					}
			   ?>
			</div>
		</div>
	</div>

<script>
	
	$(function(){
		
		$("#loadingcover").delay(300).fadeOut();
	
		//Responsive login view
		function loginWidthCheck(){
			if ($(window).width() < 600){
				$(".login-card-square").removeClass("mdl-shadow--2dp");
				$(".login-card").addClass("mdl-color--white");
			}else{
				$(".login-card-square").addClass("mdl-shadow--2dp");
				$(".login-card").removeClass("mdl-color--white");
			}
		}
	
		loginWidthCheck();
		$(window).resize(loginWidthCheck);
		
	});

</script>
