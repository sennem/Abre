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
			<h4>Set Your Work Schedule</h4>
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
	
<script>
	
			$(document).ready(function()
 			{
				var today = new Date();
				var y = today.getFullYear();			
				$('#workcalendardisplay').multiDatesPicker({
					<?php
						if($_SESSION['usertype']!="student")
						{
							$sql = "SELECT * FROM profiles where email='".$_SESSION['useremail']."'";
							$dbreturn = databasequery($sql);
							foreach ($dbreturn as $row)
							{
								$work_calendar_saved=htmlspecialchars($row['work_calendar'], ENT_QUOTES);
								if($work_calendar_saved!=NULL)
								{
									$work_calendar_saved = str_replace(' ', '', $work_calendar_saved);
									$work_calendar_saved=explode(",", $work_calendar_saved);
									$work_calendar_saved=implode("','", $work_calendar_saved);
									$work_calendar_saved="'".$work_calendar_saved."'";
									echo "addDates: [$work_calendar_saved],";
									//echo "addDisabledDates:['12/04/2016','12/03/2016'],";
								}
								else
								{
									include "calendar_default_dates.php";
									echo "addDates: [$work_calendar_saved],";
									//echo "addDisabledDates:['12/04/2016','12/03/2016'],";
								}
							}
						}
					?>
					numberOfMonths: [6,2],
					defaultDate: '8/1/'+y,
					altField: '#saveddates',
					dayNamesMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
					onSelect: function (date) {

				        var dates = $('#workcalendardisplay').multiDatesPicker('getDates').length;
						$("#selecteddays").text(dates + " Days Selected");
						
						
						
						var datestosave = $( "#saveddates" ).val();
						$.ajax({
							type: 'POST',
							url: '/modules/profile/calendar_update.php',
							data: { calendardaystosave : datestosave },
						})
								
						//Show the notification
						.done(function(response) {
							//var notification = document.querySelector('.mdl-js-snackbar');
							//var data = { message: response };
							//notification.MaterialSnackbar.showSnackbar(data);
						})
						
						
						
				    }
				});
				
	 			var dates = $('#workcalendardisplay').multiDatesPicker('getDates').length;
				$("#selecteddays").text(dates + " Days Selected");
				
				
			});
			
</script>