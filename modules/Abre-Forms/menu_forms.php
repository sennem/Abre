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

	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once("functions.php");

    echo "<div class='col s12'>";
		echo "<ul class='tabs_2' style='background-color:"; echo getSiteColor(); echo "'>";

			if($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator()){
				echo "<li class='tab col s3 tab_1 formmenu pointer' data='#forms'><a href='#forms'>";
					echo "<span class='hide-on-small-only'>My Forms</span>";
					echo "<i class='material-icons hide-on-med-and-up'>assignment_turned_in</i>";
				echo "</a></li>";

				echo "<li class='tab col s3 tab_2 formmenu pointer' data='#forms/sharedforms'><a href='#forms/sharedforms'>";
					echo "<span class='hide-on-small-only'>Shared With Me</span>";
					echo "<i class='material-icons hide-on-med-and-up'>people_outline</i>";
				echo "</a></li>";

				echo "<li class='tab col s3 tab_3 formmenu pointer' data='#forms/recommended'><a href='#forms/recommended'>";
					echo "<span class='hide-on-small-only'>"; echo $_SESSION['usertype']; echo " Forms</span>";
					echo "<i class='material-icons hide-on-med-and-up'>bookmark</i>";
				echo "</a></li>";
			}

			if(admin() || isFormsAdministrator()){
				echo "<li class='tab col s3 tab_4 formmenu pointer' data='#forms/templates'><a href='#forms/templates'>";
					echo "<span class='hide-on-small-only'>Templates</span>";
					echo "<i class='material-icons hide-on-med-and-up'>verified_user</i>";
				echo "</a></li>";
			}

		echo "</ul>";
	echo "</div>";

?>

<script>

	$(function()
	{
		$( ".formmenu" ).click(function()
		{
			window.open($(this).attr("data"), '_self');
		});
	});

</script>