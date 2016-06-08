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
	<header class='mdl-layout__header mdl-color-text--white' style='background-color: <?php echo sitesettings("sitecolor"); ?>'>
			<div class='mdl-layout__header-row'>
				<?php
					if(!isset($_GET["dash"]))
					{ 
						echo "<span class='mdl-layout-title'><div id='titletext' class='truncate'></div></span>";
					}
					else
					{
						echo "<span class='mdl-layout-title' style='margin-left:-40px;'><div id='titletext' class='truncate'></div></span>";
					}
				?>
				<div class='mdl-layout-spacer'></div>
					<?php
						if(!isset($_GET["dash"]))
						{ 
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
			
	//Scroll to top
	$('.mdl-layout__header-row').click(function(e)
	{
		if(e.target == e.currentTarget)
		{
			$(".mdl-layout__content").animate({ scrollTop: $(".page-content").height() }, "fast");
			return false;
		}
	});
	
</script>