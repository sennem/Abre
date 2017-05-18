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
	require_once('abre_verification.php');
	require_once('abre_functions.php');

?>

	<!--Display top navigation-->
	<header class='mdl-layout__header mdl-color-text--white' style='background-color: <?php echo sitesettings("sitecolor"); ?>'>
		<div class='mdl-layout__header-row'>
			<span class='mdl-layout-title'><div id='titletext' class='truncate'></div></span>
			<div class='mdl-layout-spacer'></div>
				<?php
					if(!isset($_GET["dash"]))
					{
						if($_SESSION['usertype'] == 'parent'){
							echo "<a id='addstudent' class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon modal-verifystudent' href='#verifystudent' style='margin-right:10px'><i class='material-icons'>add</i></a>";
							isVerified();
						}
						echo "<a class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon modal-viewapps' href='#viewapps'><i class='material-icons'>apps</i></a>";
					}
				?>
				<div class='navspace'></div>
				<?php
						echo "<a href='#viewprofile' class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon modal-viewprofile'><img src='".$_SESSION['picture']."?sz=120' class='img-center' style='width:32px; height:32px;'></a>";
				?>
			</div>
		<div id='navigation_top'></div>
	</header>

<script>

	$(function()
	{

		//Scroll to top
		$('.mdl-layout__header-row').click(function()
		{
			$('.mdl-layout__content').animate({ scrollTop: 0 }, 'fast');
		});

	});

</script>
