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
  require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
  require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');

	if(superadmin()){

		$dropdownArray = array();
		$sql = "SELECT districtID, pdf_options FROM conduct_settings";
		$result = $db->query($sql);
    $row = $result->fetch_assoc();
    $districtID = $row["districtID"];
    $pdfOptions = $row["pdf_options"];


		echo "<div id='settingsHolder'>";
		echo "<div class='page_container mdl-shadow--4dp'>";
			echo "<div class='page'>";

				echo "<div class ='col s12'>";
				echo "<form id='conduct-settings-form' method='post' enctype='multipart/form-data' action='modules/Abre-Conduct/update_settings.php'>";
					echo "<div class='row'><div class='col s12'>";
						echo "<h5>Conduct Settings</h5>";
					echo "</div></div>";
          echo "<div class='row'>";
						echo "<div class='input-field col l6 s12'>";
              echo "<input type='text' placeholder='Enter District ID' id='districtID' name='districtID' value ='$districtID'>";
							echo "<label for='districtID' class='active'>District ID</label>";
						echo "</div>";
					echo "</div>";
					echo "<div class='row'>";
						echo "<div class='input-field col l6 s12'>";
              echo "<textarea class='materialize-textarea' placeholder='Enter PDF Options Separated by New Line' id='pdfSettings' name='pdfSettings'>".$pdfOptions."</textarea>";
							echo "<label for='pdfSettings' class='active'>PDF Options</label>";
						echo "</div>";
          echo "</div>";
					echo "<div class='row'>";
						echo "<div class='col s12'>";
							echo "<button type='submit' class='modal-action waves-effect btn-flat white-text' id='saveConductSettings' style='background-color: ".getSiteColor()."'>Save Changes</button>";
						echo "</div>";
					echo "</div>";
				echo "</form>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
		echo "</div>";

  }

?>

<script>

		$(function() {

			var form = $('#conduct-settings-form');
			$(form).submit(function(event) {
				event.preventDefault();
				var formData = new FormData($(this)[0]);
				$.ajax({
				    type: 'POST',
				    url: $(form).attr('action'),
				    data: formData,
				    contentType: false,
					processData: false
				})
				//Show the notification
				.done(function(response) {
					$( "#settingsHolder" ).load( "modules/Abre-Conduct/settings.php", function() {
						var notification = document.querySelector('.mdl-js-snackbar');
						var data = { message: response };
						notification.MaterialSnackbar.showSnackbar(data);
					});
				})
			});

		});
</script>