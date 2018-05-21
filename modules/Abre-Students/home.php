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
	require_once('functions.php');
	require_once('permissions.php');

	if(CONSTANT('SITE_MODE') == "DEMO"){
		echo "<div style='padding:30px; text-align:center; width:100%;'>";
			echo "<div class='row'>";
				echo "<span style='font-size: 22px; font-weight:700'>Learn more about the Students App for hosted districts!</span><br>";
			echo "</div>";
			echo "<div class='row center-align'>";
				echo "<iframe id='studentsDemoVideo' src='https://player.vimeo.com/video/262274494' width='640' height='400' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<p style='font-size:16px; margin:20px 0 0 0;'>For more information about the Abre Platform visit <a href='https://www.abre.io/' style='color:".getSiteColor().";' target='_blank'>our website</p>";
			echo "</div>";
		echo "</div>";
	}else{
		if($pagerestrictions == ""){

			//Get Staff ID given email
			$StaffId = GetStaffID($_SESSION['useremail']);
			$CurrentSememester = GetCurrentSemester();

			if($StaffId == ""){
				echo "<div class='row center-align'><div class='col s12'><h6>You are not a registered user in the student information system</h6></div></div>";
			}else{

				//Get Total Students from courses
				$query = "SELECT COUNT(*) FROM (SELECT * FROM Abre_StudentSchedules WHERE StaffId = '$StaffId' AND (TermCode = '$CurrentSememester' OR TermCode = 'Year') GROUP BY StudentID) AS Result";
				$dbreturn = $db->query($query);
				$resultsrow = $dbreturn->fetch_assoc();
				$StudentCount_Courses = $resultsrow["COUNT(*)"];

				//Get Total Student from groups
				$query = "SELECT COUNT(*) FROM (SELECT * FROM students_groups_students WHERE StaffId = '$StaffId' GROUP BY Student_ID) AS Result";
				$dbreturn = $db->query($query);
				$resultsrow = $dbreturn->fetch_assoc();
				$StudentCount_Groups = $resultsrow["COUNT(*)"];

				//Total Students
				$StudentCount = $StudentCount_Courses + $StudentCount_Groups;

				//Get Students on IEP from courses
				$query = "SELECT COUNT(*) FROM (SELECT * FROM Abre_StudentSchedules WHERE StaffId = '$StaffId' AND (TermCode = '$CurrentSememester' OR TermCode = 'Year') AND StudentIEPStatus = 'Y' GROUP BY StudentID) AS Result";
				$dbreturn = $db->query($query);
				$resultsrow = $dbreturn->fetch_assoc();
				$IEPCount_Courses = $resultsrow["COUNT(*)"];

				//Get Students from Groups that are on IEP
				$query = "SELECT COUNT(*) FROM students_groups_students LEFT JOIN Abre_Students ON students_groups_students.Student_ID = Abre_Students.StudentId WHERE Abre_Students.IEP = 'Y' AND students_groups_students.StaffId = '$StaffId'";
				$dbreturn = $db->query($query);
				$resultsrow = $dbreturn->fetch_assoc();
				$IEPCount_Groups = $resultsrow["COUNT(*)"];

				//Total IEP Students
				$IEPCount = $IEPCount_Courses + $IEPCount_Groups;

				//Get Gifted Students from courses
				$query = "SELECT COUNT(*) FROM (SELECT * FROM Abre_StudentSchedules WHERE StaffId = '$StaffId' AND (TermCode = '$CurrentSememester' OR TermCode = 'Year') AND StudentGiftedStatus = 'Y' GROUP BY StudentID) AS Result";
				$dbreturn = $db->query($query);
				$resultsrow = $dbreturn->fetch_assoc();
				$GiftedCount_Courses = $resultsrow["COUNT(*)"];

				//Get Students from Groups that are Gifted
				$query = "SELECT COUNT(*) FROM students_groups_students LEFT JOIN Abre_Students ON students_groups_students.Student_ID = Abre_Students.StudentId WHERE Abre_Students.Gifted = 'Y' AND students_groups_students.StaffId = '$StaffId'";
				$dbreturn = $db->query($query);
				$resultsrow = $dbreturn->fetch_assoc();
				$GiftedCount_Groups = $resultsrow["COUNT(*)"];

				//Total Gifted Students
				$GiftedCount = $GiftedCount_Courses + $GiftedCount_Groups;

				//Get ELL Students from courses
				$query = "SELECT COUNT(*) FROM (SELECT * FROM Abre_StudentSchedules WHERE StaffId = '$StaffId' AND (TermCode = '$CurrentSememester' OR TermCode = 'Year') AND StudentELLStatus != 'N' GROUP BY StudentID) AS Result";
				$dbreturn = $db->query($query);
				$resultsrow = $dbreturn->fetch_assoc();
				$ELLCount_Courses = $resultsrow["COUNT(*)"];

				//Get Students from Groups that are ELL
				$query = "SELECT COUNT(*) FROM students_groups_students LEFT JOIN Abre_Students ON students_groups_students.Student_ID = Abre_Students.StudentId WHERE Abre_Students.ELL != 'N' AND students_groups_students.StaffId = '$StaffId'";
				$dbreturn = $db->query($query);
				$resultsrow = $dbreturn->fetch_assoc();
				$ELLCount_Groups = $resultsrow["COUNT(*)"];

				//Total Gifted Students
				$ELLCount = $ELLCount_Courses + $ELLCount_Groups;

				//Display Dashboard
				echo "<div class='row'>";

					//Left Div
					echo "<div class='col l8 s12' style='margin-bottom:20px;'>";


						//Search
						echo "<div class='row'>";
							echo "<div class='col s12'>";
							echo "<nav style='background-color:"; echo getSiteColor(); echo ";'>";
						    	echo "<div class='nav-wrapper'>";
									echo "<div class='input-field'>";
										echo "<input id='studentssearchquery' type='search' placeholder='Student Search' autocomplete='off'>";
										echo "<label class='label-icon' for='studentssearchquery'><i class='material-icons'>search</i></label>";
									echo "</div>";
								echo "</div>";
							echo "</nav>";
							echo "</div>";
						echo "</div>";

						echo "<div id='searchloader' style='display:none'>";
							echo "<div class='row'><div class='col s12'><div id='p2' class='mdl-progress mdl-js-progress mdl-progress__indeterminate landingloadergrid' style='width:100%;'></div></div></div>";
						echo "</div>";

						echo "<div style='display:none' id='searchresults'></div>";

						//Overview cards
						echo "<div class='row'>";
						echo "<div class='col m6 s12'><div class='mdl-card mdl-shadow--2dp' style='width:100%; color:#fff; padding-top:45px; margin-bottom:10px; background-color:"; echo getSiteColor(); echo "'>";
							echo "<span class='center-align truncate' style='font-size:70px; line-height:80px;'>$StudentCount</span>";
							echo "<span class='center-align truncate'>Total Students</span>";
						echo "</div></div>";
						echo "<div class='col m6 s12'><div class='mdl-card mdl-shadow--2dp' style='width:100%; color:#fff; padding-top:45px; margin-bottom:10px; background-color:"; echo getSiteColor(); echo "'>";
							echo "<span class='center-align truncate' style='font-size:70px; line-height:80px;'>$IEPCount</span>";
							echo "<span class='center-align truncate'>IEP Students</span>";
						echo "</div></div>";
						echo "<div class='col m6 s12'><div class='mdl-card mdl-shadow--2dp' style='width:100%; color:#fff; padding-top:45px; margin-bottom:10px; background-color:"; echo getSiteColor(); echo "'>";
							echo "<span class='center-align truncate' style='font-size:70px; line-height:80px;'>$GiftedCount</span>";
							echo "<span class='center-align truncate'>Gifted Students</span>";
						echo "</div></div>";
						echo "<div class='col m6 s12'><div class='mdl-card mdl-shadow--2dp' style='width:100%; color:#fff; padding-top:45px; margin-bottom:10px; background-color:"; echo getSiteColor(); echo "'>";
							echo "<span class='center-align truncate' style='font-size:70px; line-height:80px;'>$ELLCount</span>";
							echo "<span class='center-align truncate'>ELL Students</span>";
						echo "</div></div>";
						echo "</div>";

						//Downloads
						echo "<div class='row'><div class='col s12'><div class='mdl-shadow--2dp' style='background-color:#fff; padding:10px 30px 20px 30px'><h5 style='padding:5px;'>Downloads</h5><table class='bordered'><tbody>";
							echo "<thead><tr><th>Report</th><th class='center-align'>Courses</th><th class='center-align'>Groups</th></tr></thead>";
							echo "<tr>";
								echo "<td>Student Roster</td><td width='100px' class='center-align'><a href='/modules/".basename(__DIR__)."/downloads/studentroster_courses.php' class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600'><i class='material-icons'>file_download</i></td><td width='100px' class='center-align'><a href='/modules/".basename(__DIR__)."/downloads/studentroster_groups.php' class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600'><i class='material-icons'>file_download</i></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td>Parent Contacts</td><td width='100px' class='center-align'><a href='/modules/".basename(__DIR__)."/downloads/parentcontacts_courses.php' class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600'><i class='material-icons'>file_download</i></td><td width='100px' class='center-align'><a href='/modules/".basename(__DIR__)."/downloads/parentcontacts_groups.php' class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600'><i class='material-icons'>file_download</i></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td>State Assessments</td><td width='100px' class='center-align'><a href='/modules/".basename(__DIR__)."/downloads/stateassessments_courses.php' class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600'><i class='material-icons'>file_download</i></td><td width='100px' class='center-align'><a href='/modules/".basename(__DIR__)."/downloads/stateassessments_groups.php' class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600'><i class='material-icons'>file_download</i></td>";
							echo "</tr>";
						echo "</tbody></table></div></div></div>";

					echo "</div>";


					//Right Div
					echo "<div class='col l4 s12'>";

						//Get users courses
						$query = "SELECT CourseCode, SchoolCode, SectionCode, CourseName, Period FROM Abre_StaffSchedules WHERE StaffID = '$StaffId' AND (TermCode = '$CurrentSememester' OR TermCode = 'Year') ORDER BY Period";
						$dbreturn = databasequery($query);
						$totalcourses = count($dbreturn);
						$counter = 0;
						foreach($dbreturn as $value){
							$counter++;
							if($counter == 1){ echo "<div class='row'><div class='col s12'><div class='mdl-shadow--2dp' style='background-color:#fff; padding:10px 30px 20px 30px'><h5 style='padding:5px;'>My Courses</h5><table class='bordered'><tbody>"; }
							$CourseCode = $value['CourseCode'];
							$SchoolCode = $value['SchoolCode'];
							$SectionCode = $value['SectionCode'];
							$CourseName = $value['CourseName'];
							$Period = $value['Period'];
							$firstCharacter = $CourseName[0];

							//Get the Name of the course
							echo "<tr class='classlink pointer' data='#students/$CourseCode/$SectionCode'>";
								echo "<td width='50px'><div style='padding:5px; text-align:center; background-color:"; echo getSiteColor(); echo "; color:#fff; width:30px; height:30px; border-radius: 15px;'>$Period</div></td>";
								echo "<td>$CourseName</td>";
							echo "</tr>";
						}
						if($counter!=0){ echo "</tbody></table></div></div></div>"; }

						//Get counselors students
						$query = "SELECT CounselorStaffId FROM Abre_Student_Counselors WHERE CounselorStaffId = '$StaffId' LIMIT 1";
						$dbreturn = databasequery($query);
						$totalcounselor = count($dbreturn);
						$counter = 0;
						foreach($dbreturn as $value){
							$counter++;
							if($counter == 1){ echo "<div class='row'><div class='col s12'><div class='mdl-shadow--2dp' style='background-color:#fff; padding:10px 30px 20px 30px'><h5 style='padding:5px;'>Counseling</h5><table class='bordered'><tbody>"; }
							$CounselorStaffId = $value['CounselorStaffId'];

							//Get the Name of the counselors students
							echo "<tr class='classlink pointer' data='#students/counseling/$CounselorStaffId'>";
								echo "<td width='50px'><div style='padding:5px; text-align:center; background-color:"; echo getSiteColor(); echo "; color:#fff; width:30px; height:30px; border-radius: 15px;'>C</div></td>";
								echo "<td>My Students</td>";
							echo "</tr>";
						}
						if($counter != 0){ echo "</tbody></table></div></div></div>"; }

						//Get users groups
						$query = "SELECT Name, ID FROM students_groups WHERE StaffId = '$StaffId'";
						$dbreturn = databasequery($query);
						$counter = 0;
						foreach($dbreturn as $value){
							$counter++;
							if($counter == 1){ echo "<div class='row'><div class='col s12'><div class='mdl-shadow--2dp' style='background-color:#fff; padding:10px 30px 20px 30px'><h5 style='padding:5px;'>My Groups</h5><table class='bordered'><tbody>"; }
							$GroupName = $value['Name'];
							$GroupName_Encoded = base64_encode($GroupName);
							$GroupID = $value['ID'];
							$firstCharacter = $GroupName[0];

							echo "<tr>";
								echo "<td width='50px' class='classlink pointer' data='#students/group/$GroupID'><div style='padding:5px; text-align:center; background-color:"; echo getSiteColor(); echo "; color:#fff; width:30px; height:30px; border-radius: 15px;'>$firstCharacter</div></td>";
								echo "<td class='classlink pointer' data='#students/group/$GroupID'>$GroupName</td>";
								echo "<td width='30px'><a class='mdl-button mdl-js-button mdl-button--icon'><i class='editgroup material-icons mdl-color-text--grey-600' style='color:"; echo getSiteColor(); echo ";' data-groupname='$GroupName_Encoded' data-groupid='$GroupID' href='#'>mode_edit</i></a></td>";
							echo "</tr>";
						}
						if($counter != 0){ echo "</tbody></table></div></div></div>"; }

					echo "</div>";

				echo "</div>";

				include "button_group.php";

			}
		}
	}
