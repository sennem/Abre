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
	require_once("functions.php");

?>

	<!-- Submit Incident -->
	<div id="conductincident" class="fullmodal modal modal-fixed-footer modal-mobile-full" style="width: 90%">
		<form id="form-conductincident" method="post" action="modules/<?php echo basename(__DIR__); ?>/incident_process.php">
		<div class="modal-content" style="padding: 0px !important;">
			<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
				<div class='col s11'><span class="truncate" id="conducttitle" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;"></span></div>
				<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
			</div>
			<div style='padding: 0px 24px 0px 24px;'>
				<div class="row">
					<div class="input-field col s12">
						<p id="conductsubtitle" style="font-weight: 500;"></p>
					</div>
					<span id="conducttags"></span>
				</div>

				<div class="row" id="conduct_search">
					<div class="input-field col s12">
						<label>Student</label>
						<input id="studentsearch" type="text" autocomplete="off" placeholder="Enter a Last Name or StudentID">
					</div>
				</div>

				<div style="display:none" id="searchresults"></div>

				<div id="searchloader" style="display:none">
					<div class="row"><div class="col s12"><div id='p2' class='mdl-progress mdl-js-progress mdl-progress__indeterminate landingloadergrid' style='width:100%;'></div></div></div>
				</div>

				<div class="row">
					<div class="col s12">
						<label>Incident Type</label><br><br>
					</div>
					<div class="col s12" style='padding-left:5px;'>
						<span style='margin-right:50px;'><input name="Type" type="radio" id="personal" value="Personal" required /><label for="personal">Personal Referral</label></span>
						<span><input name="Type" type="radio" id="office" value="Office" /><label for="office">Office Referral</label></span>
					</div>
				</div>

				<div class="row">
					<div class="input-field col l3 s6" id='incidentDateDiv' style='padding-left:10px;'>
						<b>Date of Incident</b>
						<input type="date" placeholder="Date of Incident" class="datepickerformatted" name="IncidentDate" id="IncidentDate" required>
					</div>
					<div class="input-field col l3 s6" id='incidentTimeDiv' style='padding-left:10px;'>
						<b>Time of Incident</b>
						<input type="text" placeholder="Time of Incident" name="IncidentTime" id="IncidentTime" style='width:calc(100% - 30px);' required>
						<a id='setTimeButton' href="#" style='float:right; margin-top:10px; color: #000;'><i class="material-icons">access_time</i></a>
					</div>
					<div class="input-field col l3 s6">
						<b>Offenses</b>
						<select name="Offence[]" id="Offence" multiple required>
							<option value="" disabled selected>Choose an Offense</option>
							<?php
							$sql = "SELECT Offence, ViolationNumber FROM conduct_offences ORDER BY Offence";
							$dbreturn = databasequery($sql);
							foreach ($dbreturn as $value){
								$offence = $value['Offence'];
								$ViolationNumber = $value['ViolationNumber'];
								echo "<option value='$offence'>$offence</option>";
							}
							?>
						</select>
					</div>
					<div class="input-field col l3 s6">
						<b>Location</b>
						<select name="Location" id="Location" required>
							<option value="" disabled selected>Location of Incident</option>
							<option value="Auditorium">Auditorium</option>
							<option value="Indoors">Indoors</option>
							<option value="BIC">BIC</option>
							<option value="Bus">Bus</option>
							<option value="Cafeteria/Serving Area">Cafeteria/Serving Area</option>
							<option value="Classroom">Classroom</option>
							<option value="Classroom(Shop/Lab/Home Ec)">Classroom(Shop/Lab/Home Ec)</option>
							<option value="Gym/Indoor Athletic Area">Gym/Indoor Athletic Area</option>
							<option value="Hallway/Foyer">Hallway/Foyer</option>
							<option value="HASP">HASP</option>
							<option value="HOPE">HOPE</option>
							<option value="Indoors-Other">Indoors-Other</option>
							<option value="Kitchen">Kitchen</option>
							<option value="Laboratory">Laboratory</option>
							<option value="Library/Resource Center">Library/Resource Center</option>
							<option value="Locker/Dressing Room">Locker/Dressing Room</option>
							<option value="Off Campus">Off Campus</option>
							<option value="Off Campus-Bus Stop">Off Campus-Bus Stop</option>
							<option value="Off Campus-School Event">Off Campus-School Event</option>
							<option value="Off Campus-To/From School">Off Campus-To/From School</option>
							<option value="Off Campus-Other">Off Campus-Other"</option>
							<option value="Office">Office</option>
							<option value="Outdoors">Outdoors</option>
							<option value="Outdoors-Parking Lot">Outdoors-Parking Lot</option>
							<option value="Outdoors-Playground">Outdoors-Playground</option>
							<option value="Outdoors-School Grounds">Outdoors-School Grounds</option>
							<option value="Outdoors-Walkway">Outdoors-Walkway</option>
							<option value="Outdoors-Other">Outdoors-Other</option>
							<option value="Restroom">Restroom</option>
							<option value="Showers">Showers</option>
							<option value="Stairs">Stairs</option>
							<option value="Storeroom">Storeroom</option>
							<option value="Weightroom">Weightroom</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="input-field col l6 s12">
						<b>Description (Facts and Details Viewable by Parents)</b>
						<textarea name="Description" id="Description" placeholder="Enter Fact and Details Here" required></textarea>
					</div>
					<div class="input-field col l6 s12">
						<b>Additional Information (Viewable by Administrator)</b>
						<textarea name="Information" id="Information" placeholder="Enter Additional Information Here"></textarea>
					</div>
				</div>

				<div id="conduct_consequence" style="display:none; padding-top:30px;" class="row">
					<?php
						echo "<table id='consequence_table'>";
						echo "<tr>";
						echo "<th>Consequence </th>";
						echo "<th> Start Date </th>";
						echo "<th> Thru Date </th>";
						echo "<th> Number of Days </th>";
						echo "<th> Report Generator </th>";
						echo "<th> Served </th>";
						echo "</tr>";

						for($i = 0; $i < 8; $i++){
							if($i != 0){
								echo "<tr class='toAdd' id='$i'>";
							}else{
								echo "<tr id='$i'>";
							}
				      echo "<td>";
				        $consequencetag = "Consequence".$i;
				        echo "<select class='Consequence' name='$consequencetag' id='$consequencetag'>";
				          echo "<option value='' selected>Choose a Consequence</option>";

				          $sql = "SELECT Consequence FROM conduct_consequences ORDER BY Consequence";
				          $dbreturn = databasequery($sql);
				          foreach ($dbreturn as $value){
				            $consequence = $value['Consequence'];
				            echo "<option value='$consequence'>$consequence</option>";
				          }

				      echo "</select>";
							$consequenceid = "Consequence_ID".$i;
							echo "<input type='hidden' class='ConsequenceID' name='$consequenceid' id='$consequenceid' value=''>";
				      echo "</td>";
				      echo "<td style='padding-left:10px;'>";
				        $serveDateid = "ServeDate".$i;
				        echo "<input type='date' placeholder='Serve Date' class='datepickerformatted ServeDate' name='$serveDateid' id='$serveDateid'>";
				      echo "</td>";
				      echo "<td style='padding-left:10px;'>";
				        $thruDateid = "ThruDate".$i;
				        echo "<input type='date' placeholder='Thru Date' class='datepickerformatted ThruDate' name='$thruDateid' id='$thruDateid'>";
				      echo "</td>";
				      echo "<td style='padding-left:10px;'>";
				        $numberOfDaysid = "NumberOfDaysServed".$i;
				        echo "<input type='number' class='NumberOfDaysServed' min='0' step='1' name='$numberOfDaysid' id='$numberOfDaysid'>";
				      echo "</td>";
				      $reportgeneratorid = "reportgenerator".$i;
				      echo "<td id='$reportgeneratorid' style='padding-left:10px;'>";
				        $pdfOptionid = "pdfOption".$i;
				        echo "<select class='pdfOption' name='$pdfOptionid' id='$pdfOptionid'>";
				          echo "<option value='' selected>Choose a PDF</option>";
									$sql = "SELECT districtID, pdf_options FROM conduct_settings LIMIT 1";
									$query = $db->query($sql);
									$row = $query->fetch_assoc();
									$districtID = $row["districtID"];
									if($row["pdf_options"] != ""){
										$pdfOptions = explode(PHP_EOL, $row['pdf_options']);
										foreach($pdfOptions as $option){
											$display = str_replace(array("\n\r", "\n", "\r"), '', $option);
											$val = str_replace(" ", "_", $display);
											echo "<option value ='$val'>$display</option>";
										}
									}
				        echo "</select>";
				      echo "</td>";
							echo "<td style='text-align:center'>";
								$checkboxid = "servedCheckbox".$i;
								echo "<input type='checkbox' class='filled-in servedCheckbox' name='$checkboxid' id='$checkboxid'/>";
								echo "<label class='servedCheckbox' for='$checkboxid'></label>";
							echo "</td>";
							echo "<td style='width:30px;'><a class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 removeConsequencesButton' style='margin-top:-10px;'><i class='material-icons'>delete</i></a></td>";
				      echo "</tr>";
				    }
				  	echo "</table>";
						echo "<div class='row'>";
							echo "<a class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored' style='background-color: ".getSiteColor()."' id='addconsequencebutton'>Add</a>";
						echo "</div>";
					?>
				</div>

				<div class="row" style='margin-top:40px;' id="offencesDiv">
					<div class="col s12">
						<p id="previousOffences"></p>
					</div>
				</div>

				<input type="hidden" name="Incident_Student_ID" id="Incident_Student_ID" value="">
				<input type="hidden" name="Incident_Student_IEP" id="Incident_Student_IEP" value="">
				<input type="hidden" name="Incident_Student_FirstName" id="Incident_Student_FirstName" value="">
				<input type="hidden" name="Incident_Student_MiddleName" id="Incident_Student_MiddleName" value="">
				<input type="hidden" name="Incident_Student_LastName" id="Incident_Student_LastName" value="">
				<input type="hidden" name="Incident_Student_Building" id="Incident_Student_Building" value="">
				<input type="hidden" name="Incident_Student_Code" id="Incident_Student_Code" value="">
				<input type="hidden" name="Incident_Reload" id="Incident_Reload" value="">
				<input type="hidden" name="Incident_ID" id="Incident_ID" value="">
				<input type="hidden" name="Owner_Email" id="Owner_Email" value="">
				<input type="hidden" name="dupIncidentId" id="dupIncidentId" value="">
			</div>

    </div>
		<div class="modal-footer" id="conduct_footer">
			<div id ="footerButtonsDiv" style='display: inline-block; float:right'>
				<button type="submit" class="modal-action waves-effect btn-flat white-text" style='margin-left:5px; background-color: <?php echo getSiteColor(); ?>'>Save</button>
				<a class="modal-action waves-effect btn-flat white-text"  id="duplicateIncident" style='background-color: <?php echo getSiteColor(); ?>'>Duplicate</a>
				<a class="modal-close waves-effect btn-flat white-text"  id="archiveIncident" style='margin-right:5px; background-color: <?php echo getSiteColor(); ?>;display:none;'>Archive</a>
			</div>
		</div>
		</form>
	</div>

		<!-- Assessment Details Modal -->
		<div id="assessmentlook" class="fullmodal modal modal-fixed-footer modal-mobile-full">
			<div class="modal-content" style="padding: 0px !important;">
				<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
					<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Assessment Details</span></div>
					<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
				</div>
				<div style='padding: 0px 24px 0px 24px;'>
					<div class="row">
						<div class="input-field col s12">
							<div id="assessmentdetailsloader"><div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="width:100%;"></div></div>
							<div id="assessmentdetails"></div>
						</div>
					</div>
				</div>
		  </div>
			<div class="modal-footer">
				<a class="modal-close waves-effect btn-flat white-text" style='margin-left:5px; background-color: <?php echo getSiteColor(); ?>'>Close</a>
			</div>
		</div>

		<!-- Conduct Details Modal -->
		<div id="conductlook" class="fullmodal modal modal-fixed-footer modal-mobile-full">
			<div class="modal-content" style="padding: 0px !important;">
				<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
					<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Conduct Details</span></div>
					<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
				</div>
				<div style='padding: 0px 24px 0px 24px;'>
					<div class="row">
						<div class="input-field col s12">
							<div id="conductdetailsloader"><div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="width:100%;"></div></div>
							<div id="conductdetails"></div>
						</div>
					</div>
				</div>
		  </div>
			<div class="modal-footer">
				<a class="modal-close waves-effect btn-flat white-text" style='margin-left:5px; background-color: <?php echo getSiteColor(); ?>'>Close</a>
			</div>
		</div>

		<!-- Student Quick View Modal -->
		<div id="studentlook" class="fullmodal modal modal-fixed-footer modal-mobile-full">
			<div class="modal-content" style="padding: 0px !important;">
				<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
					<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Student Quick Look</span></div>
					<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
				</div>
				<div style='padding: 0px 24px 0px 24px;'>
					<div class="row">
						<div class="input-field col s12">
							<div id="studentdetailsloader"><div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="width:100%;"></div></div>
							<div id="studentdetails"></div>
						</div>
					</div>
				</div>
		  </div>
			<div class="modal-footer">
				<a class="modal-close waves-effect btn-flat white-text" style='margin-left:5px; background-color: <?php echo getSiteColor(); ?>'>Close</a>
			</div>
		</div>

