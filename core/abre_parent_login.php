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
  $fb = new Facebook\Facebook([
    'app_id' => '1437651372975104', // Replace {app-id} with your app id
    'app_secret' => '9f1fcbb500aec4aca39d95ca672823df',
    'default_graph_version' => 'v2.9',
    ]);

  $helper = $fb->getRedirectLoginHelper();

  $permissions = ['public_profile', 'email']; // Optional permissions
  $loginUrl = $helper->getLoginUrl('http://localhost/core/facebook_login_helper.php/', $permissions);
?>

	<!-- Display the login -->
	<div class="mdl-layout mdl-js-layout login-card">
		<div class="login_wrapper">

			<div class="login-card-square mdl-card animated fadeIn">
				<div class="mdl-card__title mdl-card--expand" style='width:200px; height:200px; background: url(<?php echo sitesettings('sitelogo'); ?>) center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; margin-left:20px; margin-bottom:5px;'></div>
				<?php
					echo "<div class='mdl-card-text mdl-color-text--grey-600'>Please log in with one of the following services</div>";
          echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
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

    function fbLogin() {
        var oauth_url = 'https://www.facebook.com/dialog/oauth/';
        oauth_url += '?client_id=1437651372975104';
        oauth_url += '&redirect_uri=' + encodeURIComponent('http://localhost/index.php');
        oauth_url += '&scope=email'
        window.top.location = oauth_url;
    }
	</script>