?>


<script>

	$(function()
	{

    	$('.modal-studentgroup').leanModal({
	    	in_duration: 0,
				out_duration: 0,
	    	ready: function()
	    	{
		    	$('.modal-content').scrollTop(0);
					$("#group_name").focus();

			   	//Load the Search Modal
					<?php if(GetStaffID($_SESSION['useremail']) != "ABREDEMO"){ ?>
				    $.post("modules/<?php echo basename(__DIR__); ?>/group_process.php", function(data) {
							$(".modal-content #group_id").val(data.groupid);
						});
					<?php }?>
				$(".modal-content #group_name").val('');
				$(".modal-footer #deletebutton").css("display", "none");
		   },
	    	complete: function() { $("#content_holder").load( "modules/<?php echo basename(__DIR__); ?>/home.php"); }
	   	});

	  	//Make the Likes clickable
		$( ".editgroup" ).unbind().click(function()
		{
			var Group_ID = $(this).data('groupid');
			var Group_Name = $(this).data('groupname');
			Group_Name_Decoded = atob(Group_Name);
			$(".modal-content #group_id").val(Group_ID);
			var Group_Name = $(this).data('groupname');
			Group_Name_Decoded = atob(Group_Name);
			$(".modal-content #group_name").val(Group_Name_Decoded);
			$(".modal-footer #deletebutton").css("display", "block");

			//Load the Roster Modal
			$("#currentRoster").load( "modules/<?php echo basename(__DIR__); ?>/group_roster.php?id="+Group_ID);

			$('#studentgroup').openModal({ in_duration: 0, out_duration: 0, ready: function()
			{
				$('.modal-content').scrollTop(0);
				$("#group_name").focus();
			},
			complete: function() { $("#content_holder").load( "modules/<?php echo basename(__DIR__); ?>/home.php"); }
			});
		});

	  	//Make the Likes clickable
		$( ".classlink" ).unbind().click(function()
		{
			window.open($(this).attr("data"), '_self');
		});

		//Search Delay
		var delay = (function(){
		  var timer = 0;
		  return function(callback, ms){
		    clearTimeout (timer);
		    timer = setTimeout(callback, ms);
		  };
		})();

    	//Student Search/Filter
    	$("#studentssearchquery").keyup(function()
    	{
	    	mdlregister();
	    	$("#searchresults").hide();
				$("#searchloader").show();

	    	delay(function()
	    	{
		    	var studentsearch = $('#studentssearchquery').val();
		    	studentsearch = btoa(studentsearch);

				$("#searchresults").load('modules/<?php echo basename(__DIR__); ?>/search.php?query='+studentsearch, function()
				{
					$("#searchloader").hide();
					$("#searchresults").show();
				});
			}, 500 );
		});

	});

</script>
