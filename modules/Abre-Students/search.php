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
	$SchoolCode=GetStaffSchoolCode($_SESSION['useremail']);

		$SchoolCodeArray = explode(', ', $SchoolCode);
		$SchoolGroupCode = "(SchoolCode='' ";
		foreach($SchoolCodeArray as $value)
		{
		    $SchoolGroupCode = $SchoolGroupCode." or SchoolCode='$value'";
		}
		$SchoolGroupCode = $SchoolGroupCode.")";

	if(isset($_GET["query"])){ $group_search=$_GET["query"]; $group_search=base64_decode($group_search); }

	if($group_search!="")
	{

		$group_search = mysqli_real_escape_string($db, $group_search);

		if(admin())
		{
			$query = "SELECT FirstName, LastName, StudentId, IEP, SchoolName, SchoolCode, CurrentGrade FROM Abre_Students WHERE (LastName LIKE '$group_search%' OR FirstName LIKE '$group_search%' OR StudentId LIKE '$group_search%') AND Status!='I' GROUP BY StudentId ORDER BY LastName, FirstName LIMIT 50";
		}
		else
		{
			$query = "SELECT FirstName, LastName, StudentId, IEP, SchoolName, SchoolCode, CurrentGrade FROM Abre_Students WHERE (LastName LIKE '$group_search%' OR FirstName LIKE '$group_search%' OR StudentId LIKE '$group_search%') AND $SchoolGroupCode AND Status!='I' GROUP BY StudentId ORDER BY LastName, FirstName LIMIT 50";
		}
		$dbreturn = databasequery($query);
		$resultcount = count($dbreturn);
		$counter=0;
		foreach ($dbreturn as $value)
		{
			$counter++;
			$FirstName=$value['FirstName'];
			$LastName=$value['LastName'];
			$StudentID=$value['StudentId'];
			$StudentIEP=$value['IEP'];
			$SchoolName=$value['SchoolName'];
			$SchoolCode=$value['SchoolCode'];
			$CurrentGrade=$value['CurrentGrade'];
			$StudentPicture="/modules/".basename(__DIR__)."/image.php?student=$StudentID";

			if($counter==1){ echo "<table style='width:100%;'>"; }

				echo "<tr class='attachwrapper'><td style='border:1px solid #e1e1e1; width:70px; padding-left:15px; background-color:".getSiteColor()."'><img src='$StudentPicture' class='circle' style='width:40px; height:40px;'></td>";
				echo "<td style='background-color:#fff; border-left:1px solid #e1e1e1; border-top:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; padding:10px;'>";
					echo "<span class='mdl-color-text--black' style='font-weight:500;'>$LastName, $FirstName</span>";
				echo "</td>";
				echo "<td class='hide-on-small-only' style='background-color:#fff; border:1px solid #e1e1e1; padding:12px 10px 10px 22px;'>$StudentID</td>";
				echo "<td class='hide-on-small-only' style='background-color:#fff; border:1px solid #e1e1e1; padding:12px 10px 10px 22px;'>$CurrentGrade</td>";
				echo "<td class='hide-on-small-only' style='background-color:#fff; border:1px solid #e1e1e1; padding:12px 10px 10px 22px;'>$SchoolName</td>";

				echo "<td style='background-color:#fff; border:1px solid #e1e1e1; padding:12px 10px 10px 22px; width:70px;'><a style='color: ".getSiteColor()."' class='modal-studentlook pointer' href='#studentlook' data-studentid='$StudentID'><i class='material-icons'>remove_red_eye</i></a></td>";
				echo "</tr>";

			if($dbreturn==$counter){ echo "</table>"; }
		}

		if($resultcount==0){ echo "<h5 class='center-align'>No students found</h5><br>"; }
	}

		//Layout
		echo "</div>";
		echo "</div>";

?>

<script>

	$(function()
	{

	   	//Click on a Student
	   	$(".modal-studentlook").unbind().click(function(event)
	   	{
		   	event.preventDefault();
		   	var StudentID = $(this).data('studentid');
		   	$("#searchresults").html('');
		   	$("#studentssearchquery").val("");

	    	$('#studentlook').openModal({
		    	in_duration: 0,
				out_duration: 0,
		    	ready: function()
		    	{
			    	$("#studentdetailsloader").show();
			    	$("#studentdetails").html('');
			    	$("#studentdetails").load('modules/<?php echo basename(__DIR__); ?>/student.php?Student_ID='+StudentID, function(){ $("#studentdetailsloader").hide(); mdlregister(); });
				},
		   	});

		});


	//End Document Ready
	});


</script>
