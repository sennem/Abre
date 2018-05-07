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
			echo "<div class='col l10 m8 s12' style='padding:0'>";
			echo "<nav style='font-size: 22px !important; padding:10px; background-color:"; echo getSiteColor(); echo ";'>";
				echo "<div class='nav-wrapper'>";
					echo "<div class='input-field col s12 darkselect'>";
						echo "<select id='choosereport'>";
							echo "<option value='' disabled selected>Choose a report</option>";
							echo "<option value=''>All Consequences</option>";
							$sql = "SELECT Consequence FROM conduct_consequences ORDER BY Consequence";

							$dbreturn = databasequery($sql);
							foreach($dbreturn as $value){
								$consequence = $value['Consequence'];
								echo "<option value='$consequence'>$consequence</option>";
							}
						echo "</select>";
					echo "</div>";
				echo "</div>";
			echo "</nav>";
			echo "</div>";

			echo "<div class='col l2 m4 s12' style='padding:0; padding-left:5px;'>";
				echo "<nav style='background-color:"; echo getSiteColor(); echo ";'>";
			    	echo "<div class='nav-wrapper'>";
						echo "<div class='input-field darkselect'>";
							echo "<input id='reportdate' type='search' placeholder='Date' autocomplete='off' class='datepickerformatted'>";
						echo "</div>";
					echo "</div>";
				echo "</nav>";
			echo "</div>";

		echo "</div>";

		echo "<div class='row' style='display:none;'>";
			echo "<div id='p2' class='mdl-progress mdl-js-progress mdl-progress__indeterminate' style='width:100%;'></div>";
		echo "</div>";
	echo "</div>";
?>

<script>

	$(function(){
		//$(".select-wrapper input.select-dropdown").css("display", "none !important");

		$('select').material_select();
		$('.datepickerformatted').pickadate({ container: 'body',  format: 'yyyy-mm-dd', selectMonths: true, selectYears: 15 });
  	});

</script>