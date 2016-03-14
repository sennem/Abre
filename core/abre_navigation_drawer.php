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
	require_once('abre_verification.php');
	require_once('abre_google_login.php');
	require_once('abre_functions.php');

?>

	<!--Display the drawer-->
	<div class='drawer mdl-layout__drawer' id='drawer' style='border:none;'>
		<header class='drawer-header mdl-color--blue-800'>
			<?php
				echo "<img src='".$_SESSION['picture']."?sz=100' class='avatar'>";
				echo "<span class='mdl-color-text--white'>".$_SESSION['displayName']."</span>";
				echo "<span class='mdl-color-text--white'>".$_SESSION['useremail']."</span>";
			?>
		</header>
		
		<nav class='navigation mdl-navigation mdl-color--white'>
			<?php	
				
				for($modulecountloop = 0; $modulecountloop < $modulecount; $modulecountloop++)
				{	
					$pagetitle=$modules[$modulecountloop][1];
					$pageview=$modules[$modulecountloop][2];
					$pageicon=$modules[$modulecountloop][3];
					$pagepath=$modules[$modulecountloop][4];
					$drawerhidden=$modules[$modulecountloop][5];

					if($pageview==1 && $drawerhidden!=1)
					{
						echo "<a class='mdl-navigation__link' href='#$pagepath' onclick='toggle_drawer()'><i class='mdl-color-text--grey-500 material-icons drawericon' role='presentation'>$pageicon</i>$pagetitle</a>";
					}
				}
			?>

		</nav>
	</div>