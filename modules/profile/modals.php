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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

?>

	<!--Work Schedule-->
	<div id="viewschedule" class="modal modal-fixed-footer modal-mobile-full" style='width: 80%'>
	    <div class="modal-content">
				<div class='row'>
					<div class ='col l8 s12'>
					<h4>Set Your Work Schedule</h4>
					</div>
					<div class='col l2 s12' style='float:right;'>
						<select id='calendaryear'>
							<option value='2016' selected>2016-2017 School Year</option>
							<option value='2017'>2017-2018 School Year</option>
							<option value='2018'>2018-2019 School Year</option>
							<option value='2019'>2019-2020 School Year</option>
							<option value='2020'>2020-2021 School Year</option>
						</select>
					</div>
				</div>
				<div class='row'>
					<div class='col m3 hide-on-small-only'>
						<?php include "calendarsidebar.php"; ?>
					</div>
					<div class='col m9 s12'>
						<?php echo "<form id='form-calendar' method='post'>"; ?>
							<input id="saveddates" type="hidden"></input>
						</form>
						<div id="workcalendardisplay"></div>
					</div>
				</div>
	    </div>
		<div class="modal-footer">
			<button class="modal-close waves-effect btn-flat white-text" style='margin-left:5px; background-color: <?php echo sitesettings("sitecolor"); ?>'>Close</button>
			<button class="printbutton waves-effect btn-flat white-text" style='background-color: <?php echo sitesettings("sitecolor"); ?>'>Print</button>
			<div id="selecteddays" style='margin:12px 0 0 20px; font-weight:500; font-size:16px;'></div>
	    </div>
	</div>

