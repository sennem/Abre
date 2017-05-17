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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require(dirname(__FILE__) . '/../../core/abre_version.php');

	//Settings
	$sql = "SELECT *  FROM users where email='".$_SESSION['useremail']."' and superadmin=1";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{
		echo "<form id='form-settings' method='post' enctype='multipart/form-data' action='modules/settings/updatesettings.php'>";
			echo "<div class='page_container page_container_limit mdl-shadow--4dp'>";
				echo "<div class='page'>";

					//Settings
					echo "<div class='row'>";
						echo "<div class='col l6 m12'>";
							echo "<div class='input-field col s12'><h5>Site Settings</h5><br></div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter a Site Title' value='".sitesettings("sitetitle")."' id='sitetitle' name='sitetitle' type='text' autocomplete='off'>";
								echo "<label class='active' for='sitetitle'>Site Title</label>";
						    echo "</div>";
						    echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter a Site Description' value='".sitesettings('sitedescription')."' id='sitedescription' name='sitedescription' type='text' autocomplete='off'>";
								echo "<label class='active' for='sitedescription'>Site Description</label>";
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter the Site Login Text' value='".sitesettings('sitelogintext')."' id='sitelogintext' name='sitelogintext' type='text' autocomplete='off'>";
								echo "<label class='active' for='sitedescription'>Site Login Text</label>";
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter a Site Color' value='".sitesettings('sitecolor')."' id='sitecolor' name='sitecolor' type='text' autocomplete='off'>";
								echo "<label class='active' for='sitecolor'>Site Color</label>";
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter the Google Analytics ID' value='".sitesettings('siteanalytics')."' id='siteanalytics' name='siteanalytics' type='text' autocomplete='off'>";
								echo "<label class='active' for='siteanalytics'>Google Analytics ID</label>";
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter the Site Administrator Email' value='".sitesettings('siteadminemail')."' id='siteadminemail' name='siteadminemail' type='text' autocomplete='off'>";
								echo "<label class='active' for='siteadminemail'>Site Administrator Email</label>";
						    echo "</div>";
							echo "<div class='input-field col s6'>";
						    	echo "<input placeholder='Enter Student Domain' value='".sitesettings('studentdomain')."' id='studentdomain' name='studentdomain' type='text' autocomplete='off'>";
								echo "<label class='active' for='studentdomain'>Student Domain</label>";
						    echo "</div>";
						    echo "<div class='input-field col s6'>";
						    	echo "<input placeholder='Enter Required Characters' value='".sitesettings('studentdomainrequired')."' id='studentdomainrequired' name='studentdomainrequired' type='text' autocomplete='off'>";
								echo "<label class='active' for='studentdomainrequired'>Student Domain Required Characters</label>";
						    echo "</div>";
						echo "</div>";

						echo "<div class='col l6 s12 center-align'>";
							$sitelogoexisting=sitesettings('sitelogo');
							if($sitelogoexisting!="")
							{
								echo "<div class='input-field col s12'><h5>Site Logo</h5><br></div>";
								echo "<img class='sitelogobutton pointer' src='$sitelogoexisting' width='125px' height='125px' style='margin-bottom:33px;'>";
							    echo "<input type='hidden' name='sitelogoexisting' value='$sitelogoexisting'>";
							    echo "<input type='file' name='sitelogo' id='sitelogo' style='display:none;'>";
							}
						echo "</div>";

						echo "<div class='input-field col l12'>";
							echo "<input type='checkbox' class='formclick filled-in' id = 'parentaccess' name='parentaccess' value='checked' ".sitesettings('parentaccess')."/>";
							echo "<label for='parentaccess' style = 'color:#000;'> Allow Parent Access </label>";
						echo "</div>";

						echo "<div id=apiKeys class='col l12 m12'>";
							echo "<div class='col s12'> <h6>Google</h6></div>";
							echo "<div class='input-field col s6'>";
								echo "<input placeholder='Enter Client ID' value='".sitesettings('googleclientid')."' id='googleclientid' name='googleclientid' type='text' autocomplete='off'>";
								echo "<label class='active' for='googleclientid'>Google Client ID</label>";
							echo "</div>";
							echo "<div class='input-field col s6'>";
								echo "<input placeholder='Enter Client Secret' value='".sitesettings('googleclientsecret')."' id='googleclientsecret' name='googleclientsecret' type='text' autocomplete='off'>";
								echo "<label class='active' for='googleclientsecret'>Google Client Secret</label>";
							echo "</div>";
							echo "<div class='col s12'> <h6>Facebook</h6></div>";
							echo "<div class='input-field col s6'>";
								echo "<input placeholder='Enter Client ID' value='".sitesettings('facebookclientid')."' id='facebookclientid' name='facebookclientid' type='text' autocomplete='off'>";
								echo "<label class='active' for='facebookclientid'>Facebook Client ID</label>";
							echo "</div>";
							echo "<div class='input-field col s6'>";
								echo "<input placeholder='Enter Client Secret' value='".sitesettings('facebookclientsecret')."' id='facebookclientsecret' name='facebookclientsecret' type='text' autocomplete='off'>";
								echo "<label class='active' for='facebookclientsecret'>Facebook Client Secret</label>";
							echo "</div>";
							echo "<div class='col s12'> <h6>Microsoft</h6></div>";
							echo "<div class='input-field col s6'>";
								echo "<input placeholder='Enter Client ID' value='".sitesettings('microsoftclientid')."' id='microsoftclientid' name='microsoftclientid' type='text' autocomplete='off'>";
								echo "<label class='active' for='microsoftclientid'>Microsoft Client ID</label>";
							echo "</div>";
							echo "<div class='input-field col s6'>";
								echo "<input placeholder='Enter Client Secret' value='".sitesettings('microsoftclientsecret')."' id='microsoftclientsecret' name='microsoftclientsecret' type='text' autocomplete='off'>";
								echo "<label class='active' for='microsoftclientsecret'>Microsoft Client Secret</label>";
							echo "</div>";
							echo "<div class='input-field col s12'>";
								if($db->query("SELECT * FROM Abre_Students") && $db->query("SELECT * FROM users_parent")){
										echo "<button id='generateallkeys' class='modal-action waves-effect btn-flat white-text' style='background-color: ".sitesettings("sitecolor")."'>Generate Keys for All Students</button>";
								}else{
								}
							echo "</div>";
						echo "</div>";

						echo "<div class='col l12'>";
						    //Software Answers
						    echo "<div class='input-field col s12'><h5>Software Answers</h5><br></div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter VendorLink Host URL' value='".sitesettings('sitevendorlinkurl')."' id='sitevendorlinkurl' name='sitevendorlinkurl' type='text' autocomplete='off'>";
								echo "<label class='active' for='sitevendorlinkurl'>Software Answers VendorLink URL</label>";
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter VendorLink Identifier' value='".sitesettings('sitevendorlinkidentifier')."' id='sitevendorlinkidentifier' name='sitevendorlinkidentifier' type='text' autocomplete='off'>";
								echo "<label class='active' for='sitevendorlinkidentifier'>Software Answers VendorLink Identifier</label>";
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter VendorLink Key' value='".sitesettings('sitevendorlinkkey')."' id='sitevendorlinkkey' name='sitevendorlinkkey' type='text' autocomplete='off'>";
								echo "<label class='active' for='sitevendorlinkkey'>Software Answers VendorLink Key</label>";
						    echo "</div>";

					echo "</div>";

					//Save Button
					echo "<div class='row'>";
						echo "<div class='col s12'><div class='col s12'>";

							//Save changes button
							echo "<button type='submit' class='modal-action waves-effect btn-flat white-text' style='background-color: ".sitesettings("sitecolor")."'>Save Changes</button>";

							//Update Abre if new version available
							$opts = ['http' => ['method' => 'GET','header' => ['User-Agent: PHP']]];
							$context = stream_context_create($opts);
							$content = file_get_contents("https://api.github.com/repos/abreio/Abre/releases/latest", false, $context);
							$json = json_decode($content, true);
							$currentversion = $json['name'];

							if($abre_version<$currentversion)
							{
								$currentlink = "https://github.com/abreio/Abre/archive/".$currentversion.".zip";
								echo " <button id='updateabre' data-version='$currentlink' class='modal-action waves-effect btn-flat white-text' style='background-color: ".sitesettings("sitecolor")."'>Update to $currentversion</button>";
							}

						echo "</div></div>";
					echo "</div>";

					//Show Current Version
					echo "<div class='row'>";
						echo "<div class='col s12'><div class='col s12'><p style='color:#999'>Version $abre_version</p></div></div>";
					echo "</div>";

				echo "</div>";
			echo "</div>";
		echo "</form>";
	}

