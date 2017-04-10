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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once('permissions.php');

	//Show the Search and Last 10 Modified Users
	if($pageaccess==1)
	{

		$dropdownArray = array();
		$sql = "SELECT * FROM directory_settings";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc()){
			$key = $row['dropdownID'];
			$dropdownArray[$key] = $row['options'];
		}

		echo "<div class='page_container mdl-shadow--4dp'>";
			echo "<div class='page'>";

				include "csv.php";

				echo "<div class ='col s12'>";
				echo "<form id='directory-settings-form' method='post' enctype='multipart/form-data' action='modules/directory/updatesettings.php'>";
					echo "<table id='settingsTable' class='tablesorter'>";
						echo "<thead>";
							echo "<tr class='pointer'>";
								echo "<th = 'header'><h5>Settings</h5></th>";
							echo "</tr>";
						echo "</thead>";
					echo "</table>";
					echo "<div class='row'>";
						echo "<div class='input-field col l6 s12'>";
							echo "Job Titles";
							if(!$dropdownArray['jobTitles'] == "" && isset($dropdownArray['jobTitles'])){
								echo "<textarea placeholder='Enter Job Titles Separated by New Line' id='jobTitles' name='jobTitles'>".$dropdownArray['jobTitles']."</textarea>";
							}else{
								echo "<textarea placeholder='Enter Job Titles Separated by New Line' id='jobTitles' name='jobTitles'></textarea>";
							}
						echo "</div>";
						echo "<div class='input-field col l6 s12'>";
							echo "Contract Options";
							if(!$dropdownArray['contractOptions'] == "" && isset($dropdownArray['contractOptions'])){
								echo "<textarea placeholder='Enter Contract Options Separated by New Line' id='contractOptions' name='contractOptions'>".$dropdownArray['contractOptions']."</textarea>";
							}
							else{
								echo "<textarea placeholder='Enter Contract Options Separated by New Line' id='contractOptions' name='contractOptions'></textarea>";
							}
						echo "</div>";
					echo "</div>";
					echo "<div class='row'>";
						echo "<div class='input-field col l6 s12'>";
							echo "Classification Types";
							if(!$dropdownArray['classificationTypes'] == "" && isset($dropdownArray['classificationTypes'])){
								echo "<textarea placeholder='Enter Classificaton Types Separated by New Line' id='classificationTypes' name='classificationTypes'>".$dropdownArray['classificationTypes']."</textarea>";
							}else{
								echo "<textarea placeholder='Enter Classificaton Types Separated by New Line' id='classificationTypes' name='classificationTypes'></textarea>";
							}
						echo "</div>";
						echo "<div class='input-field col l6 s12'>";
							echo "Home Buildings";
							if(!$dropdownArray['homeBuildings'] == "" && isset($dropdownArray['homeBuildings'])){
								echo "<textarea placeholder='Enter Buildings Separated by New Line' id='homeBuildings' name='homeBuildings'>".$dropdownArray['homeBuildings']."</textarea>";
							}else{
								echo "<textarea placeholder='Enter Buildings Separated by New Line' id='homeBuildings' name='homeBuildings'></textarea>";
							}
						echo "</div>";
			  	echo "</div>";
					echo "<div class='row'>";
						echo "<div class='input-field col l6 s12'>";
							echo "Subjects";
							if(!$dropdownArray['subjects'] == "" && isset($dropdownArray['subjects'])){
								echo "<textarea placeholder='Enter Subjects Separated by New Line' id='subjects' name='subjects'>".$dropdownArray['subjects']."</textarea>";
							}else{
								echo "<textarea placeholder='Enter Subjects Separated by New Line' id='subjects' name='subjects'></textarea>";
							}
						echo "</div>";
						echo "<div class='input-field col l6 s12'>";
							echo "Level of Education";
							if(!$dropdownArray['educationLevel'] == "" && isset($dropdownArray['educationLevel'])){
								echo "<textarea placeholder='Enter Levels of Education Separated by New Line' id='educationLevel' name='educationLevel' type='text'>".$dropdownArray['educationLevel']."</textarea>";
							}else{
								echo "<textarea placeholder='Enter Levels of Education Separated by New Line' id='educationLevel' name='educationLevel' type='text'></textarea>";
							}
						echo "</div>";
					echo "</div>";
					echo "<button type='submit' class='modal-action waves-effect btn-flat white-text' id='saveSettings' style='background-color: ".sitesettings("sitecolor")."'>Save Changes</button>";
				echo "</form>";
			echo "</div>";
			echo "</div>";
		echo "</div>";

		?>

			<script>

				$(function() {

					var form = $('#directory-settings-form');
					$(form).submit(function(event) {
					    event.preventDefault();
						var formData = new FormData($(this)[0]);
						console.log(formData);
						$.ajax({
						    type: 'POST',
						    url: $(form).attr('action'),
						    data: formData,
						    contentType: false,
							processData: false
						})

						//Show the notification
						.done(function(response) {
								location.reload();
						})

					});


				});
			</script>
	<?php
	}
?>
