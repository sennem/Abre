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

	//Include required files
	require_once(dirname(__FILE__) . '/../configuration.php');
	require_once('abre_functions.php');
?>

	<!-- Display the login -->
	<div class="mdl-layout mdl-js-layout login-card">
		<div class="login_wrapper">
			<div class="login-card-square mdl-card animated fadeIn">
				<div class="mdl-card__title mdl-card--expand" style='width:200px; height:200px; background:url(<?php echo getSiteLogo(); ?>) center center no-repeat; -webkit-background-size:cover; -moz-background-size:cover; -o-background-size:cover; background-size:cover; margin-left:20px; margin-bottom:5px;'></div>
				<?php
					echo "<div class='mdl-card-text mdl-color-text--grey-600'>".getSiteLoginText()."</div>";

			  		echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' href='$authUrl' style='margin: 0 auto; width:100%; text-transform:none; background-color:".getSiteColor()."'>Staff and Student Login</a>";
						if(getSiteParentAccess() == "checked"){
							echo "<div style='padding-top: 1em'>";
								echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' href='?usertype=Parent' style='margin:0 auto; width:100%; text-transform:none; background-color:".getSiteColor()."'>Parent Login</a>";
							echo "</div>";
						}
				?>
			</div>
		</div>
	</div>

<script>

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

</script>