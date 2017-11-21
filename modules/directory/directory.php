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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('permissions.php');

	//Show the Search and Last 10 Modified Users
	if($pageaccess == 1 or $_SESSION['usertype'] == "staff"){

		$sql = "SELECT * FROM directory WHERE archived = 0";
		$dbreturn = databasequery($sql);
		$num_users = count($dbreturn);
		if($num_users > 0){
			echo "<div class='page_container mdl-shadow--4dp'>";
				echo "<div class='page'>";

					//Search
					echo "<form id='form-search' method='post' action='modules/directory/searchresults.php'>";
						echo "<div class='row'>";
							echo "<div class='input-field col s12'>";
								echo "<input placeholder='Lastname or Building' id='searchquery' name='searchquery' autocomplete='off' type='text'>";
								echo "<label for='searchquery' class='active'>Search</label>";
							echo "</div>";
						echo "</div>";
					echo "</form>";

					//Display Recent Searches
					echo "<div id='searchresults'>";
						include "searchresults.php";
					echo "</div>";

				echo "</div>";
			echo "</div>";
		}else{
			echo "<div class='row center-align'><div class='col s12'><h6>No Active Staff</h6></div><div class='col s12'>Click the '+' button at the bottom left to add a staff member.</div></div>";
		}

		if($pageaccess == 1){ include "button.php"; }
?>

<script>

		//Process the profile form
		$(function(){

			//Press the search data
			var form = $('#form-search');
			$(form).submit(function(event) {
				event.preventDefault();
				$.ajax({
				    type: 'POST',
				    data: $('#searchquery').serialize(),
				    url: $(form).attr('action'),
				    success: function(data) {
				    	$('#searchresults').html(data);
				    }
				});
			});

			ga('set', 'page', '/#directory');
			ga('send', 'pageview');

		});

</script>

<?php
	}
?>