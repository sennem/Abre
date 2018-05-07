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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');

	//Retrive GET Variables
	if(isset($_GET["coursegroup"])){ $GroupID = htmlspecialchars($_GET["coursegroup"], ENT_QUOTES); }else{ $GroupID = ""; }
	if(isset($_GET["section"])){ $Section = htmlspecialchars($_GET["section"], ENT_QUOTES); }else{ $Section = ""; }

	echo "<div class='page_container'>";
	echo "<div class='row'><div class='col s12 center-align'><a class='waves-effect btn-flat white-text resetcolors' style='margin-left:5px; background-color:"; echo getSiteColor(); echo "'>Reset Colors</a></div></div>";
	echo "<div class='row'>";

		if($Section == ""){
			$query = "SELECT Student_ID FROM students_groups_students WHERE Group_ID = '$GroupID'";
		}else{
			$StaffId = GetStaffID($_SESSION['useremail']);
			$query = "SELECT StudentID, FirstName, LastName FROM Abre_StudentSchedules WHERE CourseCode = '$GroupID' AND SectionCode = '$Section' AND StaffId = '$StaffId'";
		}
		$dbreturn = databasequery($query);
		$StudentIDCommaSeparated = "";
		foreach ($dbreturn as $value){
			//Find the Students Name
			if($Section == ""){
				$StudentId = htmlspecialchars($value["Student_ID"], ENT_QUOTES);
				$query2 = "SELECT FirstName, LastName FROM Abre_Students WHERE StudentId = '$StudentId' LIMIT 1";
				$dbreturn2 = databasequery($query2);
				foreach ($dbreturn2 as $value2){
					$FirstName = htmlspecialchars($value2["FirstName"], ENT_QUOTES);
					$LastName = htmlspecialchars($value2["LastName"], ENT_QUOTES);
				}
			}else{
				$StudentId = htmlspecialchars($value["StudentID"], ENT_QUOTES);
				$FirstName = htmlspecialchars($value["FirstName"], ENT_QUOTES);
				$LastName = htmlspecialchars($value["LastName"], ENT_QUOTES);
			}

			//Store StudentID's in Comma Separated
			$StudentIDCommaSeparated = "$StudentId,$StudentIDCommaSeparated";

			//Check to see if previous color exists
			$query2 = "SELECT Color FROM conduct_colors WHERE StudentID='$StudentId' AND CourseGroup='$GroupID' AND DATE(Time) = CURDATE() LIMIT 1";
			$dbreturn2 = databasequery($query2);
			$Color = "green";
			foreach ($dbreturn2 as $value2){
				$Color = htmlspecialchars($value2["Color"], ENT_QUOTES);
			}
			$imagesDir = 'images/avatars/';
			$images = glob($imagesDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
			$randomImage = $images[array_rand($images)];
			$StudentPicture = "/modules/".basename(__DIR__)."/$randomImage";

			echo "<div style='float:left; width:200px; margin:10px; -webkit-touch-callout:none; -webkit-user-select:none; -khtml-user-select:none; -moz-user-select:none; -ms-user-select:none; user-select:none;'>";
				echo "<div class='mdl-card mdl-shadow--2dp pointer colorchange $Color' data-studentid='$StudentId' data-coursegroup='$GroupID' data-section='$Section' style='width:100%; padding:20px;'>";
					echo "<img src='$StudentPicture' class='circle' style='width:100px; height:100px; margin:0 auto;'>";
					echo "<div style='margin-top:30px;' class='center-align'><h4 style='line-height:0; margin:0;'>$FirstName</h4><h6 style='line-height:0;'>$LastName</h6></div>";
					echo "<a href='#conduct/pbis'></a>";
				echo "</div>";
			echo "</div>";

		}

		$StudentIDCommaSeparated = rtrim($StudentIDCommaSeparated,",");
		echo "<span id='studentcsv' class='hide'>$StudentIDCommaSeparated</span>";

	echo "</div>";
	echo "</div>";

?>

<script>

	$(function(){
		function saveColor(studentid,color,coursegroup,section){
			$.ajax({
				method: "POST",
				url: "modules/<?php echo basename(__DIR__); ?>/save_color.php",
				data: { Student_ID: studentid, Color: color, CourseGroup: coursegroup, Section: section }
			})
		}

		$(".colorchange").unbind().click(function(){
			var StudentID = $(this).data("studentid");
			var CourseGroup = $(this).data("coursegroup");
			var Section = $(this).data("section");

			if($(this).hasClass("red")){ $(this).animateCss('tada'); saveColor(StudentID,"orange",CourseGroup,Section); $(this).removeClass("red"); $(this).addClass("orange"); return; }
			if($(this).hasClass("orange")){ $(this).animateCss('tada'); saveColor(StudentID,"yellow",CourseGroup,Section); $(this).removeClass("orange"); $(this).addClass("yellow"); return; }
			if($(this).hasClass("yellow")){ $(this).animateCss('tada'); saveColor(StudentID,"green",CourseGroup,Section); $(this).removeClass("yellow"); $(this).addClass("green"); return; }
			if($(this).hasClass("green")){ $(this).animateCss('tada'); saveColor(StudentID,"blue",CourseGroup,Section); $(this).removeClass("green"); $(this).addClass("blue"); return; }
			if($(this).hasClass("blue")){ $(this).animateCss('tada'); saveColor(StudentID,"purple",CourseGroup,Section); $(this).removeClass("blue"); $(this).addClass("purple"); return; }
			if($(this).hasClass("purple")){ $(this).animateCss('tada'); saveColor(StudentID,"pink",CourseGroup,Section); $(this).removeClass("purple"); $(this).addClass("pink"); return; }
			if($(this).hasClass("pink")){ $(this).animateCss('tada'); saveColor(StudentID,"red",CourseGroup,Section); $(this).removeClass("pink"); $(this).addClass("red"); return; }
		});

		$.fn.extend({
		    animateCss: function (animationName) {
		        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
		        this.addClass('animated ' + animationName).one(animationEnd, function() {
		            $(this).removeClass('animated ' + animationName);
		        });
		    }
		});
	});

</script>