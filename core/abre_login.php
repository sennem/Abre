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
	
?>

<!-- Display the Login -->
<div class="mdl-layout mdl-js-layout mdl-color--blue-800">
	<div class="login_wrapper">	  	
		
		<div class="login-card-square mdl-card mdl-shadow--2dp animated fadeIn">
			<div class="mdl-card__title mdl-card--expand"></div>
			<?php
				$site_login_text=constant("SITE_LOGIN_TEXT");
				echo "<div class='mdl-card-text'>$site_login_text</div>";
			?>
	  		<div class="mdl-card__actions mdl-card--border">	  		
	  		<?php echo "<a class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--blue-800' href='$authUrl' style='margin: 0 auto;'>Sign In</a>"; ?>
	  		</div>
		</div>
		
	</div>      	
</div>