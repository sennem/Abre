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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');
	require_once('permissions.php');

	if($pagerestrictions=="")
	{

		//Get Variables Passed to Page
		if(isset($_GET["groupid"])){ $GroupID=htmlspecialchars($_GET["groupid"], ENT_QUOTES); }else{ $GroupID=""; }
		if(isset($_GET["courseid"])){ $CourseCode=htmlspecialchars($_GET["courseid"], ENT_QUOTES); }else{ $CourseCode=""; }
		if(isset($_GET["section"])){ $SectionCode=htmlspecialchars($_GET["section"], ENT_QUOTES); }else{ $SectionCode=""; }
		if(isset($_GET["counselingid"])){ $CounselingID=htmlspecialchars($_GET["counselingid"], ENT_QUOTES); }else{ $CounselingID=""; }

		$CurrentSememester=GetCurrentSemester();

		if($GroupID!="")
		{

			echo "<div style='position: absolute; top:0; bottom:0; left:0; right:0; overflow-y: hidden;'>";

				//Student Roster
				echo "<div id='studentroster' style='position: absolute; top:0; bottom:0; width:300px; overflow-y: scroll; background-color:"; echo getSiteColor(); echo ";'>";
					echo "<div id='overviewpage' class='truncate pointer' data-groupid='$GroupID' style='padding:2px 30px 2px 30px; color:#fff; background-color:#000;'><h6>Class Overview</h6></div>";
					$query = "SELECT Student_ID FROM students_groups_students WHERE Group_ID='$GroupID'";
					$dbreturn = databasequery($query);
					foreach ($dbreturn as $value)
					{
						$StudentId=htmlspecialchars($value["Student_ID"], ENT_QUOTES);

						//Find the Students Name
						$query2 = "SELECT FirstName, LastName FROM Abre_Students WHERE StudentId='$StudentId' LIMIT 1";
						$dbreturn2 = databasequery($query2);
						foreach ($dbreturn2 as $value2)
						{
							$FirstName=htmlspecialchars($value2["FirstName"], ENT_QUOTES);
							$LastName=htmlspecialchars($value2["LastName"], ENT_QUOTES);
						}

						$StudentPicture="/modules/".basename(__DIR__)."/image.php?student=$StudentId";
						echo "<div class='studentpage pointer' data-studentid='$StudentId' style='padding:2px 30px 2px 30px;'>";
							echo "<div style='float:left; padding:12px 20px 0 0;'><img src='$StudentPicture' class='circle demoimage' style='width:40px; height:40px;'></div>";
							echo "<div style='width:220px; color:#fff;'><h6 class='truncate demotext_light'>$FirstName $LastName</h6></div>";
						echo "</div>";
					}
				echo "</div>";

				//Dashboard Data
				echo "<div id='overview' style='position:absolute; width: calc(100% - 305px); left:305px; top:0; bottom:0; right:0; overflow-y: scroll; padding:20px;'>";
					echo "<div id='p2' class='mdl-progress mdl-js-progress mdl-progress__indeterminate landingloader' style='width:100%;'></div>";
					echo "<div id='dashboard'></div>";
				echo "</div>";

			echo "</div>";

			?>
			<script>

				//Load the Overview
				var GroupID="<?php echo $GroupID; ?>";
				$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/overview.php?GroupID='+GroupID, function(){ $(".landingloader").hide(); });

						//Load Student Details View
						$(".studentpage").unbind().click(function()
						{
							$("#dashboard").fadeTo(0,0);
							$(".landingloader").show();
							$(".studentpage, #overviewpage").css("background-color", "");
							$(".studentpage, #overviewpage").css("color", "#fff");
							$(this).css("background-color", "#000");
							$(this).css("color", "#fff");
							var Student_ID = $(this).data('studentid');
							$("#studentdetails").html('');
							$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/student.php?Student_ID='+Student_ID, function()
							{
								$(".landingloader").hide();
								$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
								$("#dashboard").fadeTo(0,1);
							});
						});

						//Load the Overview View
						$("#overviewpage").unbind().click(function()
						{
							$("#dashboard").fadeTo(0,0);
							$(".landingloader").show();
							$(".studentpage").css("background-color", "");
							$(".studentpage").css("color", "#fff");
							$(this).css("background-color", "#000");
							$(this).css("color", "#fff");
							$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/overview.php?GroupID='+GroupID, function()
							{
								$(".landingloader").hide();
								$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
								$("#dashboard").fadeTo(0,1);
							});
						});

			</script>
			<?php

		}


		if($CourseCode!="")
		{

			//Get the StaffID of the Teacher
			$StaffId=GetStaffID($_SESSION['useremail']);
			echo "<div style='position: absolute; top:0; bottom:0; left:0; right:0; overflow-y: hidden;'>";

				//Student Roster
				echo "<div id='studentroster' style='position: absolute; top:0; bottom:0; width:300px; overflow-y: scroll; background-color:"; echo getSiteColor(); echo ";'>";
					echo "<div id='overviewpage' class='truncate pointer' data-coursecode='$CourseCode' data-sectioncode='$SectionCode' style='padding:2px 30px 2px 30px; color:#fff; background-color:#000;'><h6>Class Overview</h6></div>";

						$query = "SELECT StudentID, FirstName, LastName FROM Abre_StudentSchedules WHERE CourseCode='$CourseCode' AND SectionCode='$SectionCode' AND StaffId='$StaffId' AND (TermCode='$CurrentSememester' OR TermCode='Year') GROUP BY StudentID ORDER BY LastName";
						$dbreturn = databasequery($query);
						foreach ($dbreturn as $value)
						{
							$StudentID=htmlspecialchars($value["StudentID"], ENT_QUOTES);
							$FirstName=htmlspecialchars($value["FirstName"], ENT_QUOTES);
							$LastName=htmlspecialchars($value["LastName"], ENT_QUOTES);

							$StudentPicture="/modules/".basename(__DIR__)."/image.php?student=$StudentID";
							echo "<div class='studentpage pointer' data-studentid='$StudentID' style='padding:2px 30px 2px 30px;'>";
								echo "<div style='float:left; padding:12px 20px 0 0;'><img src='$StudentPicture' class='circle demoimage' style='width:40px; height:40px;'></div>";
								echo "<div style='width:220px; color:#fff;'><h6 class='truncate demotext_light'>$FirstName $LastName</h6></div>";
							echo "</div>";

						}
					echo "</div>";

					//Dashboard Data
					echo "<div id='overview' style='position:absolute; width: calc(100% - 305px); left:305px; top:0; bottom:0; right:0; overflow-y: scroll; padding:20px;'>";
						echo "<div id='p2' class='mdl-progress mdl-js-progress mdl-progress__indeterminate landingloader' style='width:100%;'></div>";
						echo "<div id='dashboard'></div>";
					echo "</div>";

				echo "</div>";

				?>
					<script>

						//Load the Overview
						var OrigionalCourseCode="<?php echo $CourseCode; ?>";
						var OrigionalSectionCode="<?php echo $SectionCode; ?>";
						$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/overview.php?CourseCode='+OrigionalCourseCode+'&SectionCode='+OrigionalSectionCode, function(){ $(".landingloader").hide(); });

						//Load Student Details View
						$(".studentpage").unbind().click(function()
						{
							$("#dashboard").fadeTo(0,0);
							$(".landingloader").show();
							$(".studentpage, #overviewpage").css("background-color", "");
							$(".studentpage, #overviewpage").css("color", "#fff");
							$(this).css("background-color", "#000");
							$(this).css("color", "#fff");
							var Student_ID = $(this).data('studentid');
							$("#studentdetails").html('');
							$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/student.php?Student_ID='+Student_ID, function()
							{
								$(".landingloader").hide();
								$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
								$("#dashboard").fadeTo(0,1);
							});
						});

						//Load the Overview View
						$("#overviewpage").unbind().click(function()
						{
							$("#dashboard").fadeTo(0,0);
							$(".landingloader").show();
							$(".studentpage").css("background-color", "");
							$(".studentpage").css("color", "#fff");
							$(this).css("background-color", "#000");
							$(this).css("color", "#fff");
							var CourseCode = $(this).data('coursecode');
							var SectionCode = $(this).data('sectioncode');
							$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/overview.php?CourseCode='+CourseCode+'&SectionCode='+SectionCode, function()
							{
								$(".landingloader").hide(); $("#dashboard").fadeTo(0,1);
							});
						});

					</script>
				<?php

		}

		if($CounselingID!="")
		{

			//Get the StaffID of the Teacher
			$StaffId=$CounselingID;
			echo "<div style='position: absolute; top:0; bottom:0; left:0; right:0; overflow-y: hidden;'>";

				//Student Roster
				echo "<div id='studentroster' style='position: absolute; top:0; bottom:0; width:300px; overflow-y: scroll; background-color:"; echo getSiteColor(); echo ";'>";
					echo "<div id='overviewpage' class='truncate pointer' style='padding:2px 30px 2px 30px; color:#fff; background-color:#000;'><h6>Class Overview</h6></div>";

						$query = "SELECT StudentId, StudentFirstName, StudentLastName FROM Abre_Student_Counselors WHERE CounselorStaffId='$StaffId' ORDER BY StudentLastName";
						$dbreturn = databasequery($query);
						foreach ($dbreturn as $value)
						{
							$StudentID=htmlspecialchars($value["StudentId"], ENT_QUOTES);
							$FirstName=htmlspecialchars($value["StudentFirstName"], ENT_QUOTES);
							$LastName=htmlspecialchars($value["StudentLastName"], ENT_QUOTES);

							$StudentPicture="/modules/".basename(__DIR__)."/image.php?student=$StudentID";
							echo "<div class='studentpage pointer' data-studentid='$StudentID' style='padding:2px 30px 2px 30px;'>";
								echo "<div style='float:left; padding:12px 20px 0 0;'><img src='$StudentPicture' class='circle demoimage' style='width:40px; height:40px;'></div>";
								echo "<div style='width:220px; color:#fff;'><h6 class='truncate demotext_light'>$FirstName $LastName</h6></div>";
							echo "</div>";

						}
					echo "</div>";

					//Dashboard Data
					echo "<div id='overview' style='position:absolute; width: calc(100% - 305px); left:305px; top:0; bottom:0; right:0; overflow-y: scroll; padding:20px;'>";
						echo "<div id='p2' class='mdl-progress mdl-js-progress mdl-progress__indeterminate landingloader' style='width:100%;'></div>";
						echo "<div id='dashboard'></div>";
					echo "</div>";

				echo "</div>";

				?>
					<script>

						//Load the Overview
						var OrigionalCounselingID="<?php echo $StaffId; ?>";
						$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/overview.php?CounselingID='+OrigionalCounselingID, function(){ $(".landingloader").hide(); });

						//Load Student Details View
						$(".studentpage").unbind().click(function()
						{
							$("#dashboard").fadeTo(0,0);
							$(".landingloader").show();
							$(".studentpage, #overviewpage").css("background-color", "");
							$(".studentpage, #overviewpage").css("color", "#fff");
							$(this).css("background-color", "#000");
							$(this).css("color", "#fff");
							var Student_ID = $(this).data('studentid');
							$("#studentdetails").html('');
							$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/student.php?Student_ID='+Student_ID, function()
							{
								$(".landingloader").hide();
								$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
								$("#dashboard").fadeTo(0,1);
							});
						});

						//Load the Overview View
						$("#overviewpage").unbind().click(function()
						{
							$("#dashboard").fadeTo(0,0);
							$(".landingloader").show();
							$(".studentpage").css("background-color", "");
							$(".studentpage").css("color", "#fff");
							$(this).css("background-color", "#000");
							$(this).css("color", "#fff");
							$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/overview.php?CounselingID='+OrigionalCounselingID, function()
							{
								$(".landingloader").hide(); $("#dashboard").fadeTo(0,1);
							});
						});

					</script>
				<?php

		}


	//End Page Restrictions
	}
?>

<script>

	//Check Window Width
	if ($(window).width() < 600){ smallView(); }
	$(window).resize(function(){ if ($(window).width() < 600){ smallView(); } if ($(window).width() >= 600){ largeView(); } });
	function smallView()
	{
		$("#studentroster").css("display", "none");
		$("#overview").css("width", "100%");
		$("#overview").css("left", "0");
	}
	function largeView()
	{
		$("#studentroster").css("display", "block");
		$("#overview").css("width", "calc(100% - 305px)");
		$("#overview").css("left", "305px");
	}

</script>
