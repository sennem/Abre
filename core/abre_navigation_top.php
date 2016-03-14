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
	
?>

	<!--Display top navigation-->
	<header class='mdl-layout__header mdl-color--blue-800 mdl-color-text--white'>
		<div class='mdl-layout__header-row'>
			<span class='mdl-layout-title'><div id='titletext' class='truncate'></div></span>
			<div class='mdl-layout-spacer'></div>
			<a href='#apps' class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon'><i class='material-icons'>apps</i></a>
			<div class='navspace'></div>
			<?php
				echo "<a href='#profile' class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon'><img src='".$_SESSION['picture']."?sz=120' class='img-center' style='width:32px; height:32px;'></a>";
			?>
		</div>
	</header>