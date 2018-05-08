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

	if($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator())
	{

		//Get Variables Passed to Page
		if(isset($_GET["id"])){ $id=htmlspecialchars($_GET["id"], ENT_QUOTES); }else{ $id=""; }

	    echo "<div class='col s12'>";
			echo "<ul class='tabs_2' style='background-color:"; echo getSiteColor(); echo "'>";
				echo "<li class='tab col s3 tab_1 formmenu pointer' data='#forms/builder/$id'><a href='#forms/builder/$id'>";
					echo "<span class='hide-on-small-only'>Build</span>";
					echo "<i class='material-icons hide-on-med-and-up'>build</i>";
				echo "</a></li>";
				echo "<li class='tab col s3 tab_2 formmenu pointer' data='#forms/preview/$id'><a href='#forms/preview/$id'>";
					echo "<span class='hide-on-small-only'>Preview</span>";
					echo "<i class='material-icons hide-on-med-and-up'>remove_red_eye</i>";
				echo "</a></li>";
				echo "<li class='tab col s3 tab_3 formmenu pointer' data='#forms/summary/$id'><a href='#forms/summary/$id'>";
					echo "<span class='hide-on-small-only'>Summary</span>";
					echo "<i class='material-icons hide-on-med-and-up'>insert_chart</i>";
				echo "</a></li>";
				echo "<li class='tab col s3 tab_4 formmenu pointer' data='#forms/responses/$id'><a href='#forms/responses/$id'>";
					echo "<span class='hide-on-small-only'>Responses (<span id='responseCount'>".getResponseCount($id)."</span>)</span>";
					echo "<i class='material-icons hide-on-med-and-up'>data_usage</i>";
				echo "</a></li>";
				echo "<li class='tab col s3 tab_5 formmenu pointer' data='#forms/settings/$id'><a href='#forms/settings/$id'>";
					echo "<span class='hide-on-small-only'>Settings</span>";
					echo "<i class='material-icons hide-on-med-and-up'>settings</i>";
				echo "</a></li>";
			echo "</ul>";
		echo "</div>";

	}

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