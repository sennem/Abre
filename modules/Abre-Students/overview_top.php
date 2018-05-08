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
	require_once('functions.php');
	require_once('permissions.php');

	if($pagerestrictions == ""){

		$StaffId = GetStaffID($_SESSION['useremail']);
		$CurrentSememester = GetCurrentSemester();

		if($GroupID != ""){
			//Get Total Students
			$query = "SELECT COUNT(*) FROM students_groups_students WHERE StaffId = '$StaffId' AND Group_ID = '$GroupID'";
			$dbreturn = $db->query($query);
			$resultrow = $dbreturn->fetch_assoc();
			$StudentCount = $resultrow["COUNT(*)"];

			//Get Students on IEP
			$query = "SELECT COUNT(*) FROM students_groups_students LEFT JOIN Abre_Students ON students_groups_students.Student_ID = Abre_Students.StudentId WHERE Abre_Students.IEP = 'Y' AND students_groups_students.StaffId = '$StaffId' AND Group_ID = '$GroupID'";
			$dbreturn = $db->query($query);
			$resultrow = $dbreturn->fetch_assoc();
			$IEPCount = $resultrow["COUNT(*)"];

			//Get Gifted Students
			$query = "SELECT COUNT(*) FROM students_groups_students LEFT JOIN Abre_Students ON students_groups_students.Student_ID = Abre_Students.StudentId WHERE Abre_Students.Gifted = 'Y' AND students_groups_students.StaffId = '$StaffId' AND Group_ID = '$GroupID'";
			$dbreturn = $db->query($query);
			$resultrow = $dbreturn->fetch_assoc();
			$GiftedCount = $resultrow["COUNT(*)"];

			//Get ELL Students
			$query = "SELECT COUNT(*) FROM students_groups_students LEFT JOIN Abre_Students ON students_groups_students.Student_ID = Abre_Students.StudentId WHERE Abre_Students.ELL != 'N' AND students_groups_students.StaffId = '$StaffId' AND Group_ID = '$GroupID'";
			$dbreturn = $db->query($query);
			$resultrow = $dbreturn->fetch_assoc();
			$ELLCount = $resultrow["COUNT(*)"];

		}
		if($CourseCode != ""){

			//Get Total Students
			$query = "SELECT COUNT(DISTINCT StudentID) as count FROM Abre_StudentSchedules WHERE StaffId = '$StaffId' AND CourseCode = '$CourseCode' AND SectionCode = '$SectionCode' AND (TermCode = '$CurrentSememester' OR TermCode = 'Year')";
			$dbreturn = $db->query($query);
			$resultrow = $dbreturn->fetch_assoc();
			$StudentCount = $resultrow["count"];

			//Get Students on IEP
			$query = "SELECT COUNT(DISTINCT StudentID) as count FROM Abre_StudentSchedules WHERE StaffId = '$StaffId' AND CourseCode = '$CourseCode' AND SectionCode = '$SectionCode' AND (TermCode = '$CurrentSememester' OR TermCode = 'Year') AND StudentIEPStatus = 'Y'";
			$dbreturn = $db->query($query);
			$resultrow = $dbreturn->fetch_assoc();
			$IEPCount = $resultrow["count"];

			//Get Gifted Students
			$query = "SELECT COUNT(DISTINCT StudentID) as count FROM Abre_StudentSchedules WHERE StaffId = '$StaffId' AND CourseCode = '$CourseCode' AND SectionCode = '$SectionCode' AND (TermCode = '$CurrentSememester' OR TermCode = 'Year') AND StudentGiftedStatus = 'Y'";
			$dbreturn = $db->query($query);
			$resultrow = $dbreturn->fetch_assoc();
			$GiftedCount = $resultrow["count"];

			//Get ELL Students
			$query = "SELECT COUNT(DISTINCT StudentID) as count FROM Abre_StudentSchedules WHERE StaffId = '$StaffId' AND CourseCode = '$CourseCode' AND SectionCode = '$SectionCode' AND (TermCode = '$CurrentSememester' OR TermCode = 'Year') AND StudentELLStatus != 'N'";
			$dbreturn = $db->query($query);
			$resultrow = $dbreturn->fetch_assoc();
			$ELLCount = $resultrow["count"];

		}
		if($CounselingID != ""){

			//Get Total Students
			$query = "SELECT COUNT(*) FROM Abre_Student_Counselors WHERE CounselorStaffId = '$StaffId'";
			$dbreturn = $db->query($query);
			$resultrow = $dbreturn->fetch_assoc();
			$StudentCount = $resultrow["COUNT(*)"];

			//Get Students on IEP
			$query = "SELECT COUNT(*) FROM Abre_Student_Counselors WHERE CounselorStaffId = '$StaffId' AND StudentIEPStatus = 'Y'";
			$dbreturn = $db->query($query);
			$resultrow = $dbreturn->fetch_assoc();
			$IEPCount = $resultrow["COUNT(*)"];

			//Get Gifted Students
			$query = "SELECT COUNT(*) FROM Abre_Student_Counselors WHERE CounselorStaffId = '$StaffId' AND StudentGiftedStatus = 'Y'";
			$dbreturn = $db->query($query);
			$resultrow = $dbreturn->fetch_assoc();
			$GiftedCount = $resultrow["COUNT(*)"];

			//Get ELL Students
			$query = "SELECT COUNT(*) FROM Abre_Student_Counselors WHERE CounselorStaffId = '$StaffId' AND StudentELLStatus != 'N'";
			$dbreturn = $db->query($query);
			$resultrow = $dbreturn->fetch_assoc();
			$ELLCount = $resultrow["COUNT(*)"];

		}

			$NOTiep = $StudentCount-$IEPCount;
			$NOTgifted = $StudentCount-$GiftedCount;
			$NOTell = $StudentCount-$ELLCount;

			//Load the Overview
			echo "<div class='col s12 mdl-shadow--2dp' style='background-color:#fff; padding-top:10px;'>";
				if($IEPCount!=0)
				{
					echo "<div id='iepstudents' data-coursecode='$CourseCode' data-sectioncode='$SectionCode' style='min-width:200px; float:left;' class='col l4 m6 s12 center-align pointer'>";
				}
				else
				{
					echo "<div style='min-width:200px; float:left;' class='col l4 m6 s12 center-align'>";
				}
					echo "<div class='row'><h6 style='margin-bottom:-15px;'>IEP Students</h6></div>";
					echo "<div class='row' style='position:relative; width:100%;'>";
						echo "<div style='position:absolute; width:100%; font-size:65px; top:80px; z-index:1000; font-weight:500; color:"; echo getSiteColor(); echo ";'>$IEPCount</div>";
						echo "<div id='IEPChart' style='width:180px; height:180px; margin: 0 auto;'></div>";
					echo "</div>";
				echo "</div>";
				if($GiftedCount!=0)
				{
					echo "<div id='giftedstudents' data-coursecode='$CourseCode' data-sectioncode='$SectionCode' style='min-width:200px; float:left;' class='col l4 m6 s12 center-align pointer'>";
				}
				else
				{
					echo "<div style='min-width:200px; float:left;' class='col l4 m6 s12 center-align'>";
				}
					echo "<div class='row'><h6 style='margin-bottom:-15px;'>Gifted Students</h6></div>";
					echo "<div class='row' style='position:relative; width:100%;'>";
						echo "<div style='position:absolute; width:100%; font-size:65px; top:80px; z-index:1000; font-weight:500; color:"; echo getSiteColor(); echo ";'>$GiftedCount</div>";
						echo "<div id='GiftedChart' style='width:180px; height:180px; margin: 0 auto;'></div>";
					echo "</div>";
				echo "</div>";
				if($ELLCount!=0)
				{
					echo "<div id='ellstudents' data-coursecode='$CourseCode' data-sectioncode='$SectionCode' style='min-width:200px; float:left;' class='col l4 m6 s12 center-align pointer'>";
				}
				else
				{
					echo "<div style='min-width:200px; float:left;' class='col l4 m6 s12 center-align'>";
				}
					echo "<div class='row'><h6 style='margin-bottom:-15px;'>ELL Students</h6></div>";
					echo "<div class='row' style='position:relative; width:100%;'>";
						echo "<div style='position:absolute; width:100%; font-size:65px; top:80px; z-index:1000; font-weight:500; color:"; echo getSiteColor(); echo ";'>$ELLCount</div>";
						echo "<div id='ELLChart' style='width:180px; height:180px; margin: 0 auto;'></div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
	}