<script>

	$(function(){
		//$('select').material_select();

		//Blank Date Check
		function checkDate(){
			if($('#IncidentDate').val() == ''){
				return true;
			}else{
				return false;
		  }
		}

		//Save new incident
		$('#form-conductincident').submit(function(event){
			event.preventDefault();
			$('option:not(:selected)').removeAttr('disabled');
			$('select').find('option:first').attr('disabled', 'disabled');
			var StudentID = $( "#Incident_Student_ID" ).val();
			if(StudentID != ""){
				if(checkDate() != true){
					var form = $('#form-conductincident');
					var formMessages = $('#form-messages');

					$('#conductincident').closeModal({ in_duration: 0, out_duration: 0, });

					var formData = $(form).serialize();
					$.ajax({
						type: 'POST',
						url: $(form).attr('action'),
						data: formData
					})
					.done(function(response) {
						$('#form-conductincident').trigger("reset");

						mdlregister();
						var notification = document.querySelector('.mdl-js-snackbar');
						var data = { message: response.message };
						notification.MaterialSnackbar.showSnackbar(data);

						var query = $("#conductsearchquery").val();
						var fromdate = $("#conductsearchqueryfrom").val();
						var thrudate = $("#conductsearchquerythru").val();
						var page = $("#conductsearchquerypage").val();
						if(response.reload !== undefined){
							$.post( "modules/<?php echo basename(__DIR__); ?>/"+response.reload+"_display.php",
							{ conductsearch: query, conductfrom: fromdate, conductthru: thrudate, page: page })
							.done(function(data) {
								window.location = "#conduct/discipline/"+response.reload;
								$("#conductsearch").hide();
								$("#searchresultsloader").html(data);
							});
						}
					})
				}else{
					alert("Please Set the Date of Incident");
				}
			}else{
				alert("Please Select a Student");
			}
		});

		//saves the form then generates a new pdf with that information
		$(".pdfOption").change(function() {
			var selectValue = $(this).val().replace(/\s/g, '');
			var rowid = $(this).closest('tr').attr('id');
			var consequenceElement = $(this).closest('tr').find('.ConsequenceID');
			var consequenceValue = $(this).closest('tr').find('.Consequence option:checked').val();
			if(selectValue != null){
				event.preventDefault();
				$('option:not(:selected)').removeAttr('disabled');
				$('select').find('option:first').attr('disabled', 'disabled');
				var StudentID = $( "#Incident_Student_ID" ).val();
				if(StudentID != "" ){
					if(consequenceValue != ""){
						if(checkDate() != true){
							var form = $('#form-conductincident');
							var formMessages = $('#form-messages');
							var formData = $(form).serialize();
							$.ajax({
								type: 'POST',
								url: $(form).attr('action'),
								data: formData
							})
							.done(function(response) {
								if(response.method == "error"){
									alert(response.message);
								}else{
									$("#Incident_ID").val(response.incidentid);
									var consequenceid = response.consequenceid[rowid];
									if(consequenceElement.val() == ""){
										consequenceElement.val(consequenceid);
									}

									var pdfurl = "./modules/Abre-Conduct/generatePDF.php?id="+response.incidentid+"&pdfOption="+selectValue+"&ConsequenceID="+consequenceid+"&districtID=<?php echo $districtID ?>";
									window.open(pdfurl);

									var query = $("#conductsearchquery").val();
									var fromdate = $("#conductsearchqueryfrom").val();
									var thrudate = $("#conductsearchquerythru").val();
									var page = $("#conductsearchquerypage").val();
									if(response.reload !== undefined){
										$.post( "modules/<?php echo basename(__DIR__); ?>/"+response.reload+"_display.php", { conductsearch: query, conductfrom: fromdate, conductthru: thrudate, page: page })
										.done(function(data) {
											$("#conductsearch").hide();
											$("#searchresultsloader").html(data);
										});
									}
								}
							});
						}else{
							alert("Please set the date of incident.");
						}
					}else{
						alert("Please add a consequence before generating a report.");
					}
				}else{
					alert("Please add a student before generating a report.");
				}
			}
		});

		//Search Delay
		var delay = (function(){
		  var timer = 0;
		  return function(callback, ms){
		    clearTimeout (timer);
		    timer = setTimeout(callback, ms);
		  };
		})();

		//Time Picker
		$('#IncidentTime').timepicker();
		$('#setTimeButton').on('click', function (event){
			event.preventDefault();
		  $('#IncidentTime').timepicker('setTime', new Date());
		});

  	$('.datepickerformatted').pickadate({ container: 'body', format: 'yyyy-mm-dd', selectMonths: true, selectYears: 15 });

  		//Type Change
		<?php
		if(!admin())
		{
		?>
	    	$("#office").change(function()
	    	{
		    	$("#Consequence").val('');
		    	$("#Consequence").prop("disabled", true);
		    	$('#conductserved').prop('checked',false);
		    	$('select').material_select();
					Materialize.updateTextFields();
		    });
		<?php
		}
		?>

    //Student Search/Filter
    $("#studentsearch").keyup(function(){
			mdlregister();
			$("#searchresults").hide();
			$("#searchloader").show();

	    delay(function(){
				var studentsearch = $('#studentsearch').val();
		    studentsearch = btoa(studentsearch);

				$("#searchresults").load('modules/<?php echo basename(__DIR__); ?>/search.php?query='+studentsearch, function(){
					$("#searchloader").hide();
					$("#searchresults").show();
				});
			}, 500);
		});

		//Archive the Incident
		$( "#archiveIncident" ).unbind().click(function(){
			event.preventDefault();
			var result = confirm("Are you sure you want to archive this incident?");
			if(result){
				var StudentID = $( "#Incident_Student_ID" ).val();
				var incidentid = $('#Incident_ID').val();
				var incidentreload = $('#Incident_Reload').val();
				if(StudentID != ""){
					if(checkDate() != true){
						var form = $('#form-conductincident');
						var formMessages = $('#form-messages');
						var formData = $(form).serialize();
						$.ajax({
							type: 'POST',
							url: $(form).attr('action'),
							data: formData
						})
						.done(function(response) {
							$.ajax({
								type: 'POST',
								url: 'modules/Abre-Conduct/archiveIncident.php',
								data: { id : incidentid, reload: incidentreload }
							})
							.done(function(response) {
								mdlregister();
								var notification = document.querySelector('.mdl-js-snackbar');
								var data = { message: response.message };
								notification.MaterialSnackbar.showSnackbar(data);

								var query = $("#conductsearchquery").val();
								var fromdate = $("#conductsearchqueryfrom").val();
								var thrudate = $("#conductsearchquerythru").val();
								var page = $("#conductsearchquerypage").val();
								if(response.reload !== undefined){
									$.post( "modules/<?php echo basename(__DIR__); ?>/"+response.reload+"_display.php",
									{ conductsearch: query, conductfrom: fromdate, conductthru: thrudate, page: page })
									.done(function(data) {
										$("#conductsearch").hide();
										$("#searchresultsloader").html(data);
									});
								}
							});
						});
					}
				}
			}
		});

		$( "#duplicateIncident" ).unbind().click(function(){
			event.preventDefault();
			$('option:not(:selected)').removeAttr('disabled');
			$('select').find('option:first').attr('disabled', 'disabled');
			var StudentID = $( "#Incident_Student_ID" ).val();
			var ownerEmail = $("#Owner_Email").val();
			var dupIncidentId = $("#Incident_ID").val();
			if(StudentID != ""){
				if(checkDate() != true){
					var form = $('#form-conductincident');
					var formMessages = $('#form-messages');
					var formData = $(form).serialize();
					$.ajax({
						type: 'POST',
						url: $(form).attr('action'),
						data: formData
					})
					.done(function(response) {
						$('.modal-content').scrollTop(0);
						$("#duplicateIncident").hide();
						$("#dupIncidentId").val(dupIncidentId);
						$("#conducttitle").text("Duplicate Discipline Incident");
						$("#conductsubtitle").html('');
						$("#conduct_search").show();
						$("#conducttags").html("");
						$("#searchresults").show();
						$("#searchresults").html("");
						$("#studentsearch").val("");
						$('#studentsearch').prop('required',true);
						$("input[name=Type]").prop("disabled", false);
						$("#Offence").prop("disabled", false);
						$("#Location").prop("disabled", false);
						$("#Description").prop("disabled", false);
						$("#Information").prop("disabled", false);
						$("#IncidentDate").prop("disabled", false);
						$("#IncidentTime").prop("disabled", false);
						$("#Incident_Student_ID").val('');
						$("#Incident_Student_IEP").val('');
						$("#Incident_Student_FirstName").val('');
						$("#Incident_Student_LastName").val('');
						$("#Incident_Student_Building").val('');
						$("#Incident_Student_Code").val('');
						$("#Incident_Reload").val('');
						$("#Incident_ID").val('');
						$("#Owner_Email").val(ownerEmail);
						$("#previousOffences").hide();
						$("#archiveIncident").hide();
						$('select').material_select();
						Materialize.updateTextFields();
						<?php if(admin() || conductAdminCheck($_SESSION['useremail'])){ ?>
										$("#conduct_consequence").show();
										$(".Consequence").prop("disabled", false);
										$("#addconsequencebutton").show();
										$(".ServeDate").prop("disabled", false);
										$(".ThruDate").prop("disabled", false);
										$(".NumberOfDaysServed").prop("disabled", false);
										$(".servedCheckbox").prop("disabled", false);
						<?php }
						 			if(!admin() && !conductAdminCheck($_SESSION["useremail"])){ ?>
										$("#office").prop("disabled", true);
						<?php } ?>
						for(var i = 0; i < 8; i++){
							$("#Consequence_ID"+i).val("");
						}

						var query = $("#conductsearchquery").val();
						var fromdate = $("#conductsearchqueryfrom").val();
						var thrudate = $("#conductsearchquerythru").val();
						var page = $("#conductsearchquerypage").val();
						if(response.reload !== undefined){
							$.post( "modules/<?php echo basename(__DIR__); ?>/"+response.reload+"_display.php",
							{ conductsearch: query, conductfrom: fromdate, conductthru: thrudate, page: page })
							.done(function(data) {
								$("#conductsearch").hide();
								$("#searchresultsloader").html(data);
							});
						}
					});
				}
			}
		});

		$( ".removeConsequencesButton" ).unbind().click(function(){
			event.preventDefault();
			var result = confirm("Are you sure you want to remove this consequence?");
			if (result){
				var incidentid = $('#Incident_ID').val();
				var consequenceid = $(this).closest('tr').find('.ConsequenceID').val();
				var incidentreload = $('#Incident_Reload').val();
				$(this).closest('tr').addClass("toAdd");
				$(this).closest('tr').hide();
				$(this).closest('tr').find('.ConsequenceID').val('');
				$(this).closest('tr').find('.Consequence').val('');
				$(this).closest('tr').find('.ServeDate').val('');
				$(this).closest('tr').find('.ThruDate').val('');
				$(this).closest('tr').find('.NumberOfDaysServed').val("");
				$(this).closest('tr').find('.servedCheckbox').prop('checked',false);
				$(this).closest('tr').find('.pdfOption').val('');
				$('select').material_select();
				if($("#conducttitle").text() != "Duplicate Discipline Incident"){
					$.ajax({
						type: 'POST',
						url: 'modules/Abre-Conduct/removeConsequence.php',
						data: { incidentid: incidentid, consequenceid: consequenceid, reload: incidentreload }
					})
					.done(function(response) {
						var query = $("#conductsearchquery").val();
						var fromdate = $("#conductsearchqueryfrom").val();
						var thrudate = $("#conductsearchquerythru").val();
						var page = $("#conductsearchquerypage").val();
						if(response.reload !== undefined){
							$.post( "modules/<?php echo basename(__DIR__); ?>/"+response.reload+"_display.php",
							{ conductsearch: query, conductfrom: fromdate, conductthru: thrudate, page: page })
							.done(function(data) {
								$("#conductsearch").hide();
								$("#searchresultsloader").html(data);
							});
						}
					});
				}
			}
		});

		//Open up preview of Student app on click
		$(document).off().on('click', '.modal-studentlook', function(event){
			event.preventDefault();
			var StudentID = $(this).data('studentid');
			$("#searchresults").html('');
		  $('#studentlook').openModal({
				in_duration: 0,
				out_duration: 0,
				ready: function(){
					$("#studentdetailsloader").show();
				  $("#studentdetails").html('');
				  $("#studentdetails").load('modules/Abre-Students/student.php?Student_ID='+StudentID, function(){ $("#studentdetailsloader").hide(); mdlregister(); });
				},
			});
		});

		$('.toAdd').hide();

		$('#addconsequencebutton').off().on('click',function(event){
			event.preventDefault();
			$('.toAdd:eq('+0+')').show();
			var id = $('.toAdd:eq('+0+')').attr('id');
			$('.toAdd:eq('+0+')').removeClass("toAdd");
			if(id == 7){
				$('#addconsequencebutton').hide();
			}
		});
	});

</script>