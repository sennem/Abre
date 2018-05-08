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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_google_authentication.php');
?>

	<!-- Create Course -->
	<div id="curriculumcourse" class="modal modal-fixed-footer modal-mobile-full">
		<form class="col s12" id="form-addcourse" method="post" action="modules/<?php echo basename(__DIR__); ?>/course_process.php">
		<div class="modal-content" style="padding: 0px !important;">
			<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
				<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Course</span></div>
				<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
			</div>
			<div style='padding: 0px 24px 0px 24px;'>
					<div class="row">
						<div class="input-field col s12">
							<input id="course_title" name="course_title" placeholder="Title of the Course" type="text" required>
							<label class="active" id="course_title">Course Title</label>
						</div>
					</div>
					<div class="row">
						<div class="col s6">
							<label class="active">Grade Level</label>
							<select name='course_grade[]' id='course_grade' class="browser-default" style='height: 100px;' required='required' multiple>
								<option value='Pre-K'>Pre-K</option>
								<option value='K'>K</option>
							  <option value='1'>1</option>
							  <option value='2'>2</option>
							  <option value='3'>3</option>
							  <option value='4'>4</option>
								<option value='5'>5</option>
							  <option value='6'>6</option>
							  <option value='7'>7</option>
							  <option value='8'>8</option>
							  <option value='9'>9</option>
							  <option value='10'>10</option>
							  <option value='11'>11</option>
							  <option value='12'>12</option>
						  </select>
						</div>
						<div class="col s6">
							<label class="active">Subject</label>
							<select name='course_subject' id='course_subject' class="browser-default" required>
								<option value=''></option>
								<option value='Arts'>Arts</option>
								<option value='English Language Arts'>English Language Arts</option>
								<option value='Health & Physical Education'>Health & Physical Education</option>
								<option value='Mathematics'>Mathematics</option>
								<option value='Professional Development'>Professional Development</option>
							  <option value='Science'>Science</option>
							  <option value='Social Studies'>Social Studies</option>
								<option value='Special Education'>Special Education</option>
							  <option value='Technology'>Technology</option>
							  <option value='Miscellaneous'>Miscellaneous</option>
						  </select>
						</div>
					</div>

					<div class="row">
						<div class="input-field col s12">
							<input id="course_editors" name="course_editors" placeholder="Course Editors (Emails Separated by Commas)" type="text">
							<label class="active" for="course_editors">Course Editors</label>
						</div>
					</div>

					<div class="row">
						<div class="col s12">
							<input type="checkbox" class="filled-in" id="course_hidden" name="course_hidden" value="1" />
							<label for="course_hidden">Hide Course</label>
						</div>
					</div>

					<input type="hidden" name="course_id" id="course_id">
				</div>
    	</div>
	    <div class="modal-footer">
				<button type="submit" class="modal-action waves-effect btn-flat white-text" style='margin-left:5px; background-color: <?php echo getSiteColor(); ?>'>Save</button>
				<a class="modal-close waves-effect btn-flat white-text"  style='background-color: <?php echo getSiteColor(); ?>'>Cancel</a>
		</div>
		</form>
	</div>

	<!-- Create Topic -->
	<div id="curriculumtopic" class="modal modal-fixed-footer modal-mobile-full">
		<form class="col s12" id="form-addtopic" method="post" action="modules/<?php echo basename(__DIR__); ?>/topic_process.php">
		<div class="modal-content" style="padding: 0px !important;">
			<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
				<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Topic</span></div>
				<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
			</div>
			<div style='padding: 0px 24px 0px 24px;'>
				<div class="row">
					<div class="input-field col s12">
						<input id="topic_title" name="topic_title" type="text" placeholder="Enter a title" required>
						<label class="active" for="topic_title">Topic Title</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input id="topic_theme" name="topic_theme" type="text" placeholder="Enter a theme" required>
						<label class="active" for="topic_theme">Topic Theme</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6">
					    <input type="date" name="topic_start_time" id="topic_start_time" class="topic_starttime">
							<label class="active" for="topic_start_time">Topic Start Time</label>
					</div>
					<div class="input-field col s6">
						<input type="number" name="topic_estimated_days" placeholder="Enter Duration of Topic" id="topic_estimated_days">
						<label class="active" for="topic_estimated_days">Estimated Days</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<div id="topicLoader" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="width:100%"></div>
						<div id="topicFiles"></div>
					</div>
				</div>
				<input type='hidden' name="topicID" id="topicID">
				<input type="hidden" name="courseID" id="courseID">
			</div>
    </div>
	  <div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat white-text" style='margin-left:5px; background-color: <?php echo getSiteColor(); ?>'>Save</button>
		  <a class="modal-close waves-effect btn-flat white-text" style='background-color: <?php echo getSiteColor(); ?>'>Close</a>
			<div style="margin-left: 20px; margin-top: 5px;">
				<a class="mdl-button mdl-js-button mdl-button--icon modal-linktopic" href='#linktotopic'><i class="material-icons">link</i></a>
				<a class="mdl-button mdl-js-button mdl-button--icon google-drive" href='#'><img class="material-icons" src='../../core/images/abre/google-drive-dark.png'></a>
				<a class="mdl-button mdl-js-button mdl-button--icon modal-standardtopic" href='#standardtotopic'><i class="material-icons">trending_up</i></a>
				<a class="mdl-button mdl-js-button mdl-button--icon modal-texttopic" href='#texttotopic'><i class="material-icons">subject</i></a>
				<a class="mdl-button mdl-js-button mdl-button--icon modal-lessontopic" href='#lessontotopic'><i class="material-icons">school</i></a>
			</div>
		</div>
		</form>
	</div>

	<!-- Add link to topic -->
	<div id="linktotopic" class="modal modal-fixed-footer" style="max-width: 600px;">
		<form class="col s12" id="form-addlinktotopic" method="post" action="modules/<?php echo basename(__DIR__); ?>/topic_link_process.php">
		<div class="modal-content" style="padding: 0px !important;">
			<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
				<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Add Link</span></div>
				<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
			</div>
			<div style='padding: 0px 24px 0px 24px;'>
				<div class="row">
					<div class="col s12">
						<label class="active">Choose a link category</label>
						<select name='topic_link_category' id='topic_link_category' class="browser-default" required>
							<option value=''></option>
							<option value='Resource'>Resource</option>
						  <option value='Assessment'>Assessment</option>
						  <option value='Lesson'>Lesson</option>
					  </select>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input id="topic_link_title" name="topic_link_title" placeholder="Enter the title of the link" type="text" required>
						<label class="active" for="topic_link_title">Link Title</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input id="topic_link_url" name="topic_link_url" placeholder="Enter or paste a link" type="url" required>
						<label class="active" for="topic_link_url">Link URL</label>
					</div>
				</div>
				<input type='hidden' name="topicID" id="topicID">
				<input type="hidden" name="courseID" id="courseID">
			</div>
    </div>
		<div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat white-text" style='background-color: <?php echo getSiteColor(); ?>'>Add Link</button>
		</div>
		</form>
	</div>

	<!-- Add note to topic -->
	<div id="texttotopic" class="modal modal-fixed-footer" style="max-width: 600px;">
		<form class="col s12" id="form-addtexttotopic" method="post" action="modules/<?php echo basename(__DIR__); ?>/topic_text_process.php">
		<div class="modal-content" style="padding: 0px !important;">
			<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
				<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Add Note</span></div>
				<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
			</div>
			<div style='padding: 0px 24px 0px 24px;'>
				<div class="row">
					<div class="col s12">
						<label class="active">Choose a category</label>
						<select name='topic_text_category' id='topic_text_category' class="browser-default" required>
							<option value=''></option>
							<option value='Resource'>Resource</option>
						  <option value='Assessment'>Assessment</option>
						  <option value='Lesson'>Lesson</option>
					  </select>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input id="topic_text_title" name="topic_text_title" type="text" placeholder="Enter a title" required>
						<label class="active" for="topic_text_title">Note Title</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<textarea id="topic_text_content" name="topic_text_content" class="materialize-textarea" placeholder="Enter body content" required></textarea>
						<label class="active" for="topic_text_content">Note Content</label>
					</div>
				</div>
				<input type='hidden' name="topicID" id="topicID">
				<input type="hidden" name="courseID" id="courseID">
				<input type="hidden" name="resourceID" id="resourceID">
			</div>
    </div>
	  <div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat white-text" style='background-color: <?php echo getSiteColor(); ?>'>Add Note</button>
		</div>
		</form>
	</div>

	<!-- Add lesson to topic -->
	<div id="lessontotopic" class="fullmodal modal modal-fixed-footer modal-mobile-full" style="width: 90%">
		<form class="col s12" id="form-addlessontotopic" method="post" action="modules/<?php echo basename(__DIR__); ?>/topic_lesson_process.php">
		<div class="modal-content" style="padding: 0px !important;">
			<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
				<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Model Lesson</span></div>
				<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
			</div>
			<div style='padding: 0px 24px 0px 24px;'>
				<div id='quillboundry'>
					<div class="row">
						<div class="input-field col s12">
							<input id="topic_lesson_title" name="topic_lesson_title" type="text" placeholder="Enter a title for the lesson" required>
							<label class='active' for="topic_lesson_title">Lesson Title</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6">
							<input id="lesson_number_text_content" placeholder="Enter a number for the lesson" name="lesson_number_text_content" type="number" required>
							<label class='active' for="lesson_number_text_content">Lesson Number</label>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<p class='black-text' style="font-weight: 500;">Standards</p>
							<input name="lesson_standards_text_content" name="lesson_standards_text_content" type="hidden">
							<input name="lesson_standards_text_content_html" name="lesson_standards_text_content_html" type="hidden">
							<div id="quill_standards" style='height:200px;'></div>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<p class='black-text' style="font-weight: 500;">Resources/Materials</p>
							<input name="lesson_resources_text_content" name="lesson_resources_text_content" type="hidden">
							<input name="lesson_resources_text_content_html" name="lesson_resources_text_content_html" type="hidden">
							<div id="quill_resources" style='height:200px;'></div>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<p class='black-text' style="font-weight: 500;">Anticipatory Set</p>
							<input name="lesson_anticipatory_set_text_content" name="lesson_anticipatory_set_text_content" type="hidden">
							<input name="lesson_anticipatory_set_text_content_html" name="lesson_anticipatory_set_text_content_html" type="hidden">
							<div id="quill_anticipatory" style='height:200px;'></div>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<p class='black-text' style="font-weight: 500;">Learning Objectives/Goals</p>
							<input name="lesson_learning_objectives_text_content" name="lesson_learning_objectives_text_content" type="hidden">
							<input name="lesson_learning_objectives_text_content_html" name="lesson_learning_objectives_text_content_html" type="hidden">
							<div id="quill_objectives" style='height:200px;'></div>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<p class='black-text' style="font-weight: 500;">Direct Instruction</p>
							<input name="lesson_direct_instruction_text_content" name="lesson_direct_instruction_text_content" type="hidden">
							<input name="lesson_direct_instruction_text_content_html" name="lesson_direct_instruction_text_content_html" type="hidden">
							<div id="quill_direct" style='height:200px;'></div>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<p class='black-text' style="font-weight: 500;">Guided Practice</p>
							<input name="lesson_guided_practice_text_content" name="lesson_guided_practice_text_content" type="hidden">
							<input name="lesson_guided_practice_text_content_html" name="lesson_guided_practice_text_content_html" type="hidden">
							<div id="quill_guided" style='height:200px;'></div>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<p class='black-text' style="font-weight: 500;">Independent Practice</p>
							<input name="lesson_independent_practice_text_content" name="lesson_independent_practice_text_content" type="hidden">
							<input name="lesson_independent_practice_text_content_html" name="lesson_independent_practice_text_content_html" type="hidden">
							<div id="quill_independent" style='height:200px;'></div>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<p class='black-text' style="font-weight: 500;">Formative Assessment(s)</p>
							<input name="lesson_formative_assessment_text_content" name="lesson_formative_assessment_text_content" type="hidden">
							<input name="lesson_formative_assessment_text_content_html" name="lesson_formative_assessment_text_content_html" type="hidden">
							<div id="quill_formative" style='height:200px;'></div>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<p class='black-text' style="font-weight: 500;">Closure</p>
							<input name="lesson_closure_text_content" name="lesson_closure_text_content" type="hidden">
							<input name="lesson_closure_text_content_html" name="lesson_closure_text_content_html" type="hidden">
							<div id="quill_closure" style='height:200px;'></div>
						</div>
					</div>
				</div>
				<input type='hidden' name="topicID" id="topicID">
				<input type="hidden" name="courseID" id="courseID">
				<input type="hidden" name="resourceID" id="resourceID">
			</div>
  	</div>
	  <div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat white-text" style='background-color: <?php echo getSiteColor(); ?>'>Save Lesson</button>
		</div>
		</form>
	</div>

	<!-- Add standard to topic -->
	<div id="standardtotopic" class="modal modal-fixed-footer modal-mobile-full" style="max-width: 600px;">
		<form class="col s12" id="form-standardtotopic" method="post" action="modules/<?php echo basename(__DIR__); ?>/topic_standard_process.php">
		<div class="modal-content" style="padding: 0px !important;">
			<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
				<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Add Standard</span></div>
				<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
			</div>
			<div style='padding: 0px 24px 0px 24px;'>
				<div class="row">
					<div class="col s12">
						<label class='active'>Choose a Collection</label>
						<select name='topic_standard_jurisdiction' id='topic_standard_jurisdiction' class="browser-default" required>
							<option value=''></option>
							<?php

							//Check if table exists
							$table = $db->query('SELECT title FROM `Abre_Standards_Jurisdictions` LIMIT 1');
							if($table !== FALSE)
							{

								//Query the table for available Jurisdictions
								$sqllogin = "SELECT title, type, returnId FROM `Abre_Standards_Jurisdictions` ORDER BY title";
								$resultlogin = $db->query($sqllogin);
								while($rowlogin = $resultlogin->fetch_assoc())
								{
									$standardSets_title=htmlspecialchars($rowlogin["title"], ENT_QUOTES);
									$standardSets_type=htmlspecialchars($rowlogin["type"], ENT_QUOTES);
									if($standardSets_type=="state"){ $standardSets_title = "State Standards"; }
									$standardSets_returnId=htmlspecialchars($rowlogin["returnId"], ENT_QUOTES);
									echo "<option value='$standardSets_returnId'>$standardSets_title</option>";
								}

							}

							?>
					    </select>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<label class='active'>Choose a Subject</label>
						<select name='topic_standard_subject' id='topic_standard_subject' class="browser-default" required>
							<option></option>
					   </select>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<label class='active'>Choose a Bank</label>
						<select name='topic_standard_bank' id='topic_standard_bank' class="browser-default" required>
							<option></option>
					  </select>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<label class='active'>Choose a Grade</label>
						<select name='topic_standard_grade' id='topic_standard_grade' class="browser-default" required>
							<option></option>
					  </select>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<label class='active'>Choose a Standard</label>
						<select name='topic_standard_standard' id='topic_standard_standard' class="browser-default" required>
							<option></option>
					  </select>
					</div>
				</div>
				<input type='hidden' name="topicID" id="topicID">
				<input type="hidden" name="courseID" id="courseID">
			</div>
    </div>
	  <div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat white-text" style='background-color: <?php echo getSiteColor(); ?>'>Add Standard</button>
		</div>
		</form>
	</div>