?>

<script>

	$(function()
	{
		<?php
		if($CourseCode!="")
		{
		?>
			//Load the IEP View
			$("#iepstudents").unbind().click(function()
			{
				var CourseCode = $(this).data('coursecode');
				var SectionCode = $(this).data('sectioncode');
				$("#dashboard").fadeTo(0,0);
				$(".landingloader").show();
				$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/students_iep.php?CourseCode='+CourseCode+'&SectionCode='+SectionCode, function()
				{
					$(".landingloader").hide();
					$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
					$("#dashboard").fadeTo(0,1);
				});
			});

			//Load the Gifted View
			$("#giftedstudents").unbind().click(function()
			{
				var CourseCode = $(this).data('coursecode');
				var SectionCode = $(this).data('sectioncode');
				$("#dashboard").fadeTo(0,0);
				$(".landingloader").show();
				$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/students_gifted.php?CourseCode='+CourseCode+'&SectionCode='+SectionCode, function()
				{
					$(".landingloader").hide();
					$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
					$("#dashboard").fadeTo(0,1);
				});
			});

			//Load the ELL View
			$("#ellstudents").unbind().click(function()
			{
				var CourseCode = $(this).data('coursecode');
				var SectionCode = $(this).data('sectioncode');
				$("#dashboard").fadeTo(0,0);
				$(".landingloader").show();
				$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/students_ell.php?CourseCode='+CourseCode+'&SectionCode='+SectionCode, function()
				{
					$(".landingloader").hide();
					$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
					$("#dashboard").fadeTo(0,1);
				});
			});
		<?php
		}
		if($GroupID!="")
		{
		?>
			//Load the IEP View
			$("#iepstudents").unbind().click(function()
			{
				$("#dashboard").fadeTo(0,0);
				$(".landingloader").show();
				$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/students_iep.php?GroupID='+GroupID, function()
				{
					$(".landingloader").hide();
					$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
					$("#dashboard").fadeTo(0,1);
				});
			});

			//Load the Gifted View
			$("#giftedstudents").unbind().click(function()
			{
				$("#dashboard").fadeTo(0,0);
				$(".landingloader").show();
				$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/students_gifted.php?GroupID='+GroupID, function()
				{
					$(".landingloader").hide();
					$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
					$("#dashboard").fadeTo(0,1);
				});
			});

			//Load the ELL View
			$("#ellstudents").unbind().click(function()
			{
				$("#dashboard").fadeTo(0,0);
				$(".landingloader").show();
				$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/students_ell.php?GroupID='+GroupID, function()
				{
					$(".landingloader").hide();
					$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
					$("#dashboard").fadeTo(0,1);
				});
			});
		<?php
		}
		if($CounselingID!="")
		{
		?>
			//Load the IEP View
			$("#iepstudents").unbind().click(function()
			{
				$("#dashboard").fadeTo(0,0);
				$(".landingloader").show();
				$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/students_iep.php?CounselingID=<?php echo $StaffId; ?>', function()
				{
					$(".landingloader").hide();
					$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
					$("#dashboard").fadeTo(0,1);
				});
			});

			//Load the Gifted View
			$("#giftedstudents").unbind().click(function()
			{
				$("#dashboard").fadeTo(0,0);
				$(".landingloader").show();
				$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/students_gifted.php?CounselingID=<?php echo $StaffId; ?>', function()
				{
					$(".landingloader").hide();
					$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
					$("#dashboard").fadeTo(0,1);
				});
			});

			//Load the ELL View
			$("#ellstudents").unbind().click(function()
			{
				$("#dashboard").fadeTo(0,0);
				$(".landingloader").show();
				$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/students_ell.php?CounselingID=<?php echo $StaffId; ?>', function()
				{
					$(".landingloader").hide();
					$('.mdl-layout__content, #overview, #dashboard').animate({scrollTop:0}, 0);
					$("#dashboard").fadeTo(0,1);
				});
			});
		<?php
		}
		?>

		google.charts.setOnLoadCallback(IEPChart);
		function IEPChart() {
		        var data = google.visualization.arrayToDataTable([
		          ['', ''],
		          ['', <?php echo $IEPCount; ?>],
		          ['', <?php echo $NOTiep; ?>]
		        ]);
		        var options = {
		          pieHole: 0.8,
		          'tooltip':{ trigger: 'none' },
		          legend: 'none',
		          pieSliceText: "none",
		          colors: ['<?php echo getSiteColor(); ?>', '#e9e9e9'],
		          chartArea:{left:10,top:10,bottom:10,right:10,width:"100%",height:"100%"}
		        };
		        var chart = new google.visualization.PieChart(document.getElementById('IEPChart'));
		        chart.draw(data, options);
		}

		google.charts.setOnLoadCallback(GiftedChart);
		function GiftedChart() {
		        var data = google.visualization.arrayToDataTable([
		          ['', ''],
		          ['', <?php echo $GiftedCount; ?>],
		          ['', <?php echo $NOTgifted; ?>]
		        ]);
		        var options = {
		          pieHole: 0.8,
		          'tooltip':{ trigger: 'none' },
		          legend: 'none',
		          pieSliceText: "none",
		          colors: ['<?php echo getSiteColor(); ?>', '#e9e9e9'],
		          chartArea:{left:10,top:10,bottom:10,right:10,width:"100%",height:"100%"}
		        };
		        var chart = new google.visualization.PieChart(document.getElementById('GiftedChart'));
		        chart.draw(data, options);
		}

		google.charts.setOnLoadCallback(ELLChart);
		function ELLChart() {
		        var data = google.visualization.arrayToDataTable([
		          ['', ''],
		          ['', <?php echo $ELLCount; ?>],
		          ['', <?php echo $NOTell; ?>]
		        ]);
		        var options = {
		          pieHole: 0.8,
		          'tooltip':{ trigger: 'none' },
		          legend: 'none',
		          pieSliceText: "none",
		          colors: ['<?php echo getSiteColor(); ?>', '#e9e9e9'],
		          chartArea:{left:10,top:10,bottom:10,right:10,width:"100%",height:"100%"}
		        };
		        var chart = new google.visualization.PieChart(document.getElementById('ELLChart'));
		        chart.draw(data, options);
		}

	});

</script>
