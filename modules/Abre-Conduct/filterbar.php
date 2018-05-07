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

	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');

	echo "<div class='page_container'>";
		echo "<div class='row'>";
			echo "<div class='col l8 m4 s12' style='padding:0'>";
				echo "<nav style='background-color:"; echo getSiteColor(); echo ";'>";
			    	echo "<div class='nav-wrapper'>";
							echo "<form id='search'>";
								echo "<div class='input-field'>";
									echo "<input id='conductsearchquery' type='search' placeholder='Search' autocomplete='off'>";
									echo "<label class='label-icon' for='conductsearchquery'><i class='material-icons'>search</i></label>";
								echo "</div>";
							echo "</form>";
						echo "</div>";
				echo "</nav>";
			echo "</div>";

			echo "<div class='col l2 m4 s12' style='padding:0; padding-left:5px;'>";
				echo "<nav style='background-color:"; echo getSiteColor(); echo ";'>";
			    	echo "<div class='nav-wrapper'>";
							echo "<div class='input-field'>";
								echo "<input id='conductsearchqueryfrom' type='search' placeholder='From' autocomplete='off' class='datepickerformatted'>";
							echo "</div>";
						echo "</div>";
				echo "</nav>";
			echo "</div>";

			echo "<div class='col l2 m4 s12' style='padding:0; padding-left:5px;'>";
				echo "<nav style='background-color:"; echo getSiteColor(); echo ";'>";
			    	echo "<div class='nav-wrapper'>";
							echo "<div class='input-field'>";
								echo "<input id='conductsearchquerythru' type='search' placeholder='Thru' autocomplete='off' class='datepickerformatted'>";
							echo "</div>";
						echo "</div>";
				echo "</nav>";
			echo "</div>";

			echo "<input id='conductsearchquerypage' type='hidden'>";

		echo "</div>";

		echo "<div class='row' id='conductsearch' style='display:none;'>";
			echo "<div id='p2' class='mdl-progress mdl-js-progress mdl-progress__indeterminate' style='width:100%;'></div>";
		echo "</div>";

	echo "</div>";
?>

<script>

	$(function(){
		$('.datepickerformatted').pickadate({
			container: 'body',
			format: 'yyyy-mm-dd',
			selectMonths: true, selectYears: 15
		});
	});

</script>