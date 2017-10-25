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
	require_once('abre_verification.php');
	require_once('abre_google_login.php');
	require_once('abre_functions.php');
?>

	<!--Display the drawer-->
	<div class='drawer mdl-layout__drawer' id='drawer' style='border:none;'>
		<header class='drawer-header' style='background-color: <?php echo getSiteColor(); ?>'>
			<?php
				echo "<img src='".$_SESSION['picture']."?sz=100' class='avatar'>";
				echo "<span class='mdl-color-text--white truncate'>".$_SESSION['displayName']."</span>";
				echo "<span class='mdl-color-text--white truncate'>".$_SESSION['useremail']."</span>";
			?>
		</header>
		<nav class='navigation mdl-navigation mdl-color--white'>
			<?php
				//Load Modules
				for($modulecountloop = 0; $modulecountloop < $modulecount; $modulecountloop++){
					$pagetitle = $modules[$modulecountloop][1];
					$pageview = $modules[$modulecountloop][2];
					$pageicon = $modules[$modulecountloop][3];
					$pagepath = $modules[$modulecountloop][4];
					$drawerhidden = $modules[$modulecountloop][5];

					if($pageview == 1 && $drawerhidden != 1){
						echo "<a class='mdl-navigation__link' href='#$pagepath' onclick='toggle_drawer()'>";
							echo "<i class='mdl-color-text--grey-500 material-icons drawericon' role='presentation'>$pageicon</i>";
							echo "<span class='truncate'>$pagetitle</span>";
						echo "</a>";
					}
				}

				//Feedback link
				if($_SESSION['usertype'] == "staff")
				{
					echo "<div class='mdl-menu__item--full-bleed-divider' style='margin:10px 0 10px 0'></div>";
					echo "<a class='mdl-navigation__link modal-trigger' href='#feedback' onclick='toggle_drawer()'><i class='mdl-color-text--grey-500 material-icons drawericon' role='presentation'>help</i><span class='truncate'>Send Feedback</span></a>";
				}

				//Modules link
				if(superadmin() && $_SESSION['usertype'] == "staff")
				{
					echo "<a class='mdl-navigation__link' href='#store' onclick='toggle_drawer()'><i class='mdl-color-text--grey-500 material-icons drawericon' role='presentation'>store</i><span class='truncate'>Store</span></a>";
				}

				//Settings link
				if(superadmin() && $_SESSION['usertype'] == "staff")
				{
					echo "<a class='mdl-navigation__link' href='#settings' onclick='toggle_drawer()'><i class='mdl-color-text--grey-500 material-icons drawericon' role='presentation'>settings</i><span class='truncate'>Settings</span></a>";
				}
			?>
		</nav>
	</div>