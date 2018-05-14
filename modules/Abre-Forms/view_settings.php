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
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');

	//Get Variables Passed to Page
	if(isset($_GET["id"])){ $id=htmlspecialchars($_GET["id"], ENT_QUOTES); }else{ $id=""; }
	$useremail = $_SESSION['useremail'];


	if(($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator()) && isOwner($id))
	{

		$restrictions = getFormsSettingsLimitUsers($id);

		echo "<form id='form-settings' method='post' enctype='multipart/form-data' action='modules/Abre-Forms/action_savesettings.php'>";
		echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp'>";
		echo "<div class='page'>";

			//Permissions
			echo "<div class='row'><div class='col s12'><h4>Permissions</h4></div></div>";
			echo "<div class='row'>";
				echo "<div class='col s12'>";
					echo "<input type='checkbox' class='filled-in' id='limit' name='limit' value='checked' ".getFormsSettingsLimit($id)."/>";
					echo "<label for='limit' style='color:#000;'> Limit number of form entries to 1 per user</label>";
				echo "</div>";
			echo "</div>";

			echo "<div class='row'>";
				echo "<div class='col m6 s12'>";
					echo "<label>Limit form submissions to</label>";
					echo "<select id='restrictions' name='restrictions[]' multiple>";
						if($restrictions == ''){
							echo "<option value='' disabled selected>Choose a role</option>";
						}else{
							echo "<option disabled value=''>Choose a role</option>";
						}
						if(strpos($restrictions, 'staff') !== false){
							echo "<option value='staff' selected>Staff</option>";
						}else{
							echo "<option value='staff'>Staff</option>";
						}
						if(strpos($restrictions, 'student') !== false){
							echo "<option value='student' selected>Students</option>";
						}else{
							echo "<option value='student'>Students</option>";
						}
						if(strpos($restrictions, 'parent') !== false){
							echo "<option value='parent' selected>Parents</option>";
						}else{
							echo "<option value='parent'>Parents</option>";
						}
					echo "</select>";

				echo "</div>";
			echo "</div>";

			echo "<div class='row'>";
				echo "<div class='input-field col s6'>";
					echo "<input type='text' id='editors' name='editors' value='".getFormEditors($id)."' placeholder='Form Editors (Emails Separated by Commas)' autocomplete='off'>";
					echo "<label for='editors' class='active'>Form Editors</label>";
				echo "</div>";
			echo "</div>";

			echo "<div class='row'>";
				echo "<div class='input-field col s6'>";
					echo "<input type='text' id='responseAccess' name='responseAccess' value='".getFormResponseAccess($id)."' placeholder='Share Reponses With (Emails Separated by Commas)' autocomplete='off'>";
					echo "<label for='responseAccess' class='active'>Share Reponses With</label>";
				echo "</div>";
			echo "</div>";

			//Messages
			echo "<div class='row'><div class='col s12'><h4>Messages</h4></div></div>";
			echo "<div class='row'>";
				echo "<div class='input-field col m6 s12'>";
					echo "<input placeholder='Your response has been recorded.' value='".getFormsSettingsConfirmation($id)."' id='confirmation' name='confirmation' type='text' autocomplete='off'>";
					echo "<label class='active' for='confirmation'>Confirmation message</label>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col s12'>";
					echo "<input type='checkbox' class='filled-in' id='formEmailNotifications' name='formEmailNotifications' value='checked' ".getFormsSettingsNotifications($id)."/>";
					echo "<label for='formEmailNotifications' style='color:#000;'>Receive email notifications for new responses</label>";
				echo "</div>";
			echo "</div>";

			//Visibility
			if(admin() || isFormsAdministrator()){
				echo "<div class='row'><div class='col s12'><h4>Visibility</h4></div></div>";
				echo "<div class='row'>";
					echo "<div class='col s12'>";
						echo "<input type='checkbox' class='filled-in' id='public' name='public' value='checked' ".getFormsSettingsPublic($id)."/>";
						echo "<label for='public' style='color:#000;'> Make this a recommended form</label>";
					echo "</div>";
				echo "</div>";
				echo "<div class='row'>";
					echo "<div class='col s12'>";
						echo "<input type='checkbox' class='filled-in' id='template' name='template' value='checked' ".getFormsSettingsTemplate($id)."/>";
						echo "<label for='template' style='color:#000;'> Make this form a district template</label>";
					echo "</div>";
				echo "</div>";
				if(isAppActive("Abre-Plans")){
					echo "<div class='row'>";
						echo "<div class='col s12'>";
							echo "<input type='checkbox' class='filled-in' id='plan' name='plan' value='checked' ".getFormsSettingsPlan($id)."/>";
							echo "<label for='plan' style='color:#000;'> Make this form a plan</label>";
						echo "</div>";
					echo "</div>";
				}
			}


			//Hidden Fields
			echo "<input type='hidden' name='formid' value='$id'>";

			//Save Button
			echo "<div class='row'>";
				echo "<div class='col s12'>";
					echo "<button type='submit' class='modal-action waves-effect btn-flat white-text' style='background-color: ".getSiteColor($id)."'>Save</button>";
				echo "</div>";
			echo "</div>";


		echo "</div>";
		echo "</div>";
		echo "</form>";

	}
	else
	{

		echo "<div class='row' style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>You Do Not Have Access</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Only the owner can modify form settings.</p></div>";

	}

?>

<script>

	$(function()
	{

		$('select').material_select();

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

	});

</script>