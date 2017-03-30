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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');	
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');	
	
	//Check for installation
	if(superadmin()){ require('installer.php'); }	
	
	$pageview=1;
	$drawerhidden=1;
	$pagetitle="Apps";
	$pagepath="apps";
	
?>

	<!--Apps modal-->
	<div id='viewapps_arrow' class='hide-on-small-only'></div>
	<div id="viewapps" class="modal apps_modal modal-mobile-full">
		<div class="modal-content" id="modal-content-section">
			<a class="modal-close black-text hide-on-med-and-up" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<div id='loadapps'></div>
    	</div>
	</div>
	
	<!--Apps Editor-->
	<?php
	if(superadmin())
	{
	?>
	
	<link rel="stylesheet" href='core/css/image-picker.0.3.0.css'>
	<script src='core/js/image-picker.0.0.3.min.js'></script>
	
	<div id='appeditor' class='modal modal-fixed-footer modal-mobile-full'>
		<div class='modal-content'>
			<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<div class='row'>
				<div class='col s12'>
					<h4>App Editor</h4>
					<?php
						include "app_editor_content.php";	
					?>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<a class='modal-action waves-effect btn-flat white-text modal-addeditapp' href='#addeditapp' data-apptitle='Add New App' style='background-color: <?php echo sitesettings("sitecolor"); ?>'>Add</a>
		</div>
	</div>
	
	<div id='addeditapp' class='modal modal-fixed-footer modal-mobile-full' style="width: 90%">
		<form id='addeditappform' method="post" action='#'>
		<div class='modal-content'>
			<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<div class='row'>
				<div class='col s12'><h4 id='editmodaltitle'></h4></div>
				<div class='input-field col s12'>
					<input placeholder="Enter App Name" id="app_name" name="app_name" type="text" autocomplete="off" required>
					<label for="app_name">Name</label>
				</div>
				<div class='input-field col s12'>
					<input placeholder="Enter App Link" id="app_link" name="app_link" type="text" autocomplete="off" required>
					<label for="app_link">Link</label>
				</div>
			</div>
			<div class='row'>
				<div class='col m4 s12'>
					<input type="checkbox" id="app_staff" class="filled-in" value="1" />
					<label for="app_staff">Available for staff</label>
				</div>
				<div class='col m4 s12'>
					<input type="checkbox" id="app_students" class="filled-in" value="1" />
					<label for="app_students">Available for students</label>
				</div>
				<div class='col m4 s12'>
					<input type="checkbox" id="app_minors" class="filled-in" value="1" />
					<label for="app_minors">Disable for minors</label>
				</div>
			</div>
			<div class='row'>
				<div class='col s12'>
					<select id="app_icon" name="app_icon" class="image-picker browser-default" required>
					<?php
						$icons = scandir("$portal_path_root/core/images/");
						foreach($icons as $iconimage)
						{
							if (substr($iconimage, 0, 11) === 'icon_thumb_')
							{
								echo "<option data-img-src='/core/images/$iconimage' value='$iconimage'></option>";
							}
						}
					?>
					</select>
				</div>
				<input id="app_id" name="app_id" type="hidden">
			</div>
		</div>
		<div class='modal-footer'>
			<button type="submit" class='modal-action waves-effect btn-flat white-text' id='saveupdateapp' style='background-color: <?php echo sitesettings("sitecolor"); ?>'>Save</button>
			<a class='modal-action modal-close waves-effect btn-flat white-text' style='background-color: <?php echo sitesettings("sitecolor"); ?>; margin-right:5px;'>Cancel</a>
		</div>
		</form>
	</div>
	
	<?php
	}
	?>

	<script>
		
		$(function()
		{
			
			//Call ImagePicker
			$("select").imagepicker();
			
			//Load Apps into Modal
			$('#loadapps').load('modules/apps/apps.php');
		
			//Apps Modal
	    	$('.modal-viewapps').leanModal({
				in_duration: 0,
				out_duration: 0,
				opacity: 0,
		    	ready: function() { 
			    	$("#viewapps_arrow").show(); 
			    	$("#viewapps").scrollTop(0);
			    	$('#viewprofile').closeModal({
				    	in_duration: 0,
						out_duration: 0,
				   	});
			    	$("#viewprofile_arrow").hide();
			    },
		    	complete: function() { $("#viewapps_arrow").hide(); }
		   	});
		   	
		   	<?php
			if(superadmin())
			{
			?>
		   	
				//Add/Edit App
				$('.modal-addeditapp').leanModal({
					in_duration: 0,
					out_duration: 0,
					ready: function()
					{  
						$("#editmodaltitle").text('Add New App');
						$("#app_name").val('');
						$("#app_link").val('');
						$("#app_id").val('');
						$('#app_staff').prop('checked', false);
						$('#app_students').prop('checked', false);
						$('#app_minors').prop('checked', false);
						$('[name=app_icon]').val('');
						$("select").imagepicker();
					}
				}); 
				
				//Save/Update App
				$('#addeditappform').submit(function(event)
				{
					event.preventDefault();
					
					var appname = $('#app_name').val();
					var applink = $('#app_link').val();
					var appicon = $('#app_icon').val();
					if($('#app_staff').is(':checked')==true){ var appstaff = 1; }else{ var appstaff = 0; }
					if($('#app_students').is(':checked')==true){ var appstudents = 1; }else{ var appstudents = 0; }
					if($('#app_minors').is(':checked')==true){ var appminors = 1; }else{ var appminors = 0; }
					
					var appid = $('#app_id').val();
					$("select").imagepicker();
					
					//Make the post request
					$.ajax({
						type: 'POST',
						url: 'modules/apps/update_app.php',
						data: { name: appname, link: applink, icon: appicon, id: appid, staff: appstaff, students: appstudents, minors: appminors }
					})
						
					.done(function(){
						$('#addeditapp').closeModal({ in_duration: 0, out_duration: 0 });
						$('#appsort').load('modules/apps/app_editor_content.php');
						$('#loadapps').load('modules/apps/apps.php');
					});
					
				});
				
			<?php				   	
			}
			?>
	  	
		});
	
	</script>