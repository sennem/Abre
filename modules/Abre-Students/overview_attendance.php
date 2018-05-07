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

	if($pagerestrictions=="")
	{

		//Date Setup
		$today=date("l");
		$twelvedaysago=date('m/d/Y', strtotime('-12 days'));		$twelvedaysagocount=0;		$twelvedaysagoday=date('l', strtotime('-12 days'));		$twelvedaysagostudents=NULL;
		$elevindaysago=date('m/d/Y', strtotime('-11 days'));		$elevindaysagocount=0;		$elevindaysagoday=date('l', strtotime('-11 days'));		$elevindaysagostudents=NULL;
		$tendaysago=date('m/d/Y', strtotime('-10 days'));			$tendaysagocount=0;			$tendaysagoday=date('l', strtotime('-10 days'));		$tendaysagostudents=NULL;
		$ninedaysago=date('m/d/Y', strtotime('-9 days'));			$ninedaysagocount=0;		$ninedaysagoday=date('l', strtotime('-9 days'));		$ninedaysagostudents=NULL;
		$eightdaysago=date('m/d/Y', strtotime('-8 days'));			$eightdaysagocount=0;		$eightdaysagoday=date('l', strtotime('-8 days'));		$eightdaysagostudents=NULL;
		$sevendaysago=date('m/d/Y', strtotime('-7 days'));			$sevendaysagocount=0;		$sevendaysagoday=date('l', strtotime('-7 days'));		$sevendaysagostudents=NULL;
		$sixdaysago=date('m/d/Y', strtotime('-6 days'));			$sixdaysagocount=0;			$sixdaysagoday=date('l', strtotime('-6 days'));			$sixdaysagostudents=NULL;
		$fivedaysago=date('m/d/Y', strtotime('-5 days'));			$fivedaysagocount=0;		$fivedaysagoday=date('l', strtotime('-5 days'));		$fivedaysagostudents=NULL;
		$fourdaysago=date('m/d/Y', strtotime('-4 days'));			$fourdaysagocount=0;		$fourdaysagoday=date('l', strtotime('-4 days'));		$fourdaysagostudents=NULL;
		$threedaysago=date('m/d/Y', strtotime('-3 days'));			$threedaysagocount=0;		$threedaysagoday=date('l', strtotime('-3 days'));		$threedaysagostudents=NULL;
		$twodaysago=date('m/d/Y', strtotime('-2 days'));			$twodaysagocount=0;			$twodaysagoday=date('l', strtotime('-2 days'));			$twodaysagostudents=NULL;
		$onedayago=date('m/d/Y', strtotime('-1 days'));				$onedayagocount=0;			$onedayagoday=date('l', strtotime('-1 days'));			$onedayagostudents=NULL;

		//Calculate for courses
		if($CourseCode!="")
		{
			$query = "SELECT Abre_StudentSchedules.StudentID, Abre_Attendance.AbsenceDate, Abre_StudentSchedules.FirstName, Abre_StudentSchedules.LastName FROM Abre_StudentSchedules LEFT JOIN Abre_Attendance ON Abre_StudentSchedules.StudentID=Abre_Attendance.StudentID WHERE
						Abre_StudentSchedules.CourseCode='$CourseCode' AND Abre_StudentSchedules.SectionCode='$SectionCode' AND Abre_StudentSchedules.StaffId='$StaffId' AND
						(
							Abre_Attendance.AbsenceDate='$twelvedaysago' OR
							Abre_Attendance.AbsenceDate='$elevindaysago' OR
							Abre_Attendance.AbsenceDate='$tendaysago' OR
							Abre_Attendance.AbsenceDate='$ninedaysago' OR
							Abre_Attendance.AbsenceDate='$eightdaysago' OR
							Abre_Attendance.AbsenceDate='$sevendaysago' OR
							Abre_Attendance.AbsenceDate='$sixdaysago' OR
							Abre_Attendance.AbsenceDate='$fivedaysago' OR
							Abre_Attendance.AbsenceDate='$fourdaysago' OR
							Abre_Attendance.AbsenceDate='$threedaysago' OR
							Abre_Attendance.AbsenceDate='$twodaysago' OR
							Abre_Attendance.AbsenceDate='$onedayago'
						)";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value)
			{
				$Student_ID=$value["StudentID"];
				$AbsenceDate=$value["AbsenceDate"];
				$FirstName=$value["FirstName"];
				$LastName=$value["LastName"];
				$StudentName="$FirstName $LastName";

				if($AbsenceDate==$onedayago){ 		$onedayagocount++; 		$onedayagostudents="$onedayagostudents $StudentName,";			}
				if($AbsenceDate==$twodaysago){ 		$twodaysagocount++; 	$twodaysagostudents="$twodaysagostudents $StudentName,";		}
				if($AbsenceDate==$threedaysago){ 	$threedaysagocount++; 	$threedaysagostudents="$threedaysagostudents $StudentName,";	}
				if($AbsenceDate==$fourdaysago){ 	$fourdaysagocount++; 	$fourdaysagostudents="$fourdaysagostudents $StudentName,";		}
				if($AbsenceDate==$fivedaysago){ 	$fivedaysagocount++; 	$fivedaysagostudents="$fivedaysagostudents $StudentName,";		}
				if($AbsenceDate==$sixdaysago){ 		$sixdaysagocount++; 	$sixdaysagostudents="$sixdaysagostudents $StudentName,";		}
				if($AbsenceDate==$sevendaysago){ 	$sevendaysagocount++; 	$sevendaysagostudents="$sevendaysagostudents $StudentName,";	}
				if($AbsenceDate==$eightdaysago){ 	$eightdaysagocount++; 	$eightdaysagostudents="$eightdaysagostudents $StudentName,";	}
				if($AbsenceDate==$ninedaysago){ 	$ninedaysagocount++; 	$ninedaysagostudents="$ninedaysagostudents $StudentName,";		}
				if($AbsenceDate==$tendaysago){ 		$tendaysagocount++; 	$tendaysagostudents="$tendaysagostudents $StudentName,";		}
				if($AbsenceDate==$elevindaysago){ 	$elevindaysagocount++; 	$elevindaysagostudents="$elevindaysagostudents $StudentName,";	}
				if($AbsenceDate==$twelvedaysago){ 	$twelvedaysagocount++; 	$twelvedaysagostudents="$twelvedaysagostudents $StudentName,";	}
			}

		}

		if($GroupID!="")
		{

			$query = "SELECT StudentID, AbsenceDate FROM students_groups_students LEFT JOIN Abre_Attendance ON students_groups_students.Student_ID=Abre_Attendance.StudentID WHERE
						students_groups_students.Group_ID='$GroupID' AND students_groups_students.StaffId='$StaffId' AND
						(
							Abre_Attendance.AbsenceDate='$twelvedaysago' OR
							Abre_Attendance.AbsenceDate='$elevindaysago' OR
							Abre_Attendance.AbsenceDate='$tendaysago' OR
							Abre_Attendance.AbsenceDate='$ninedaysago' OR
							Abre_Attendance.AbsenceDate='$eightdaysago' OR
							Abre_Attendance.AbsenceDate='$sevendaysago' OR
							Abre_Attendance.AbsenceDate='$sixdaysago' OR
							Abre_Attendance.AbsenceDate='$fivedaysago' OR
							Abre_Attendance.AbsenceDate='$fourdaysago' OR
							Abre_Attendance.AbsenceDate='$threedaysago' OR
							Abre_Attendance.AbsenceDate='$twodaysago' OR
							Abre_Attendance.AbsenceDate='$onedayago'
						)";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value)
			{
				$Student_ID=$value["StudentID"];
				$AbsenceDate=$value["AbsenceDate"];
				$StudentName=GetStudentNameGivenID($Student_ID);

				if($AbsenceDate==$onedayago){ 		$onedayagocount++; 		$onedayagostudents="$onedayagostudents $StudentName,";			}
				if($AbsenceDate==$twodaysago){ 		$twodaysagocount++; 	$twodaysagostudents="$twodaysagostudents $StudentName,";		}
				if($AbsenceDate==$threedaysago){ 	$threedaysagocount++; 	$threedaysagostudents="$threedaysagostudents $StudentName,";	}
				if($AbsenceDate==$fourdaysago){ 	$fourdaysagocount++; 	$fourdaysagostudents="$fourdaysagostudents $StudentName,";		}
				if($AbsenceDate==$fivedaysago){ 	$fivedaysagocount++; 	$fivedaysagostudents="$fivedaysagostudents $StudentName,";		}
				if($AbsenceDate==$sixdaysago){ 		$sixdaysagocount++; 	$sixdaysagostudents="$sixdaysagostudents $StudentName,";		}
				if($AbsenceDate==$sevendaysago){ 	$sevendaysagocount++; 	$sevendaysagostudents="$sevendaysagostudents $StudentName,";	}
				if($AbsenceDate==$eightdaysago){ 	$eightdaysagocount++; 	$eightdaysagostudents="$eightdaysagostudents $StudentName,";	}
				if($AbsenceDate==$ninedaysago){ 	$ninedaysagocount++; 	$ninedaysagostudents="$ninedaysagostudents $StudentName,";		}
				if($AbsenceDate==$tendaysago){ 		$tendaysagocount++; 	$tendaysagostudents="$tendaysagostudents $StudentName,";		}
				if($AbsenceDate==$elevindaysago){ 	$elevindaysagocount++; 	$elevindaysagostudents="$elevindaysagostudents $StudentName,";	}
				if($AbsenceDate==$twelvedaysago){ 	$twelvedaysagocount++; 	$twelvedaysagostudents="$twelvedaysagostudents $StudentName,";	}
			}

		}

		if($CounselingID!="")
		{
			$query = "SELECT StudentID, AbsenceDate, FirstName, LastName FROM Abre_Student_Counselors LEFT JOIN Abre_Attendance ON Abre_Student_Counselors.StudentId=Abre_Attendance.StudentID WHERE
						Abre_Student_Counselors.CounselorStaffId='$StaffId' AND
						(
							Abre_Attendance.AbsenceDate='$twelvedaysago' OR
							Abre_Attendance.AbsenceDate='$elevindaysago' OR
							Abre_Attendance.AbsenceDate='$tendaysago' OR
							Abre_Attendance.AbsenceDate='$ninedaysago' OR
							Abre_Attendance.AbsenceDate='$eightdaysago' OR
							Abre_Attendance.AbsenceDate='$sevendaysago' OR
							Abre_Attendance.AbsenceDate='$sixdaysago' OR
							Abre_Attendance.AbsenceDate='$fivedaysago' OR
							Abre_Attendance.AbsenceDate='$fourdaysago' OR
							Abre_Attendance.AbsenceDate='$threedaysago' OR
							Abre_Attendance.AbsenceDate='$twodaysago' OR
							Abre_Attendance.AbsenceDate='$onedayago'
						)";

			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value)
			{
				$Student_ID=$value["StudentID"];
				$AbsenceDate=$value["AbsenceDate"];
				$FirstName=$value["FirstName"];
				$LastName=$value["LastName"];
				$StudentName="$FirstName $LastName";

				if($AbsenceDate==$onedayago){ 		$onedayagocount++; 		$onedayagostudents="$onedayagostudents $StudentName,";			}
				if($AbsenceDate==$twodaysago){ 		$twodaysagocount++; 	$twodaysagostudents="$twodaysagostudents $StudentName,";		}
				if($AbsenceDate==$threedaysago){ 	$threedaysagocount++; 	$threedaysagostudents="$threedaysagostudents $StudentName,";	}
				if($AbsenceDate==$fourdaysago){ 	$fourdaysagocount++; 	$fourdaysagostudents="$fourdaysagostudents $StudentName,";		}
				if($AbsenceDate==$fivedaysago){ 	$fivedaysagocount++; 	$fivedaysagostudents="$fivedaysagostudents $StudentName,";		}
				if($AbsenceDate==$sixdaysago){ 		$sixdaysagocount++; 	$sixdaysagostudents="$sixdaysagostudents $StudentName,";		}
				if($AbsenceDate==$sevendaysago){ 	$sevendaysagocount++; 	$sevendaysagostudents="$sevendaysagostudents $StudentName,";	}
				if($AbsenceDate==$eightdaysago){ 	$eightdaysagocount++; 	$eightdaysagostudents="$eightdaysagostudents $StudentName,";	}
				if($AbsenceDate==$ninedaysago){ 	$ninedaysagocount++; 	$ninedaysagostudents="$ninedaysagostudents $StudentName,";		}
				if($AbsenceDate==$tendaysago){ 		$tendaysagocount++; 	$tendaysagostudents="$tendaysagostudents $StudentName,";		}
				if($AbsenceDate==$elevindaysago){ 	$elevindaysagocount++; 	$elevindaysagostudents="$elevindaysagostudents $StudentName,";	}
				if($AbsenceDate==$twelvedaysago){ 	$twelvedaysagocount++; 	$twelvedaysagostudents="$twelvedaysagostudents $StudentName,";	}
			}

		}

		echo "<div id='attendanceholder' class='mdl-shadow--2dp' style='background-color:#fff;'>";
			echo "<h5 style='padding:20px 40px 0 40px;'>Recent Absences</h5>";
			echo "<div id='class_attendance' style='height:320px;'></div>";
		echo "</div>";

	}