?>

<script>

	$(function()
	{

		//Update Abre
		$("#updateabre").unbind().click(function(event) {
			event.preventDefault();
			var Link = $(this).data('version');
			$(this).html("Updating...");
			$.post("modules/settings/update.php", { link: Link }, function(){ })
			.done(function() {
				location.reload();
	  		})
	  	});

		//Provide image upload on icon click
		$(".sitelogobutton").click(function() {
			$("#sitelogo").click();
	  	});

		//Submit form if image if changed
		$("#sitelogo").change(function (){
	        if (this.files && this.files[0]){
	        	var reader = new FileReader();
	            reader.onload = function (e) {
	                $('.sitelogobutton').attr('src', e.target.result);
	            }
	            reader.readAsDataURL(this.files[0]);
	        }
	  	});

		//Save Settings
		var form = $('#form-settings');
		$(form).submit(function(event)
		{
			event.preventDefault();
			var data = new FormData($(this)[0]);
			console.log(data);
			var url = $(form).attr('action');
			$.ajax({ type: 'POST', url: url, data: data, contentType: false, processData: false })

			//Show the notification
			.done(function(response)
			{
				location.reload();
			})
		});


		if($("#parentaccess").prop("checked")){
			$("#apiKeys").show();
		}else{
			$("#apiKeys").hide();
		}

		$("#parentaccess").click(function() {
			if($("#parentaccess").prop("checked")){
				$("#apiKeys").show();
			}else{
				$("#apiKeys").hide();
			}
	  	});

		//Generate Keys for Parents
		$("#generateallkeys").unbind().click(function(event)
		{
			event.preventDefault();
			var result = confirm('Are you sure you want to proceed? This will create new keys for every student and invalidate current parent keys');
			if(result){
				$("#generateallkeys").html("Generating Keys...");
				$.ajax({ type: 'POST', url: '/modules/settings/generate_all_keys.php'})
				.done(function()
				{
					location.reload();
				})
			}
		});
	});

</script>
