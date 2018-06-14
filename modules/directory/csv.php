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
	require_once('permissions.php');

	if($pageaccess == 1){

		$color = getSiteColor();
		echo "<div class='row'><div class='col s12'>";
			echo "<div class='row'>";
				echo "<div class='col s6'>";
					echo "<h5>Downloads</h5>";
					echo "<a href='$portal_root/modules/directory/csvexportfile.php' style='color:$color'>Staff - All Active Staff</a><br>";
					echo "<a href='$portal_root/modules/directory/csvexportfile_licenseexpiring.php' style='color:$color'>Staff - License Expiring</a><br>";
					echo "<a href='$portal_root/modules/directory/csvexportfile_workcalendars.php' style='color:$color'>Staff - Work Calendars</a>";
				echo "</div>";
				echo "<div class='col s6'>";
				if(admin()){
					echo "<h5>Imports</h5>";
					echo "<form action='modules/directory/csvimportfile.php' method='post' enctype='multipart/form-data' name='form-upload' id='form-upload'>";
	        echo "<input name='csv_data' type='file' id='csv_data' />";
	        echo "<br><br><input type='submit' class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored' style='background-color:$color' name='Submit' value='Import' />";
				  echo "<br><br><a href='$portal_root/modules/directory/directoryTemplate.csv' style='color:$color'>Download template file</a>";
	        echo "</form>";
	      }
			 echo "</div>";
		 echo "</div>";
		echo "</div>";
?>

<script>

		//Process the Form
		$(function() {

			var form = $('#form-upload');
			$(form).submit(function(event) {

				event.preventDefault();
				var notification = document.querySelector('.mdl-js-snackbar');
				var data = { message: 'Uploading...' };
				notification.MaterialSnackbar.showSnackbar(data);

		    var file_data = $('#csv_data').prop('files')[0];
		    var form_data = new FormData();
		    form_data.append('file', file_data)
		    $.ajax({
					url: $(form).attr('action'),
					dataType: 'text',
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'post'
		    })
				.done(function(form_data) {
					var notification = document.querySelector('.mdl-js-snackbar');
					var data = { message: form_data };
					notification.MaterialSnackbar.showSnackbar(data);
				})
			});

		});

</script>

<?php
	}
?>