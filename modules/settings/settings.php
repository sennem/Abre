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
	
	//Streams
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
							echo "<div class='input-field col s12'><h5>Site</h5><br></div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter a Site Title' value='".sitesettings("sitetitle")."' id='sitetitle' name='sitetitle' type='text'>";
								echo "<label class='active' for='sitetitle'>Site Title</label>";
						    echo "</div>";
						    echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter a Site Description' value='".sitesettings('sitedescription')."' id='sitedescription' name='sitedescription' type='text'>";
								echo "<label class='active' for='sitedescription'>Site Description</label>";
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter the Site Login Text' value='".sitesettings('sitelogintext')."' id='sitelogintext' name='sitelogintext' type='text'>";
								echo "<label class='active' for='sitedescription'>Site Login Text</label>";
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter the Google Analytics ID' value='".sitesettings('siteanalytics')."' id='siteanalytics' name='siteanalytics' type='text'>";
								echo "<label class='active' for='siteanalytics'>Google Analytics ID</label>";
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter the Site Administrator Email' value='".sitesettings('siteadminemail')."' id='siteadminemail' name='siteadminemail' type='text'>";
								echo "<label class='active' for='siteadminemail'>Site Administrator Email</label>";
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter VendorLink Host URL' value='".sitesettings('sitevendorlinkurl')."' id='sitevendorlinkurl' name='sitevendorlinkurl' type='text'>";
								echo "<label class='active' for='sitevendorlinkurl'>Site VendorLink URL</label>";
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter VendorLink Identifier' value='".sitesettings('sitevendorlinkidentifier')."' id='sitevendorlinkidentifier' name='sitevendorlinkidentifier' type='text'>";
								echo "<label class='active' for='sitevendorlinkidentifier'>Site VendorLink Identifier</label>";
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter VendorLink Key' value='".sitesettings('sitevendorlinkkey')."' id='sitevendorlinkkey' name='sitevendorlinkkey' type='text'>";
								echo "<label class='active' for='sitevendorlinkkey'>Site VendorLink Key</label>";
						    echo "</div>";
						echo "</div>";
						
						echo "<div class='col l6 m12'>";
							echo "<div class='input-field col s12'><h5>Style</h5></div>";
							echo "<div class='input-field col s12 center-align'>";
							    $sitelogoexisting=sitesettings('sitelogo');
							    if($sitelogoexisting!="")
							    {
									echo "<h6>Primary Logo</h6>";
									echo "<img class='sitelogobutton pointer' src='$sitelogoexisting' width='125px' height='125px' style='margin-bottom:33px;'>";
							    	echo "<input type='hidden' name='sitelogoexisting' value='$sitelogoexisting'>";
							    	echo "<input type='file' name='sitelogo' id='sitelogo' style='display:none;'>";
							    }
						    echo "</div>";
							echo "<div class='input-field col s12'>";
						    	echo "<input placeholder='Enter a Site Color' value='".sitesettings('sitecolor')."' id='sitecolor' name='sitecolor' type='text'>";
								echo "<label class='active' for='sitecolor'>Site Color</label>";
						    echo "</div>";
						echo "</div>";
						
					echo "</div>";
					
					//Save Button
					echo "<div class='row'>";
						echo "<div class='col s12'><div class='col s12'>";
							echo "<button type='submit' class='modal-action waves-effect btn-flat white-text' style='background-color: ".sitesettings("sitecolor")."'>Apply Changes</button>";
						echo "</div></div>";
					echo "</div>";
					
					echo "<div class='row'>";
						echo "<div class='col s12'><div class='col s12'>";
								
							//Retrieve latest version from public GitHub repo
							$opts = ['http' => ['method' => 'GET','header' => ['User-Agent: PHP']]];
							$context = stream_context_create($opts);
							$content = file_get_contents("https://api.github.com/repos/abreio/Abre/releases/latest", false, $context);
							$json = json_decode($content, true);
							$currentversion = $json['name'];
							$currentlink = $json['zipball_url'];
								
							if($abre_version<$currentversion)
							{
								echo "<a id='updateabre' href='#' data-version='$currentlink' style='color:#999'>You have version $abre_version installed. Update to $currentversion.</a>";
							}
							else
							{
								echo "<p style='color:#999'>Release: $abre_version</p>";
							}
							
						echo "</div></div>";
					echo "</div>";
					
				echo "</div>";
			echo "</div>";
		echo "</form>";
	}
	
?>

<script>
	
	//Update Abre
	$("#updateabre").click(function(event) {
		event.preventDefault();
		var Link = $(this).data('version');
		$(this).html("Updating...");
<<<<<<< HEAD
		$.post("modules/settings/update.php", { link: Link }, function(){ })
=======
		$.post("modules/settings/update.php", { link: Link },function(){ })
>>>>>>> origin/master
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
		var url = $(form).attr('action');
		$.ajax({ type: 'POST', url: url, data: data, contentType: false, processData: false })
					
		//Show the notification
		.done(function(response)
		{
			location.reload();
		})		
	});
	
</script>