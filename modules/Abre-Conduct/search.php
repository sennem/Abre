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

	//Layout
	echo "<div class='row'>";
	echo "<div class='col s12'>";

	//Find the SchoolCodes of the user
	$SchoolCode = GetStaffSchoolCode($_SESSION['useremail']);
	$SchoolCodeArray = explode(', ', $SchoolCode);
	$SchoolGroupCode = "(SchoolCode = '' ";
	foreach($SchoolCodeArray as $value){
	    $SchoolGroupCode = $SchoolGroupCode." or SchoolCode = '$value'";
	}
	$SchoolGroupCode = $SchoolGroupCode.")";

	if(isset($_GET["query"])){ $group_search = $_GET["query"]; $group_search = base64_decode($group_search); }

	if($group_search != ""){

		$group_search = mysqli_real_escape_string($db, $group_search);

		if(admin()){
			$query = "SELECT FirstName, MiddleName, LastName, StudentId, IEP, SchoolName, SchoolCode, CurrentGrade FROM Abre_Students WHERE (LastName LIKE '$group_search%' OR FirstName LIKE '$group_search%' OR StudentId LIKE '$group_search%') AND Status != 'I' GROUP BY StudentId ORDER BY LastName, FirstName LIMIT 50";
		}else{
			$query = "SELECT FirstName, MiddleName, LastName, StudentId, IEP, SchoolName, SchoolCode, CurrentGrade FROM Abre_Students WHERE (LastName LIKE '$group_search%' OR FirstName LIKE '$group_search%' OR StudentId LIKE '$group_search%') AND $SchoolGroupCode and Status != 'I' GROUP BY StudentId ORDER BY LastName, FirstName LIMIT 50";
		}

		$dbreturn = databasequery($query);
		$resultcount = count($dbreturn);
		$counter = 0;
		foreach($dbreturn as $value){
			$counter++;
			$FirstName = htmlspecialchars($value['FirstName'], ENT_QUOTES);
			$MiddleName = htmlspecialchars($value['MiddleName'], ENT_QUOTES);
			$LastName = htmlspecialchars($value['LastName'], ENT_QUOTES);
			$StudentID = $value['StudentId'];
			$StudentIEP = $value['IEP'];
			$SchoolName = htmlspecialchars($value['SchoolName'], ENT_QUOTES);
			$SchoolCode = $value['SchoolCode'];
			$CurrentGrade = $value['CurrentGrade'];
			$StudentPicture = "/modules/".basename(__DIR__)."/image.php?student=$StudentID";


			if($counter == 1){ echo "<table style='width:100%;'>"; }

				echo "<tr class='attachwrapper'><td style='border:1px solid #e1e1e1; width:70px; padding-left:15px; background-color:".getSiteColor()."'><img src='$StudentPicture' class='circle' style='width:40px; height:40px;'></td><td style='background-color:#F5F5F5; border-left:1px solid #e1e1e1; border-top:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; padding:10px;'>";
				echo "<p class='mdl-color-text--black' style='font-weight:500;'>$LastName, $FirstName $MiddleName</p></td>";
				echo "<td class='hide-on-small-only' style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px;'>$StudentID</td>";
				echo "<td class='hide-on-small-only' style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px;'>$CurrentGrade</td>";
				echo "<td class='hide-on-small-only' style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px;'>$SchoolName</td>";

				echo "<td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px; width:70px;'><a data-studentid='$StudentID' data-studentiep='$StudentIEP' data-studentname='$FirstName $MiddleName $LastName' data-studentfirstname='$FirstName' data-studentlastname='$LastName' data-studentmiddlename='$MiddleName' data-currentgrade='$CurrentGrade' data-schoolname='$SchoolName' data-schoolcode='$SchoolCode' data-schoolpicture='$StudentPicture' data-bgcolor='".getSiteColor()."' style='color: ".getSiteColor()."' class='choosestudent pointer'><i class='material-icons'>add_circle</i></a></td>";
				echo "</tr>";

			if($dbreturn == $counter){ echo "</table>"; }
		}

		if($resultcount == 0){ echo "<h5 class='center-align'>No students found</h5><br>"; }
	}

		//Layout
		echo "</div>";
		echo "</div>";
?>

<script>

		$(function(){

			//Choose Student and Send to Modal
			$( ".choosestudent" ).unbind().click(function(){
				event.preventDefault();
				var Student_ID = $(this).data('studentid');
				var Student_IEP = $(this).data('studentiep');
				var Student_Name = $(this).data('studentname');
				var Student_FirstName = $(this).data('studentfirstname');
				var Student_MiddleName = $(this).data('studentmiddlename');
				var Student_LastName = $(this).data('studentlastname');
				var Student_Grade = $(this).data('currentgrade');
				var Student_School_Name = $(this).data('schoolname');
				var Student_School_Code = $(this).data('schoolcode');
				var BG_Color = $(this).data('bgcolor');
				var SchoolPicture = $(this).data('schoolpicture');

				$("#Incident_Student_ID").val(Student_ID);
				$("#Incident_Student_IEP").val(Student_IEP);
				$("#Incident_Student_FirstName").val(Student_FirstName);
				$("#Incident_Student_MiddleName").val(Student_MiddleName);
				$("#Incident_Student_LastName").val(Student_LastName);
				$("#Incident_Student_Building").val(Student_School_Name);
				$("#Incident_Student_Code").val(Student_School_Code);

				$("#searchresults").html("<div class='row'><div class='col s12'><table style='width:100%;'><tr><td style='border:1px solid #e1e1e1; width:70px; padding-left:15px; background-color:"+BG_Color+"'><img src='"+SchoolPicture+"' class='circle' style='width:40px; height:40px;'></td><td style='background-color:#F5F5F5; border-left:1px solid #e1e1e1; border-top:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; padding:10px;'><p class='mdl-color-text--black' style='font-weight:500;'>"+Student_Name+"</p></td><td class='hide-on-small-only' style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px;'>"+Student_ID+"</td><td class='hide-on-small-only' style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px;'>"+Student_Grade+"</td><td class='hide-on-small-only' style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px;'>"+Student_School_Name+"</td></tr></table></div></div>");
			});
		});

</script>