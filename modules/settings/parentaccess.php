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
	require(dirname(__FILE__) . '/../../core/abre_version.php');

	//Settings
	$sql = "SELECT *  FROM users WHERE email = '".$_SESSION['useremail']."' and superadmin = 1";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc()){
		echo "<form id='form-settings' method='post' enctype='multipart/form-data' action='modules/settings/updateparentaccesssettings.php'>";
			echo "<div class='page_container page_container_limit mdl-shadow--4dp'>";
				echo "<div class='page'>";

					//Parent Access
					echo "<div class='row'>";
						echo "<div class='col s12'>";
							echo "<div class='input-field col s12'><h5>Parent Access</h5><br></div>";
						echo "</div>";

						echo "<div class='input-field col l12'>";
							echo "<input type='checkbox' class='formclick filled-in' id = 'parentaccess' name='parentaccess' value='checked' ".getSiteParentAccess()."/>";
							echo "<label for='parentaccess' style = 'color:#000;'> Allow Parent Access </label>";
						echo "</div>";

						echo "<div id=apiKeys class='col l12 m12'>";
							echo "<div class='col s12'> <h6>Google</h6></div>";
							echo "<div class='input-field col s6'>";
								echo "<input placeholder='Enter Client ID' value='".getSiteGoogleClientId()."' id='googleclientid' name='googleclientid' type='text' autocomplete='off'>";
								echo "<label class='active' for='googleclientid'>Google Client ID</label>";
							echo "</div>";
							echo "<div class='input-field col s6'>";
								echo "<input placeholder='Enter Client Secret' value='".getSiteGoogleClientSecret()."' id='googleclientsecret' name='googleclientsecret' type='text' autocomplete='off'>";
								echo "<label class='active' for='googleclientsecret'>Google Client Secret</label>";
							echo "</div>";
							echo "<div class='col s12'> <h6>Facebook</h6></div>";
							echo "<div class='input-field col s6'>";
								echo "<input placeholder='Enter Client ID' value='".getSiteFacebookClientId()."' id='facebookclientid' name='facebookclientid' type='text' autocomplete='off'>";
								echo "<label class='active' for='facebookclientid'>Facebook Client ID</label>";
							echo "</div>";
							echo "<div class='input-field col s6'>";
								echo "<input placeholder='Enter Client Secret' value='".getSiteFacebookClientSecret()."' id='facebookclientsecret' name='facebookclientsecret' type='text' autocomplete='off'>";
								echo "<label class='active' for='facebookclientsecret'>Facebook Client Secret</label>";
							echo "</div>";
							echo "<div class='col s12'> <h6>Microsoft</h6></div>";
							echo "<div class='input-field col s6'>";
								echo "<input placeholder='Enter Client ID' value='".getSiteMicrosoftClientId()."' id='microsoftclientid' name='microsoftclientid' type='text' autocomplete='off'>";
								echo "<label class='active' for='microsoftclientid'>Microsoft Client ID</label>";
							echo "</div>";
							echo "<div class='input-field col s6'>";
								echo "<input placeholder='Enter Client Secret' value='".getSiteMicrosoftClientSecret()."' id='microsoftclientsecret' name='microsoftclientsecret' type='text' autocomplete='off'>";
								echo "<label class='active' for='microsoftclientsecret'>Microsoft Client Secret</label>";
							echo "</div>";
							if($db->query("SELECT * FROM Abre_Students") && $db->query("SELECT * FROM users_parent") && superadmin()){
								echo "<div class='input-field col s12'>";
									echo "<a id='generateallkeys' class='modal-action waves-effect btn-flat white-text' style='background-color: ".getSiteColor()."'>Generate Keys for All Students</a>";
								echo "</div>";
								echo "<div class='input-field col s12'>";
									echo "<a id='exportkeys' href='$portal_root/modules/settings/exportkeysfile.php'class='modal-action waves-effect btn-flat white-text' style='background-color: ".getSiteColor()."'>Download All Keys</a>";
								echo "</div>";
							}
						echo "</div>";
					
			echo "</div>";


					//Save Button
					echo "<div class='row'>";
						echo "<div class='col s12'><div class='col s12'>";

							//Save changes button
							echo "<button type='submit' class='modal-action waves-effect btn-flat white-text' style='background-color: ".getSiteColor()."'>Save Changes</button>";

						echo "</div></div>";
					echo "</div>";

				echo "</div>";
			echo "</div>";
		echo "</form>";
	}

?>

<script>

	$(function(){

		//Save Settings
		var form = $('#form-settings');
		$(form).submit(function(event){
			event.preventDefault();
			var data = new FormData($(this)[0]);
			var url = $(form).attr('action');
			$.ajax({ type: 'POST', url: url, data: data, contentType: false, processData: false })
			//Show the notification
			.done(function(response){
				var notification = document.querySelector('.mdl-js-snackbar');
				var data = { message: response };
				notification.MaterialSnackbar.showSnackbar(data);
			})
		});
		
		//Generate Keys for Parents
		$("#generateallkeys").unbind().click(function(event){
			event.preventDefault();
			var result = confirm('Are you sure you want to proceed? This will create new keys for every student and invalidate current active keys!');
			if(result){
				$("#generateallkeys").html("Generating Keys...");
				$.ajax({ type: 'POST', url: '/modules/settings/generate_all_keys.php'})
				.done(function(){
					location.reload();
				})
			}
		});

	});

</script>