<script>

	$(function()
	{

		$('select').material_select();

		//Date Picker
		$('.topic_starttime').pickadate({ container: 'body', selectMonths: true, selectYears: 15 });

		//Attachment modals
		$('.modal-linktopic').leanModal({ in_duration: 0, out_duration: 0, ready: function() { } });
		$('.modal-standardtopic').leanModal({ in_duration: 0, out_duration: 0, ready: function() { } });

		$(".google-drive").off().on("click", function(event){
			event.preventDefault();
			var developerKey = "<?php echo CONSTANT('GOOGLE_API_KEY') ?>";
			var clientId = "<?php echo CONSTANT('GOOGLE_CLIENT_ID') ?>";


			var pickerApiLoaded = false;
			<?php $client->refreshToken($_SESSION['access_token']['refresh_token']); ?>
			var oauthToken = "<?php echo $client->getAccessToken()['access_token'] ?>";

			$.getScript("https://apis.google.com/js/api.js?onload=onApiLoad", function(data, textStatus, jqxhr){
				// Use the API Loader script to load google.picker
				function onApiLoad() {
					gapi.load('picker', onPickerApiLoad);
				}

				function onPickerApiLoad() {
					pickerApiLoaded = true;
					createPicker();
				}

				// Create and render a Picker object for picking user Photos.
				function createPicker() {
					<?php $client->refreshToken($_SESSION['access_token']['refresh_token']); ?>
					oauthToken = "<?php echo $client->getAccessToken()['access_token'] ?>";
					if (pickerApiLoaded && oauthToken) {
						var view = new google.picker.DocsView(google.picker.ViewId.DOCS)
											.setIncludeFolders(true)
											//.setEnableTeamDrives(true);
											.setOwnedByMe(true);
						var view2 = new google.picker.DocsView(google.picker.ViewId.DOCS)
											.setIncludeFolders(true)
											.setEnableTeamDrives(true);
						view.setMode(google.picker.DocsViewMode.LIST);
						var picker = new google.picker.PickerBuilder().
								addView(view).
								addView(view2).
								enableFeature(google.picker.Feature.SUPPORT_TEAM_DRIVES).
								setOAuthToken(oauthToken).
								setDeveloperKey(developerKey).
								setCallback(pickerCallback).
								build();
						picker.setVisible(true);
					}
					var elements= document.getElementsByClassName('picker-dialog');
					for(var i=0;i<elements.length;i++)
					{
						elements[i].style.zIndex = "2000";
					}
				}

				// A simple callback implementation.
				function pickerCallback(data) {
					if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
						var doc = data[google.picker.Response.DOCUMENTS][0];
						var url = doc[google.picker.Document.URL];
						var title = doc[google.picker.Document.NAME];
						var courseId = $("#courseID").val();
						var topicId = $("#topicID").val();

						$.ajax({
							type: 'POST',
							url: "modules/<?php echo basename(__DIR__); ?>/drive_link_process.php",
							data: {topicID: topicId, courseID: courseId, drive_link_title: title, drive_link_url: url}
						})

						//Show the notification
						.done(function(response) {

							$("#content_holder").load( "modules/<?php echo basename(__DIR__); ?>/pacingguide.php?id="+response.courseId+"&topicid="+response.topicId, function(){

								//Fill in files
								$( "#topicFiles" ).load( "modules/<?php echo basename(__DIR__); ?>/topic_list_resources.php?topicid="+response.topicId, function() {
									$("#topicLoader").hide();
								});

								$(".modal-content #courseID").val(response.courseId);
								$(".modal-content #topicID").val(response.topicId);

								mdlregister();

								var notification = document.querySelector('.mdl-js-snackbar');
								var data = { message: response.message };
								notification.MaterialSnackbar.showSnackbar(data);

							});
						})
					}
				}
				onApiLoad();
			});
		});

		//Start Quill
		var options = { modules: { toolbar: [[ 'bold', 'italic', { header: '1' }, 'blockquote', 'link', 'video', { list: 'ordered' }, { list: 'bullet' }]]}, theme: 'snow', bounds: '#quillboundry'};
		var quill_standards = document.getElementById('quill_standards'); var quill_standards_data = new Quill(quill_standards, options);
		var quill_resources = document.getElementById('quill_resources'); var quill_resources_data = new Quill(quill_resources, options);
		var quill_anticipatory = document.getElementById('quill_anticipatory'); var quill_anticipatory_data = new Quill(quill_anticipatory, options);
		var quill_objectives = document.getElementById('quill_objectives'); var quill_objectives_data = new Quill(quill_objectives, options);
		var quill_direct = document.getElementById('quill_direct'); var quill_direct_data = new Quill(quill_direct, options);
		var quill_guided = document.getElementById('quill_guided'); var quill_guided_data = new Quill(quill_guided, options);
		var quill_independent= document.getElementById('quill_independent'); var quill_independent_data = new Quill(quill_independent, options);
		var quill_formative = document.getElementById('quill_formative'); var quill_formative_data = new Quill(quill_formative, options);
		var quill_closure = document.getElementById('quill_closure'); var quill_closure_data = new Quill(quill_closure, options);

		//Fill in Lesson Topic Data
		$("body").off().on("click", ".modal-lessontopic", function ()
		{
			var Resource_ID= $(this).data('resourceid');
			$(".modal-content #resourceID").val(Resource_ID);
			var Lesson_Title= $(this).data('title'); $(".modal-content #topic_lesson_title").val(Lesson_Title);
			var Lesson_Number= $(this).data('number'); $(".modal-content #lesson_number_text_content").val(Lesson_Number);
			var Lesson_Standards = $(this).data('standards');
			if(Lesson_Standards){
				Lesson_Standards = atob(Lesson_Standards);
				Lesson_Standards = jQuery.parseJSON(Lesson_Standards);
				quill_standards_data.setContents(Lesson_Standards); }else{ quill_standards_data.setContents([ ]); }

			var Lesson_Resources= $(this).data('resources');
			if(Lesson_Resources){
				Lesson_Resources = atob(Lesson_Resources);
				Lesson_Resources = jQuery.parseJSON(Lesson_Resources);
				quill_resources_data.setContents(Lesson_Resources); }else{ quill_resources_data.setContents([ ]); }

			var Lesson_Anticipatory= $(this).data('anticipatory');
			if(Lesson_Anticipatory){
				Lesson_Anticipatory = atob(Lesson_Anticipatory);
				Lesson_Anticipatory = jQuery.parseJSON(Lesson_Anticipatory);
				quill_anticipatory_data.setContents(Lesson_Anticipatory); }else{ quill_anticipatory_data.setContents([ ]); }

			var Lesson_Objectives= $(this).data('objectives');
			if(Lesson_Objectives){
				Lesson_Objectives = atob(Lesson_Objectives);
				Lesson_Objectives = jQuery.parseJSON(Lesson_Objectives);
				quill_objectives_data.setContents(Lesson_Objectives); }else{ quill_objectives_data.setContents([ ]); }

			var Lesson_DirectInstruction= $(this).data('directinstruction');
			if(Lesson_DirectInstruction){
				Lesson_DirectInstruction = atob(Lesson_DirectInstruction);
				Lesson_DirectInstruction = jQuery.parseJSON(Lesson_DirectInstruction);
				quill_direct_data.setContents(Lesson_DirectInstruction); }else{ quill_direct_data.setContents([ ]); }

			var Lesson_GuidedPractice= $(this).data('guidedpractice');
			if(Lesson_GuidedPractice){
				Lesson_GuidedPractice = atob(Lesson_GuidedPractice);
				Lesson_GuidedPractice = jQuery.parseJSON(Lesson_GuidedPractice);
				quill_guided_data.setContents(Lesson_GuidedPractice); }else{ quill_guided_data.setContents([ ]); }

			var Lesson_IndependentPractice= $(this).data('independentpractice'); $(".modal-content #lesson_independent_practice_text_content").val(Lesson_IndependentPractice);
			if(Lesson_IndependentPractice){
				Lesson_IndependentPractice = atob(Lesson_IndependentPractice);
				Lesson_IndependentPractice = jQuery.parseJSON(Lesson_IndependentPractice);
				quill_independent_data.setContents(Lesson_IndependentPractice); }else{ quill_independent_data.setContents([ ]); }

			var Lesson_FormativeAssessment= $(this).data('formativeassessment'); $(".modal-content #lesson_formative_assessment_text_content").val(Lesson_FormativeAssessment);
			if(Lesson_FormativeAssessment){
				Lesson_FormativeAssessment = atob(Lesson_FormativeAssessment);
				Lesson_FormativeAssessment = jQuery.parseJSON(Lesson_FormativeAssessment);
				quill_formative_data.setContents(Lesson_FormativeAssessment); }else{ quill_formative_data.setContents([ ]); }

			var Lesson_Closure= $(this).data('closure'); $(".modal-content #lesson_closure_text_content").val(Lesson_Closure);
			if(Lesson_Closure){
				Lesson_Closure = atob(Lesson_Closure);
				Lesson_Closure = jQuery.parseJSON(Lesson_Closure);
				quill_closure_data.setContents(Lesson_Closure); }else{ quill_closure_data.setContents([ ]); }

		});

		//Jurisdiction change behavior
  	$('#topic_standard_jurisdiction').change(function()
  	{
    	var jurisdiction = $(this).val();

    	$.ajax({
	    	type: 'POST',
	    	url: 'modules/<?php echo basename(__DIR__); ?>/topic_subject_fill.php?jurisdiction='+jurisdiction
    	})
			.done(function(html){
				$('#topic_standard_subject').html(html);
				$('#topic_standard_bank').html('');
				$('#topic_standard_grade').html('');
				$('#topic_standard_standard').html('');
			})
  	});

  	//Standard change behavior
  	$('#topic_standard_subject').change(function()
  	{
    	var subject = $(this).val();

    	$.ajax({
	    	type: 'POST',
	    	url: 'modules/<?php echo basename(__DIR__); ?>/topic_bank_fill.php?subject='+subject
    	})
		.done(function(html){
			$('#topic_standard_bank').html(html);
			$('#topic_standard_grade').html('');
			$('#topic_standard_standard').html('');
		})
  	});

		//Bank change behavior
  	$('#topic_standard_bank').change(function()
  	{

			var subject = $('#topic_standard_subject').val();
    	var bank = $(this).val();

    	$.ajax({
	    	type: 'POST',
	    	url: 'modules/<?php echo basename(__DIR__); ?>/topic_grade_fill.php?subject='+subject+'&bank='+bank
    	})
		.done(function(html){
			$('#topic_standard_grade').html(html);
			$('#topic_standard_standard').html('');
		})
  	});

		//Grade change behavior
  	$('#topic_standard_grade').change(function()
  	{

			var subject = $('#topic_standard_subject').val();
			var bank = $('#topic_standard_bank').val();
			var grade = $('#topic_standard_grade').val();

    	$.ajax({
	    	type: 'POST',
	    	url: 'modules/<?php echo basename(__DIR__); ?>/topic_standard_fill.php?subject='+subject+'&bank='+bank+'&grade='+grade
    	})
		.done(function(html){
			$('#topic_standard_standard').html(html);
		})
  	});

		//Save new topic
		$('#form-addtopic').submit(function(event) {
			event.preventDefault();

			var form = $('#form-addtopic');
			var formMessages = $('#form-messages');

			$('#curriculumtopic').closeModal({ in_duration: 0, out_duration: 0, });

			var formData = $(form).serialize();
			$.ajax({
				type: 'POST',
				url: $(form).attr('action'),
				data: formData
			})
			.done(function(response) {
				$("input").val('');
				$("#content_holder").load( "modules/<?php echo basename(__DIR__); ?>/pacingguide.php?id="+response.courseid+"&topicid="+response.topicid, function(){
					mdlregister();
					var notification = document.querySelector('.mdl-js-snackbar');
					var data = { message: response.message };
					notification.MaterialSnackbar.showSnackbar(data);

				});
			})
		});


		//Add/Edit a Course
		$('#form-addcourse').submit(function(event){
			event.preventDefault();

			var form = $('#form-addcourse');
			var formMessages = $('#form-messages');

			$('#curriculumcourse').closeModal({
				in_duration: 0,
				out_duration: 0,
			});
			var formData = $(form).serialize();
			$.ajax({
				type: 'POST',
				url: $(form).attr('action'),
				data: formData
			})

			//Show the notification
			.done(function(response) {

				$("#content_holder").load( "modules/<?php echo basename(__DIR__); ?>/courses_display.php", function(){

					mdlregister();

					var notification = document.querySelector('.mdl-js-snackbar');
					var data = { message: response };
					notification.MaterialSnackbar.showSnackbar(data);

				});

			})
		});


		//Add Link to Topic
		$('#form-addlinktotopic').submit(function(event){
			event.preventDefault();

			var form = $('#form-addlinktotopic');
			var formMessages = $('#form-messages');

			$("#topicLoader").show();
			$('#linktotopic').closeModal({
				in_duration: 0,
				out_duration: 0,
			});
			var formData = $(form).serialize();
			$.ajax({
				type: 'POST',
				url: $(form).attr('action'),
				data: formData
			})

			//Show the notification
			.done(function(response) {
				$("#topic_link_title").val('');
				$("#topic_link_url").val('');

				$("#content_holder").load( "modules/<?php echo basename(__DIR__); ?>/pacingguide.php?id="+response.courseid+"&topicid="+response.topicid, function(){

					//Fill in files
					$( "#topicFiles" ).load( "modules/<?php echo basename(__DIR__); ?>/topic_list_resources.php?topicid="+response.topicid, function() {
						$("#topicLoader").hide();
					});

					$(".modal-content #courseID").val(response.courseid);
					$(".modal-content #topicID").val(response.topicid);

					$("#topic_link_category option[value='']").prop('selected',true);

					mdlregister();

					var notification = document.querySelector('.mdl-js-snackbar');
					var data = { message: response.message };
					notification.MaterialSnackbar.showSnackbar(data);

				});

			})
		});



		//Add Note to Topic
		$('#form-addtexttotopic').submit(function(event){
			event.preventDefault();

			var form = $('#form-addtexttotopic');
			var formMessages = $('#form-messages');

			$("#topicLoader").show();
			$('#texttotopic').closeModal({
				in_duration: 0,
				out_duration: 0,
			});
			var formData = $(form).serialize();
			$.ajax({
				type: 'POST',
				url: $(form).attr('action'),
				data: formData
			})

			//Show the notification
			.done(function(response) {
				$( "#topicFiles" ).show();
				$("#topic_text_title").val('');
				$("#topic_text_content").val('');

				$("#content_holder").load( "modules/<?php echo basename(__DIR__); ?>/pacingguide.php?id="+response.courseid+"&topicid="+response.topicid, function(){

					//Fill in files
					$( "#topicFiles" ).load( "modules/<?php echo basename(__DIR__); ?>/topic_list_resources.php?topicid="+response.topicid, function() {
						$("#topicLoader").hide();
					});

					$(".modal-content #courseID").val(response.courseid);
					$(".modal-content #topicID").val(response.topicid);

					$("#topic_link_category option[value='']").prop('selected',true);

					mdlregister();

						var notification = document.querySelector('.mdl-js-snackbar');
						var data = { message: response.message };
						notification.MaterialSnackbar.showSnackbar(data);

				});

			})
		});



		//Add Lesson to Topic
		$('#form-addlessontotopic').submit(function(event){
			event.preventDefault();

			var form = $('#form-addlessontotopic');
			var formMessages = $('#form-messages');

			$("#topicLoader").show();
			$('#lessontotopic').closeModal({
				in_duration: 0,
				out_duration: 0,
			});

			//Move Quill Content to Hidden Divs
			var Standards_WYSIWYG=document.querySelector('input[name=lesson_standards_text_content]');
			Standards_WYSIWYG.value = JSON.stringify(quill_standards_data.getContents());
			var Standards_HTML = quill_standards_data.root.innerHTML;
			$('input[name="lesson_standards_text_content_html"]').val(Standards_HTML);

			var Resources_WYSIWYG=document.querySelector('input[name=lesson_resources_text_content]');
			Resources_WYSIWYG.value = JSON.stringify(quill_resources_data.getContents());
			var Resources_HTML = quill_resources_data.root.innerHTML;
			$('input[name="lesson_resources_text_content_html"]').val(Resources_HTML);

			var Anticipatory_WYSIWYG=document.querySelector('input[name=lesson_anticipatory_set_text_content]');
			Anticipatory_WYSIWYG.value = JSON.stringify(quill_anticipatory_data.getContents());
			var Anticipatory_HTML = quill_anticipatory_data.root.innerHTML;
			$('input[name="lesson_anticipatory_set_text_content_html"]').val(Anticipatory_HTML);

			var Objectives_WYSIWYG=document.querySelector('input[name=lesson_learning_objectives_text_content]');
			Objectives_WYSIWYG.value = JSON.stringify(quill_objectives_data.getContents());
			var Objectives_HTML = quill_objectives_data.root.innerHTML;
			$('input[name="lesson_learning_objectives_text_content_html"]').val(Objectives_HTML);

			var Direct_WYSIWYG=document.querySelector('input[name=lesson_direct_instruction_text_content]');
			Direct_WYSIWYG.value = JSON.stringify(quill_direct_data.getContents());
			var Direct_HTML = quill_direct_data.root.innerHTML;
			$('input[name="lesson_direct_instruction_text_content_html"]').val(Direct_HTML);

			var Guided_WYSIWYG=document.querySelector('input[name=lesson_guided_practice_text_content]');
			Guided_WYSIWYG.value = JSON.stringify(quill_guided_data.getContents());
			var Guided_HTML = quill_guided_data.root.innerHTML;
			$('input[name="lesson_guided_practice_text_content_html"]').val(Guided_HTML);

			var Independent_WYSIWYG=document.querySelector('input[name=lesson_independent_practice_text_content]');
			Independent_WYSIWYG.value = JSON.stringify(quill_independent_data.getContents());
			var Independent_HTML = quill_independent_data.root.innerHTML;
			$('input[name="lesson_independent_practice_text_content_html"]').val(Independent_HTML);

			var Formative_WYSIWYG=document.querySelector('input[name=lesson_formative_assessment_text_content]');
			Formative_WYSIWYG.value = JSON.stringify(quill_formative_data.getContents());
			var Formative_HTML = quill_formative_data.root.innerHTML;
			$('input[name="lesson_formative_assessment_text_content_html"]').val(Formative_HTML);

			var Closure_WYSIWYG=document.querySelector('input[name=lesson_closure_text_content]');
			Closure_WYSIWYG.value = JSON.stringify(quill_closure_data.getContents());
			var Closure_HTML = quill_closure_data.root.innerHTML;
			$('input[name="lesson_closure_text_content_html"]').val(Closure_HTML);


			var formData = $(form).serialize();
			$.ajax({
				type: 'POST',
				url: $(form).attr('action'),
				data: formData
			})

			//Show the notification
			.done(function(response) {
				$( "#topicFiles" ).show();

				$("#content_holder").load( "modules/<?php echo basename(__DIR__); ?>/pacingguide.php?id="+response.courseid+"&topicid="+response.topicid, function(){

					//Fill in files
					$( "#topicFiles" ).load( "modules/<?php echo basename(__DIR__); ?>/topic_list_resources.php?topicid="+response.topicid, function() {
						$("#topicLoader").hide();
					});

					$(".modal-content #courseID").val(response.courseid);
					$(".modal-content #topicID").val(response.topicid);

					$("#topic_link_category option[value='']").prop('selected',true);

					mdlregister();

						var notification = document.querySelector('.mdl-js-snackbar');
						var data = { message: response.message };
						notification.MaterialSnackbar.showSnackbar(data);

				});
			})
		});



		//Add Standard to Topic
		$('#form-standardtotopic').submit(function(event){
			event.preventDefault();

			var form = $('#form-standardtotopic');
			var formMessages = $('#form-messages');

			$("#topicLoader").show();
			$('#standardtotopic').closeModal({
				in_duration: 0,
				out_duration: 0,
			});
			var formData = $(form).serialize();
			$.ajax({
				type: 'POST',
				url: $(form).attr('action'),
				data: formData
			})

			//Show the notification
			.done(function(response) {
				$("#topic_link_title").val('');
				$( "#topicFiles" ).show();
				$("#topic_link_url").val('');

				$("#content_holder").load( "modules/<?php echo basename(__DIR__); ?>/pacingguide.php?id="+response.courseid+"&topicid="+response.topicid, function(){

					//Fill in files
					$( "#topicFiles" ).load( "modules/<?php echo basename(__DIR__); ?>/topic_list_resources.php?topicid="+response.topicid, function() {
						$("#topicLoader").hide();
					});

					$(".modal-content #courseID").val(response.courseid);
					$(".modal-content #topicID").val(response.topicid);

					$("#topic_link_category option[value='']").prop('selected',true);

					mdlregister();

						var notification = document.querySelector('.mdl-js-snackbar');
						var data = { message: response.message };
						notification.MaterialSnackbar.showSnackbar(data);

				});

			})
		});

	//End Document Ready
	});


</script>
