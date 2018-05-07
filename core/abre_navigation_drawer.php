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
	require_once('abre_verification.php');
	require_once('abre_google_login.php');
	require_once('abre_functions.php');
?>

	<!--Display the drawer-->
	<div class='drawer mdl-layout__drawer' id='drawer' style='border:none;'>
		<header class='drawer-header' style='background-color: <?php echo getSiteColor(); ?>'>
			<?php
				echo "<img src='".$_SESSION['picture']."?sz=100' class='avatar' alt='User Profile Photo'>";
				echo "<span class='mdl-color-text--white truncate'>".$_SESSION['displayName']."</span>";
				echo "<span class='mdl-color-text--white truncate'>".$_SESSION['useremail']."</span>";
			?>
		</header>
		<nav class='navigation collapse mdl-navigation' style='background-color: #fdfdfd;'>
			<?php
				//Load Modules
				for($modulecountloop = 0; $modulecountloop < $modulecount; $modulecountloop++){
					$pagetitle = $modules[$modulecountloop][1];
					$pageview = $modules[$modulecountloop][2];
					$pageicon = $modules[$modulecountloop][3];
					$pagepath = $modules[$modulecountloop][4];
					$drawerhidden = $modules[$modulecountloop][5];
					$subpages = $modules[$modulecountloop][6];

					$pagepathArray = explode('/', $pagepath);
					$pageHighlighting = $pagepathArray[0];

					if($pageview == 1 && $drawerhidden != 1){

						echo "<li style='display:block;'>";
							echo "<div class='collapsible-header mainapplink' id='abreapp_$pageHighlighting' style='padding:0; border-bottom: 0;'>";;
									if($subpages!=NULL){
										echo "<span class='mdl-navigation__link' ";
									}else{
										echo "<span class='mdl-navigation__link path' data-path='#$pagepath' ";
										echo "onclick='toggle_drawer()' ";
									}
									echo ">";
										echo "<i class='material-icons drawericon' style='margin-left:-3px; color: #747474' role='presentation'>$pageicon</i>";
										echo "<span class='truncate'>$pagetitle</span>";
									echo "</span>";
							echo "</div>";

							if($subpages!=NULL){

								foreach ($subpages as $key => $sublinks){

									$pagepath=$sublinks['path'];
									echo "<div class='collapsible-body pointer' style='border:0;'>";
										echo "<span class='mdl-navigation__link path' data-path='#$pagepath' onclick='toggle_drawer()'>";
										echo "<span class='truncate' style='margin-left:75px; font-weight:normal !important;'>";
											echo $sublinks['title'];
										echo "</span></span>";
									echo "</div>";

								}

							}

						echo "</li>";

					}
				}

				//Feedback link
				if($_SESSION['usertype'] == "staff")
				{
					echo "<div class='mdl-menu__item--full-bleed-divider' style='margin:10px 0 10px 0'></div>";

					echo "<li style='display:block;'>";
						echo "<div class='collapsible-header mainapplink' style='padding:0; background-color:none; border-bottom: 0;'>";
							echo "<a class='mdl-navigation__link modal-trigger' href='#feedback' onclick='toggle_drawer()'>";
							echo "<i class='material-icons drawericon' style='margin-left:-3px; color: #747474' role='presentation'>help</i>";
							echo "<span class='truncate'>Send Feedback</span></a>";
						echo "</div>";
					echo "</li>";
				}

				//Modules link
				if(superadmin())
				{
					echo "<li style='display:block;'>";
						echo "<div class='collapsible-header mainapplink' id='abreapp_store' style='padding:0; background-color:none; border-bottom: 0;'>";
							echo "<span class='mdl-navigation__link path' data-path='#store' onclick='toggle_drawer()'>";
							echo "<i class='material-icons drawericon' style='margin-left:-3px; color: #747474' role='presentation'>store</i>";
							echo "<span class='truncate'>Store</span></span>";
						echo "</div>";
					echo "</li>";
				}

				//Settings link
				if(admin())
				{
					echo "<li style='display:block;'>";

						echo "<div class='collapsible-header mainapplink' id='abreapp_settings' style='padding:0; background-color:none; border-bottom: 0;'>";
							echo "<span class='mdl-navigation__link path' data-path='#settings' onclick='toggle_drawer()'>";
							echo "<i class='material-icons drawericon' style='margin-left:-3px; color: #747474' role='presentation'>settings</i>";
							echo "<span class='truncate'>Settings</span></span>";
						echo "</div>";
					echo "</li>";
				}
			?>
		</nav>
	</div>

<script>

	$(function(){

		$('.collapse').collapsible();

		//Make Links Clickable
		$(".path").unbind().click(function(){
			var Path = $(this).data('path');
			if(Path!=''){
				window.location = Path;
			}
		});

	});

</script>