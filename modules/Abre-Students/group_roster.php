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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');
	require_once('permissions.php');

	if($pagerestrictions=="")
	{

		$GroupID=mysqli_real_escape_string($db, $_GET["id"]);

		echo "<table style='width:100%;'><thead><tr><th></th><th>Student</th><th class='hide-on-small-only'>Student ID</th><th class='hide-on-small-only'>Grade</th><th class='hide-on-small-only'>School</th><th></th></tr>";

				$query = "SELECT Student_ID FROM students_groups_students WHERE Group_ID='$GroupID'";
				$dbreturn = databasequery($query);
				foreach ($dbreturn as $value)
				{
					$Student_ID=$value['Student_ID'];

					//Find Student Information
					$query2 = "SELECT FirstName, LastName, StudentId, CurrentGrade, SchoolName FROM Abre_Students WHERE StudentId='$Student_ID'";
					$dbreturn2 = databasequery($query2);
					foreach ($dbreturn2 as $value2)
					{
						$FirstName=$value2['FirstName'];
						$LastName=$value2['LastName'];
						$StudentId=$value2['StudentId'];
						$CurrentGrade=$value2['CurrentGrade'];
						$SchoolName=$value2['SchoolName'];
						$StudentPicture="/modules/".basename(__DIR__)."/image.php?student=$StudentId";
					}

					echo "<tr class='attachwrapper'>";
						echo "<td style='border:1px solid #e1e1e1; width:70px; padding-left:15px; background-color:".getSiteColor()."''>";
							echo "<img src='$StudentPicture' class='circle' style='width:40px; height:40px;'>";
						echo "</td>";
						echo "<td style='background-color:#F5F5F5; border-left:1px solid #e1e1e1; border-top:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; padding:10px;'>";
							echo "<p class='mdl-color-text--black' style='font-weight:500;'>$LastName, $FirstName</p>";
						echo "</td>";
						echo "<td class='hide-on-small-only' style='background-color:#F5F5F5; border-left:1px solid #e1e1e1; border-top:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; padding:10px;'>";
							echo "<p>$StudentId</p>";
						echo "</td>";
						echo "<td class='hide-on-small-only' style='background-color:#F5F5F5; border-left:1px solid #e1e1e1; border-top:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; padding:10px;'>";
							echo "<p>$CurrentGrade</p>";
						echo "</td>";
						echo "<td class='hide-on-small-only' style='background-color:#F5F5F5; border-left:1px solid #e1e1e1; border-top:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; padding:10px;'>";
							echo "<p>$SchoolName</p>";
						echo "</td>";
						echo "<td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px; width:70px;'>";
							echo "<a class='removestudenttogroup' data-link='/modules/".basename(__DIR__)."/group_remove.php?groupid=$GroupID&studentid=$Student_ID' style='color: ".getSiteColor()."' href='#' class='pointer' id='studentid-$Student_ID'>";
								echo "<i class='material-icons'>remove_circle</i>";
							echo "</a>";
						echo "</td>";
					echo "</tr>";
				}

		echo "</table>";

	}

?>

	<script>

		$(function()
		{

			//Add question to assessment
			$( ".removestudenttogroup" ).unbind().click(function(event)
			{
				event.preventDefault();
				$(this).closest("tr").hide();
				var address= $(this).data('link');
				$.ajax({
					type: 'POST',
					url: address,
					data: '',
				})

			});


		});

	</script>
