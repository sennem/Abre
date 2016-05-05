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
	require_once(dirname(__FILE__) . '/../configuration.php'); 
	
?>

<!-- Display the Login -->
<div class="mdl-layout mdl-js-layout login-card">
	<div class="login_wrapper">	  	
		
		<div class="login-card-square mdl-card animated fadeIn">
			<div class="mdl-card__title mdl-card--expand"></div>
			<?php
				$site_login_text=constant("SITE_LOGIN_TEXT");
				echo "<div class='mdl-card-text mdl-color-text--grey-600'>$site_login_text</div>";
			?>
	  		<div class="mdl-card__actions">	  		
	  		<?php 
		  		echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' href='$authUrl' style='margin: 0 auto; width:100%; background-color:#145bab; text-transform:none;'>Sign in with Google</a>"; 
		  	?>
	  		</div>
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