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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require(dirname(__FILE__) . '/../../core/abre_version.php');

	//Settings
	if(superadmin()){

			echo "<div class='page_container page_container_limit mdl-shadow--4dp'>";
				echo "<div class='page'>";

					//Page Title
					echo "<div class='row'>";
						echo "<div class='input-field col s12'>";
							echo "<h4>Authentication</h4>";
							echo "<h6>Control single sign-on (SSO) services for staff, students, and parents.</h6>";
						echo "</div>";
					echo "</div>";

					//Parent Access

						// echo "<div class='col l12'>";
						// 	echo "<input type='checkbox' class='formclick filled-in' id = 'parentaccess' name='parentaccess' value='checked' ".getSiteParentAccess()."/>";
						// 	echo "<label for='parentaccess' style = 'color:#000;'> Allow Parent Access </label>";
						// echo "</div>";

						echo "<div class='row' id='googleAuthService'>";
							echo "<div class='input-field col s1 center-align'>";
									echo "<img src='../../core/images/button_icon_google.png'>";
							echo "</div>";
							echo "<div class='input-field col s9'>";
									echo "<h5 style='padding-top:0px; margin:0px;'>Google Apps Authentication</h5><p>Let your district sign in with a Google account.</p>";
							echo "</div>";
							echo "<div class='input-field col s2'>";
									echo "<a id='exportkeys' href='#googleAuthModal' class='modal-action waves-effect btn-flat white-text googleAuthModal' style='background-color: ".getSiteColor()."'>Configure</a>";
							echo "</div>";
						echo "</div>";

						echo "<div class='row' id='microsoftAuthService'>";
							echo "<div class='input-field col s1 center-align'>";
									echo "<img src='../../core/images/button_icon_microsoft.png'>";
							echo "</div>";
							echo "<div class='input-field col s9'>";
									echo "<h5 style='padding-top:0px; margin:0px;'>Microsoft Authentication</h5><p>Let your district sign in with a Microsoft account.</p>";
							echo "</div>";
							echo "<div class='input-field col s2'>";
									echo "<a id='exportkeys' href='#microsoftAuthModal' class='modal-action waves-effect btn-flat white-text microsoftAuthModal' style='background-color: ".getSiteColor()."'>Configure</a>";
							echo "</div>";
						echo "</div>";

						echo "<div class='row' id='facebookAuthService'>";
							echo "<div class='input-field col s1 center-align'>";
									echo "<img style='background-color:#3664a2 !important;' src='../../core/images/button_icon_facebook.png'>";
							echo "</div>";
							echo "<div class='input-field col s9'>";
									echo "<h5 style='padding-top:0px; margin:0px;'>Facebook Authentication</h5><p>Let your parents sign in with a Facebook account.</p>";
							echo "</div>";
							echo "<div class='input-field col s2'>";
									echo "<a id='exportkeys' href='#facebookAuthModal' class='modal-action waves-effect btn-flat white-text facebookAuthModal' style='background-color: ".getSiteColor()."'>Configure</a>";
							echo "</div>";
						echo "</div>";

						// echo "<div id='apiKeys'>";
						// 	echo "<div class='col s12'><h6>Google</h6></div>";
						// 	echo "<div class='input-field col s6'>";
						// 		echo "<input placeholder='Enter Client ID' value='".getSiteGoogleClientId()."' id='googleclientid' name='googleclientid' type='text' autocomplete='off'>";
						// 		echo "<label class='active' for='googleclientid'>Google Client ID</label>";
						// 	echo "</div>";
						// 	echo "<div class='input-field col s6'>";
						// 		echo "<input placeholder='Enter Client Secret' value='".getSiteGoogleClientSecret()."' id='googleclientsecret' name='googleclientsecret' type='text' autocomplete='off'>";
						// 		echo "<label class='active' for='googleclientsecret'>Google Client Secret</label>";
						// 	echo "</div>";
						// 	echo "<div class='col s12'> <h6>Facebook</h6></div>";
						// 	echo "<div class='input-field col s6'>";
						// 		echo "<input placeholder='Enter Client ID' value='".getSiteFacebookClientId()."' id='facebookclientid' name='facebookclientid' type='text' autocomplete='off'>";
						// 		echo "<label class='active' for='facebookclientid'>Facebook Client ID</label>";
						// 	echo "</div>";
						// 	echo "<div class='input-field col s6'>";
						// 		echo "<input placeholder='Enter Client Secret' value='".getSiteFacebookClientSecret()."' id='facebookclientsecret' name='facebookclientsecret' type='text' autocomplete='off'>";
						// 		echo "<label class='active' for='facebookclientsecret'>Facebook Client Secret</label>";
						// 	echo "</div>";
						// 	echo "<div class='col s12'> <h6>Microsoft</h6></div>";
						// 	echo "<div class='input-field col s6'>";
						// 		echo "<input placeholder='Enter Client ID' value='".getSiteMicrosoftClientId()."' id='microsoftclientid' name='microsoftclientid' type='text' autocomplete='off'>";
						// 		echo "<label class='active' for='microsoftclientid'>Microsoft Client ID</label>";
						// 	echo "</div>";
						// 	echo "<div class='input-field col s6'>";
						// 		echo "<input placeholder='Enter Client Secret' value='".getSiteMicrosoftClientSecret()."' id='microsoftclientsecret' name='microsoftclientsecret' type='text' autocomplete='off'>";
						// 		echo "<label class='active' for='microsoftclientsecret'>Microsoft Client Secret</label>";
						// 	echo "</div>";
							// if($db->query("SELECT * FROM Abre_Students LIMIT 1") && $db->query("SELECT * FROM users_parent LIMIT 1") && superadmin()){
							// 	echo "<div class='input-field col s12'>";
							// 		echo "<a id='generateallkeys' class='modal-action waves-effect btn-flat white-text' style='background-color: ".getSiteColor()."'>Generate Keys for All Students</a>";
							// 	echo "</div>";
							// 	echo "<div class='input-field col s12'>";
							// 		echo "<a id='exportkeys' href='$portal_root/modules/settings/exportkeysfile.php'class='modal-action waves-effect btn-flat white-text' style='background-color: ".getSiteColor()."'>Download All Keys</a>";
							// 	echo "</div>";
							// }
						// echo "</div>";


					//Save Button
					// echo "<div class='row'>";
					// 	echo "<div class='col s12'>";
					// 		echo "<button type='submit' class='modal-action waves-effect btn-flat white-text' style='background-color: ".getSiteColor()."'>Save Changes</button>";
					// 	echo "</div>";
					// echo "</div>";

				echo "</div>";
			echo "</div>";
	}

?>

<script>

	$(function(){

		//Open Google Oauth Modal
		$(".googleAuthModal").unbind().click(function(event) {
			event.preventDefault();

			$('#googleAuthModal').openModal({
				in_duration: 0,
				out_duration: 0,
				ready: function() {}
			});
		});

		//Open Microsoft Oauth Modal
		$(".microsoftAuthModal").unbind().click(function(event) {
			event.preventDefault();

			$('#microsoftAuthModal').openModal({
				in_duration: 0,
				out_duration: 0,
				ready: function() {}
			});
		});

		//Open Facebook Oauth Modal
		$(".facebookAuthModal").unbind().click(function(event) {
			event.preventDefault();

			$('#facebookAuthModal').openModal({
				in_duration: 0,
				out_duration: 0,
				ready: function() {}
			});
		});

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