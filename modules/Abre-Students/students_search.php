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
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');
	require_once('permissions.php');


	if($pagerestrictions=="")
	{

		//Find the SchoolCode of the user
		$SchoolCode=GetStaffSchoolCode($_SESSION['useremail']);

		$SchoolCodeArray = explode(', ', $SchoolCode);
		$SchoolGroupCode = "(SchoolCode='' ";
		foreach($SchoolCodeArray as $value)
		{
		    $SchoolGroupCode = $SchoolGroupCode." or SchoolCode='$value'";
		}
		$SchoolGroupCode = $SchoolGroupCode.")";

		if(isset($_GET["group_search"]))
		{
			$group_search=$_GET["group_search"];
			$group_search=base64_decode($group_search);
		}
		if(isset($_GET["group_id"])){ $group_id=$_GET["group_id"]; }

		if($group_search!="")
		{
			$group_search = mysqli_real_escape_string($db, $group_search);

			if(admin() or AdminCheck($_SESSION['useremail'])==1)
			{
				$query = "SELECT FirstName, LastName, StudentId, SchoolName, CurrentGrade FROM Abre_Students WHERE (LastName LIKE '$group_search%' OR FirstName LIKE '$group_search%' OR StudentId LIKE '$group_search%') AND Status!='I' GROUP BY StudentId ORDER BY LastName LIMIT 50";
			}
			else
			{
				$query = "SELECT FirstName, LastName, StudentId, SchoolName, CurrentGrade FROM Abre_Students WHERE (LastName LIKE'$group_search%' OR FirstName LIKE '$group_search%' OR StudentId LIKE'$group_search%') AND $SchoolGroupCode AND Status!='I' GROUP BY StudentId ORDER BY LastName LIMIT 50";
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
				$SchoolName=$value['SchoolName'];
				$CurrentGrade=$value['CurrentGrade'];
				$StudentPicture="/modules/".basename(__DIR__)."/image.php?student=$StudentID";

				if($counter==1){ echo "<table style='width:100%;'><thead><tr><th></th><th>Student</th><th class='hide-on-small-only'>Student ID</th><th class='hide-on-small-only'>Grade</th><th class='hide-on-small-only'>School</th><th></th></tr>"; }

				echo "<tr class='attachwrapper'><td style='border:1px solid #e1e1e1; width:70px; padding-left:15px; background-color:".getSiteColor()."'><img src='$StudentPicture' class='circle' style='width:40px; height:40px;'></td><td style='background-color:#F5F5F5; border-left:1px solid #e1e1e1; border-top:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; padding:10px;'>";
					echo "<p class='mdl-color-text--black' style='font-weight:500;'>";
							echo "$LastName, $FirstName";
					echo "</p>";
					echo "</td>";
					echo "<td class='hide-on-small-only' style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px;'>$StudentID</td>";
					echo "<td class='hide-on-small-only' style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px;'>$CurrentGrade</td>";
					echo "<td class='hide-on-small-only' style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px;'>$SchoolName</td>";

					//Check if student already added to group
					$query2 = "SELECT COUNT(*) FROM students_groups_students WHERE Student_ID = '$StudentID' AND Group_ID = '$group_id'";
					$dbreturn2 = $db->query($query2);
					$resultrow = $dbreturn2->fetch_assoc();
					$studentfound = $resultrow["COUNT(*)"];
					if($studentfound == 0){
						echo "<td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px; width:70px;'><a data-link='/modules/".basename(__DIR__)."/group_add.php?groupid=$group_id&studentid=$StudentID' style='color: ".getSiteColor()."' class='addstudenttogroup pointer' id='studentid-$StudentID' data-groupid='$group_id'><i class='material-icons'>add_circle</i></a></td>";
					}else{
						echo "<td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px; width:70px;'></td>";
					}
					
				echo "</tr>";

				if($dbreturn==$counter){ echo "</table>"; }
			}

			if($resultcount==0){ echo "<h5 class='center-align'>No students found</h5><br>"; }
		}


	}


?>

	<script>

		$(function()
		{

			//Add question to assessment
			$( ".addstudenttogroup" ).unbind().click(function()
			{
				event.preventDefault();
				$(this).hide();
				var Group_ID = $(this).data('groupid');
				var address= $(this).data('link');
				$.ajax({
					type: 'POST',
					url: address,
					data: '',
				})

				//Load the Roster Modal
				$("#currentRoster").load( "modules/<?php echo basename(__DIR__); ?>/group_roster.php?id="+Group_ID);

			});

		  	//Make the Likes clickable
			$( ".studentpreview" ).unbind().click(function()
			{
				mdlregister();
				$('#studentpreviewholder').hide();
				$('#studentpreviewloader').show();
				var Student_ID = $(this).data('studentid');

				$('#studentpreview').openModal({ in_duration: 0, out_duration: 0, ready: function()
				{
					$('.modal-content').scrollTop(0);
					$("#studentpreviewholder").load( "modules/<?php echo basename(__DIR__); ?>/student.php?Student_ID="+Student_ID, function() {
						$('#studentpreviewloader').hide();
						$('#studentpreviewholder').show();
					});

				}
				});
			});


		});

	</script>
