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

	//Include required files
	require_once(dirname(__FILE__) . '/../configuration.php');
	require_once('abre_functions.php');
  require(dirname(__FILE__). '/facebook/src/Facebook/autoload.php');


  if(sitesettings('facebookclientid') !== '' && sitesettings('facebookclientsecret') !== '' ){
    $fb = new Facebook\Facebook([
      'app_id' => sitesettings('facebookclientid'), // Replace {app-id} with your app id
      'app_secret' => sitesettings('facebookclientsecret'),
      'default_graph_version' => 'v2.9',
      ]);

    $helper = $fb->getRedirectLoginHelper();

    $permissions = ['public_profile', 'email']; // Optional permissions
    $loginUrl = $helper->getLoginUrl($portal_root.'/core/abre_facebook_login_helper.php/', $permissions);
  }

	if(sitesettings('googleclientid') !== '' && sitesettings('googleclientsecret') !== '' ){

		require_once('abre_parent_google_authentication.php');
		$authUrl = $client->createAuthUrl();
	}
?>
	<!-- Display the login -->
	<div class="mdl-layout mdl-js-layout login-card">
		<div class="login_wrapper">

			<div class="login-card-square mdl-card animated fadeIn">
				<div class="mdl-card__title mdl-card--expand" style='width:200px; height:200px; background: url(<?php echo sitesettings('sitelogo'); ?>) center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; margin-left:20px; margin-bottom:5px;'></div>
				<?php
					echo "<div class='mdl-card-text mdl-color-text--grey-600'>Please log in with one of the following services</div>";
					if(sitesettings('googleclientid') !== '' && sitesettings('googleclientsecret') !== '' ){
						echo "<div style= 'padding-top: 1em'>";
							echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' style='text-align:left; width:100%; text-transform:none; background-color:#BF4434; font-size:14px' href='$authUrl'><i class='fa fa-google material-icons left' ></i>Login with Google</a>";
						echo "</div>";
					}
          if(sitesettings('facebookclientid') !== '' && sitesettings('facebookclientsecret') !== '' ){
						echo "<div style= 'padding-top: 1em'>";
							echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' href='".htmlspecialchars($loginUrl)."' style='text-align:left; width:100%; text-transform:none; background-color:#1A60A2; font-size:14px'><i class='fa fa-facebook material-icons left'></i>Login with Facebook</a>";
						echo "</div>";
          }
					if(sitesettings('microsoftclientid') !== '' && sitesettings('microsoftclientsecret') !== '' ){
						echo "<div style= 'padding-top: 1em'>";
							echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' href='https://login.microsoftonline.com/common/oauth2/v2.0/authorize?client_id=".sitesettings('microsoftclientid')."&response_type=code&redirect_uri=http://localhost/core/microsoft_login_helper.php&response_mode=form_post&scope=openid%20profile&state=12345&prompt=consent' style='text-align:left; width:100%; text-transform:none; background-color:#0078d7; font-size:14px'><i class='fa fa-windows material-icons left'></i>Login with Microsoft</a>";
						echo "</div>";
					}
			  	?>
			</div>

		</div>
	</div>

	<script>

		//Responsive login view
		function loginWidthCheck()
		{
			if ($(window).width() < 600) {
				$( ".login-card-square" ).removeClass( "mdl-shadow--2dp" );
				$( ".login-card" ).addClass( "mdl-color--white" );
			}
			else
			{
				$( ".login-card-square" ).addClass( "mdl-shadow--2dp" );
				$( ".login-card" ).removeClass( "mdl-color--white" );
			}
		}

		loginWidthCheck();
		$(window).resize(loginWidthCheck);

	</script>