<!--Stream Editor-->
	<?php
	if(superadmin())
	{
	?>

	<div id='streameditor' class='modal modal-fixed-footer modal-mobile-full'>
		<div class='modal-content'>
			<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<div class='row'>
				<div class='col s12'>
					<h4>Stream Editor</h4>
					<?php
						include "stream_editor_content.php";
					?>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<a class='modal-action waves-effect btn-flat white-text modal-addeditstream' href='#addeditstream' data-streamtitle='Add New Stream' style='background-color: <?php echo sitesettings("sitecolor"); ?>'>Add</a>
		</div>
	</div>

	<div id='addeditstream' class='modal modal-fixed-footer modal-mobile-full' style="width: 90%">
		<form id='addeditstreamform' method="post" action='#'>
		<div class='modal-content' id="viewstreammodal">
			<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<div class='row'>
				<div class='col s12'><h4 id='editstreammodaltitle'></h4></div>
				<div class='input-field col s12'>
					<input placeholder="Enter Stream Name" id="stream_name" name="stream_name" type="text" autocomplete="off" required>
					<label for="stream_name" class="active">Name</label>
				</div>
				<div class='input-field col s12'>
					<input placeholder="Enter RSS Link" id="rss_link" name="rss_link" type="text" autocomplete="off" required>
					<label for="rss_link" class="active">Link</label>
				</div>
			</div>
			<div class='row'>
				<div class='col m4 s12'>
						<input type="radio" name="streamradio" id="stream_staff" value="staff" required>
						<label for="stream_staff">Staff</label>
				</div>
				<div class='col m4 s12'>
					<input type="radio" name="streamradio" id="stream_students" value="students">
					<label for="stream_students">Students</label>
				</div>
				<div class='col m4 s12'>
					<input type="radio" name="streamradio" id="stream_parents" value="parent">
					<label for="stream_parents">Parents</label>
				</div>
			</div>
			<div class='row'>
				<div class='col m4 s12'>
					<input type="checkbox" class="filled-in" name="streamradio" id="required_stream" value="1">
					<label for="required_stream">Require Stream</label>
				</div>
			</div>
			<input id="stream_id" name="stream_id" type="hidden">
		</div>
		<div class='modal-footer'>
			<button type="submit" class='modal-action waves-effect btn-flat white-text' id='saveupdatestream' style='background-color: <?php echo sitesettings("sitecolor"); ?>'>Save</button>
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
  $('select').material_select();

   	<?php
	if(superadmin())
	{
	?>

		//Add/Edit Stream
		$('.modal-addeditstream').leanModal({
			in_duration: 0,
			out_duration: 0,
			ready: function()
			{
				$(".modal-content").scrollTop(0);
				$("#editstreammodaltitle").text('Add New Stream');
				$("#stream_name").val('');
				$("#rss_link").val('');
				$("#stream_id").val('');
				$('#stream_staff').prop('checked', false);
				$('#stream_students').prop('checked', false);
				$('#stream_parents').prop('checked', false);
				$('#required_stream').prop('checked', false);
			}
		});

		//Save/Update Stream
		$('#addeditstreamform').submit(function(event)
		{
			event.preventDefault();

			var streamtitle = $('#stream_name').val();
			var rsslink = $('#rss_link').val();
			var streamgroup= $('input[name=streamradio]:checked').val();

			var streamid = $('#stream_id').val();
			if($('#required_stream').is(':checked')==true){ var required = 1; }else{ var required = 0; }

			//Make the post request
			$.ajax({
				type: 'POST',
				url: 'modules/profile/update_stream.php',
				data: { title: streamtitle, link: rsslink, id: streamid, group: streamgroup, required: required }

			})

			.done(function(){
				$('#addeditstream').closeModal({ in_duration: 0, out_duration: 0 });
				$('#streamsort').load('modules/profile/stream_editor_content.php');
				$('#content_holder').load( 'modules/profile/profile.php');
			});
		});

	<?php
	}
	?>


		var today = new Date();
		var y = $('#calendaryear').val();
		var defaultDate = '8/1/'+y;
		var currYear = y;

		$.ajax({
			type: 'POST',
			url: '/modules/profile/load_dates.php',
			data: { year : y },
		})
		.done(function(response) {
			var dateArray = response.addDates;
			var json = response.jsonDates;

			$('#workcalendardisplay').multiDatesPicker({
				addDates: dateArray,
				numberOfMonths: [6,2],
				defaultDate: defaultDate,
				altField: '#saveddates',
				dayNamesMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
				onSelect: function (date) {

					var dates = $('#workcalendardisplay').multiDatesPicker('getDates').length;
					console.log(dates);
					$("#selecteddays").text(dates + " Days Selected");

					var datestosave = $( "#saveddates" ).val();

					$.ajax({
						type: 'POST',
						url: '/modules/profile/calendar_update.php',
						data: { year: y, calendardaystosave : datestosave, jsonDates: json },
					})
				}
			});

			var dates = $('#workcalendardisplay').multiDatesPicker('getDates').length;
			$("#selecteddays").text(dates + " Days Selected");
		})

		$("#calendaryear").change(function(){
			var y = $('#calendaryear').val();
			var defaultDate = '8/1/'+y;

			$.ajax({
				type: 'POST',
				url: '/modules/profile/load_dates.php',
				data: { year : y },
			})
			.done(function(response) {
				var dateArray = response.addDates;
				var json = response.jsonDates;

				$('#workcalendardisplay').multiDatesPicker('destroy');
				$('#workcalendardisplay').multiDatesPicker({
					addDates: dateArray,
					numberOfMonths: [6,2],
					defaultDate: defaultDate,
					altField: '#saveddates',
					dayNamesMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
					onSelect: function (date) {

						var dates = $('#workcalendardisplay').multiDatesPicker('getDates').length;
						console.log(dates);
						$("#selecteddays").text(dates + " Days Selected");

						var datestosave = $( "#saveddates" ).val();

						$.ajax({
							type: 'POST',
							url: '/modules/profile/calendar_update.php',
							data: { year: y, calendardaystosave : datestosave, jsonDates: json },
						})
					}
				});
				var dates = $('#workcalendardisplay').multiDatesPicker('getDates').length;
				$("#selecteddays").text(dates + " Days Selected");
			})
			if(currYear != y){
				$('#workcalendardisplay').multiDatesPicker('resetDates', 'picked');
				currYear = y;
			}
		});
});
</script>
