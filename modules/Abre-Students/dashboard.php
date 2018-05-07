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
	require_once('permissions.php');

	if($isParent){

		isVerified();

		echo "<div class='row'>";

		if($_SESSION['auth_students'] != ""){
			$students = explode(",", $_SESSION['auth_students']);
			foreach($students as $student){
				$query = "SELECT FirstName, LastName, StudentId, SchoolName FROM Abre_Students WHERE StudentId = '$student' LIMIT 1";
				$dbreturn = databasequery($query);
				foreach ($dbreturn as $value){
					$FirstName = htmlspecialchars($value['FirstName'], ENT_QUOTES);
					$LastName = htmlspecialchars($value['LastName'], ENT_QUOTES);
					$StudentId = htmlspecialchars($value['StudentId'], ENT_QUOTES);
					$SchoolName = htmlspecialchars($value['SchoolName'], ENT_QUOTES);

					echo "<div class='col l6 s12'>";
						echo "<div class='card mdl-shadow--2dp' style='padding:10px;'>";

							echo "<table><tr>";

							echo "<td valign='top' width='140px'>";
								$StudentPicture = "/modules/".basename(__DIR__)."/image.php?student=$StudentId";
								echo "<div class='row center-align'><img src='$StudentPicture' class='circle' style='width:100px; height:100px;'></div>";
							echo "</td>";

							echo "<td valign='top'>";
								echo "<h4 class='truncate'>$FirstName $LastName</h4>";
								echo "<p>$SchoolName</p>";
								echo "<hr>";
								echo "<br><a href='#mystudents/$StudentId' class='waves-effect btn-flat white-text' style='background-color:".getSiteColor().";'>View Profile</a>";
							echo "</td>";

							echo "</tr></table>";

						echo "</div>";
					echo "</div>";
				}
			}
		}else{
			echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>You have not redeemed any student codes</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Click the '+' in the top menu to enter a student code.</p></div>";
		}
		echo "</div>";
	}
?>