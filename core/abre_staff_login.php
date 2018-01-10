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
	
	//Display the Login
	echo "<main>";
	
		//Overlay Div
		echo "<div id='loadingcover' style='background-color:".getSiteColor()."; position:fixed; width:100%; height:100%; z-index:2'></div>";
	
		//Login Holder
		echo "<div class='mdl-layout mdl-js-layout login-card' style='background-color:".getSiteColor()."; background-image: url(/core/images/abre_pattern.png); '>";

			echo "<div class='login_wrapper'>";
				echo "<div class='login-card-square mdl-card'>";
					
						echo "<div style='height:240px; width:240px; background:url(". getSiteLogo() .") center center no-repeat; margin-bottom:10px; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;'></div>";
						
						//Site Login Text
						echo "<div class='mdl-card-text mdl-color-text--grey-600' style='text-align:center; max-width:240px;'>Choose a sign in service</div>";
						
						//SSO Options
						echo "<div style='padding-top: 5px'>";
							include "abre_button_google.php";
						echo "</div>";
						
						//Return Text
						echo "<div class='mdl-color-text--grey-600' style='text-align:center; max-width:240px; margin-top:30px; font-size:14px;'><a href='/' style='color:#757575;'>Return Home</a></span></div>";

				   ?>
				</div>
			</div>
		</div>
	
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