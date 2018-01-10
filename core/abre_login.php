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
?>

	<!-- Display the login -->
	<main>
		
		<?php
			
			//Overlay Div
			echo "<div id='loadingcover' style='background-color:".getSiteColor()."; position:fixed; width:100%; height:100%; z-index:2'></div>";
			
			//Login Holder
			echo "<div class='mdl-layout mdl-js-layout login-card' style='background-color:".getSiteColor()."; background-image: url(/core/images/abre_pattern.png); '>";
			
				echo "<div class='login_wrapper'>";
					echo "<div class='login-card-square mdl-card'>";
						
						//Site Logo
						echo "<div style='height:240px; width:240px; background:url(". getSiteLogo() .") center center no-repeat; margin-bottom:10px; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;'></div>";
						
						//Site Login Text
						echo "<div class='mdl-card-text mdl-color-text--grey-600' style='text-align:center; max-width:240px;'>".getSiteLoginText()."</div>";
		
						//Staff and Student Login
					  	echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' href='$authUrl' style='margin: 0 auto; width:100%; text-transform:none; background-color:".getSiteColor()."'>Staff and Student Login</a>";
						
						//Parent Login	
						if(getSiteParentAccess() == "checked"){
							echo "<div style='padding-top: 1em'>";
								echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' href='?usertype=Parent' style='margin:0 auto; width:100%; text-transform:none; background-color:".getSiteColor()."'>Parent Login</a>";
							echo "</div>";
						}
					
					echo "</div>";
				echo "</div>";
				
			echo "</div>";
		
		?>
	
	</main>

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