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
		$CourseCode=htmlspecialchars($_GET["courseid"], ENT_QUOTES);
		$SectionCode=htmlspecialchars($_GET["section"], ENT_QUOTES);

		//Get the StaffID of the Teacher
		$StaffId=GetStaffID($_SESSION['useremail']);


		$query = "SELECT * FROM Swoca_HA_OnHands_MasterSchedules WHERE CourseCode='$CourseCode' AND SectionCode='$SectionCode' AND StaffId='$StaffId' LIMIT 1";
		$dbreturn = databasequery($query);
		foreach ($dbreturn as $value)
		{

			echo "<div style='position: absolute; top:0; bottom:0; left:0; right:0; overflow-y: hidden;'>";

				//Show the Students
				include "students_roster.php";

				//Show the Overview
				echo "<div id='overview' style='position:absolute; width: calc(100% - 305px); left:305px; top:0; bottom:0; right:0; overflow-y: scroll; padding:20px;'>";
					echo "<div id='p2' class='mdl-progress mdl-js-progress mdl-progress__indeterminate landingloader' style='width:100%;'></div>";
					echo "<div id='studentdetails'></div>";
				echo "</div>";

			echo "</div>";

		}

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

	//Get Page Variables
	var OrigionalCourseCode="<?php echo $CourseCode; ?>";
	var OrigionalSectionCode="<?php echo $SectionCode; ?>";

	//Load the Class Page
	$("#studentdetails").load('modules/<?php echo basename(__DIR__); ?>/class.php?CourseCode='+OrigionalCourseCode+'&SectionCode='+OrigionalSectionCode, function()
	{
		$(".landingloader").hide();
	});

	//Load the Student Page
	$(document).on('click', '.studentdetails', function()
	{
		$("#studentdetails").fadeTo(0,0);
		$(".landingloader").show();
		$(".studentdetails, .coursepage").css("background-color", "");
		$(".studentdetails, .coursepage").css("color", "#fff");
		$(this).css("background-color", "#000");
		$(this).css("color", "#fff");
		var Student_ID = $(this).data('studentid');
		$("#studentdetails").load('modules/<?php echo basename(__DIR__); ?>/student.php?Student_ID='+Student_ID, function()
		{
			$(".landingloader").hide(); $("#studentdetails").fadeTo(0,1);
		});
	});

	//Load the Student Page
	$(document).on('click', '.coursepage', function()
	{
		var BackButton = $(this).data('back');
		$("#studentdetails").fadeTo(0,0);
		$(".landingloader").show();
		if(BackButton!="yes")
		{
			$(".studentdetails").css("background-color", "");
			$(".studentdetails").css("color", "#fff");
			$(this).css("background-color", "#000");
			$(this).css("color", "#fff");
		}
		var CourseCode = $(this).data('coursecode');
		var SectionCode = $(this).data('sectioncode');
		$("#studentdetails").load('modules/<?php echo basename(__DIR__); ?>/class.php?CourseCode='+CourseCode+'&SectionCode='+SectionCode, function()
		{
			$(".landingloader").hide(); $("#studentdetails").fadeTo(0,1);
		});

	});

</script>