?>

<script>

	$(function()
	{

		$(window).resize(function(){
			GetAttendanceWidth();
			try{ Attendance(); }catch(err){  }
		});

		GetAttendanceWidth();
		function GetAttendanceWidth(){
			var attendancewidth = $('#attendanceholder').width();
			attendancewidth=attendancewidth;
			$("#class_attendance").css("width", attendancewidth+"px");
		}

		//Chart Options
		var options = {
	        chartArea:{left:0,top:0,bottom:40,right:0,width:"100%",height:"100%"},
			bar: {groupWidth: "95%"},
			legend: { position: "none" },
			backgroundColor: { fill:'transparent' },
			animation:{ "startup": true, duration: 1000, easing: 'out'},
			colors: ['<?php echo getSiteColor(); ?>'],
			tooltip: {isHtml: true}
		};

		google.charts.setOnLoadCallback(Attendance);
	    function Attendance(){
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Day');
			data.addColumn('number', 'Absences');
			data.addColumn({type: 'string', role: 'tooltip'});
			data.addRows([
				<?php if($twelvedaysagoday!="Saturday" && $twelvedaysagoday!="Sunday"){ ?> ['<?php echo $twelvedaysago; ?>', <?php echo $twelvedaysagocount; ?>,'<?php echo rtrim($twelvedaysagostudents,','); ?>'], <?php } ?>
				<?php if($elevindaysagoday!="Saturday" && $elevindaysagoday!="Sunday"){ ?> ['<?php echo $elevindaysago; ?>', <?php echo $elevindaysagocount; ?>,'<?php echo rtrim($elevindaysagostudents,','); ?>'], <?php } ?>
				<?php if($tendaysagoday!="Saturday" && $tendaysagoday!="Sunday"){ ?> ['<?php echo $tendaysago; ?>', <?php echo $tendaysagocount; ?>,'<?php echo rtrim($tendaysagostudents,','); ?>'], <?php } ?>
				<?php if($ninedaysagoday!="Saturday" && $ninedaysagoday!="Sunday"){ ?> ['<?php echo $ninedaysago; ?>', <?php echo $ninedaysagocount; ?>,'<?php echo rtrim($ninedaysagostudents,','); ?>'], <?php } ?>
				<?php if($eightdaysagoday!="Saturday" && $eightdaysagoday!="Sunday"){ ?> ['<?php echo $eightdaysago; ?>', <?php echo $eightdaysagocount; ?>,'<?php echo rtrim($eightdaysagostudents,','); ?>'], <?php } ?>
				<?php if($sevendaysagoday!="Saturday" && $sevendaysagoday!="Sunday"){ ?> ['<?php echo $sevendaysago; ?>', <?php echo $sevendaysagocount; ?>,'<?php echo rtrim($sevendaysagostudents,','); ?>'], <?php } ?>
				<?php if($sixdaysagoday!="Saturday" && $sixdaysagoday!="Sunday"){ ?> ['<?php echo $sixdaysago; ?>', <?php echo $sixdaysagocount; ?>,'<?php echo rtrim($sixdaysagostudents,','); ?>'], <?php } ?>
				<?php if($fivedaysagoday!="Saturday" && $fivedaysagoday!="Sunday"){ ?> ['<?php echo $fivedaysago; ?>', <?php echo $fivedaysagocount; ?>,'<?php echo rtrim($fivedaysagostudents,','); ?>'], <?php } ?>
				<?php if($fourdaysagoday!="Saturday" && $fourdaysagoday!="Sunday"){ ?> ['<?php echo $fourdaysago; ?>', <?php echo $fourdaysagocount; ?>,'<?php echo rtrim($fourdaysagostudents,','); ?>'], <?php } ?>
				<?php if($threedaysagoday!="Saturday" && $threedaysagoday!="Sunday"){ ?> ['<?php echo $threedaysago; ?>', <?php echo $threedaysagocount; ?>,'<?php echo rtrim($threedaysagostudents,','); ?>'], <?php } ?>
				<?php if($twodaysagoday!="Saturday" && $twodaysagoday!="Sunday"){ ?> ['<?php echo $twodaysago; ?>', <?php echo $twodaysagocount; ?>,'<?php echo rtrim($twodaysagostudents,','); ?>'], <?php } ?>
				<?php if($onedayagoday!="Saturday" && $onedayagoday!="Sunday"){ ?> ['<?php echo $onedayago; ?>', <?php echo $onedayagocount; ?>,'<?php echo rtrim($onedayagostudents,','); ?>'], <?php } ?>
			]);

			var view = new google.visualization.DataView(data);
			view.setColumns([0, 1,{ calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 2]);

			var chart = new google.visualization.ColumnChart(document.getElementById("class_attendance"));
			chart.draw(view, options);
		}
	});

</script>
