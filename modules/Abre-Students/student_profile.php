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

			//Student Basic Information
			echo "<div class='mdl-shadow--2dp' style='background-color:#fff; padding:20px 40px 40px 40px'>";
			echo "<h5>Basic Information</h5>";
			$query = "SELECT FirstName, LastName, EthnicityDescription, DateOfBirth, Gender, IEP, Gifted, ELL, StudentId, CurrentGrade, SchoolName FROM Abre_Students WHERE StudentId='$Student_ID' LIMIT 1";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value)
			{
				$Student_FirstName=htmlspecialchars($value["FirstName"], ENT_QUOTES);
				$Student_LastName=htmlspecialchars($value["LastName"], ENT_QUOTES);
				$EthnicityDescription=htmlspecialchars($value["EthnicityDescription"], ENT_QUOTES);
				$DateOfBirth=htmlspecialchars($value["DateOfBirth"], ENT_QUOTES);
				$Gender=htmlspecialchars($value["Gender"], ENT_QUOTES);
				if($Gender=="M"){ $Gender="Male"; }
				if($Gender=="F"){ $Gender="Female"; }
				$IEP=htmlspecialchars($value["IEP"], ENT_QUOTES);
				$Gifted=htmlspecialchars($value["Gifted"], ENT_QUOTES);
				$ELL=htmlspecialchars($value["ELL"], ENT_QUOTES);
				$Student_ID=htmlspecialchars($value["StudentId"], ENT_QUOTES);
				$CurrentGrade=htmlspecialchars($value["CurrentGrade"], ENT_QUOTES);
				$SchoolName=htmlspecialchars($value["SchoolName"], ENT_QUOTES);

				//Check if Alert Messages from Vendorlink
				$query = "SELECT AlertMessages, MedicalAlertMessages FROM Abre_VendorLink_SIS_Students WHERE LocalId='$Student_ID' LIMIT 1";
				$dbreturn = databasequery($query);
				foreach ($dbreturn as $value)
				{
					$AlertMessages=$value["AlertMessages"];
					$AlertMessages = json_decode($AlertMessages, true);

					$MedicalAlertMessages=$value["MedicalAlertMessages"];
					$MedicalAlertMessages = json_decode($MedicalAlertMessages, true);
				}

				echo "<table class='bordered'>";
				echo "<tbody>";
				echo "<tr><td width=33%><b>Date of Birth</b></td><td class='demotext_dark'>$DateOfBirth</td></tr>";
				echo "<tr><td><b>Ethnicity</b></td><td class='demotext_dark'>$EthnicityDescription</td></tr>";
				echo "<tr><td><b>Gender</b></td><td class='demotext_dark'>$Gender</td></tr>";
				echo "<tr><td><b>Grade</b></td><td class='demotext_dark'>$CurrentGrade</td></tr>";

				if(!empty($AlertMessages))
				{
					echo "<tr><td><b>Alert Messages</b></td><td class='demotext_dark'>";
					foreach ($AlertMessages as $key => $value)
					{
						echo $value["Value"] . "<br>";
					}
					echo "</td></tr>";
				}

				if(!empty($MedicalAlertMessages))
				{
					echo "<tr><td><b>Medical Messages</b></td><td class='demotext_dark'>";
					foreach ($MedicalAlertMessages as $key => $value)
					{
						echo $value["Value"] . "<br>";
					}
					echo "</td></tr>";
				}

				//Show Parent Access Token
				if(admin() or AdminCheck($_SESSION['useremail']))
				{

					if($db->query("SELECT * FROM student_tokens LIMIT 1"))
					{

						$query = "SELECT token FROM student_tokens WHERE studentId='$Student_ID'";
						$dbreturn = databasequery($query);
						foreach ($dbreturn as $value)
						{
							$token=$value["token"];
							$tokendecrypted=decrypt($token, "");
						}

						if(!isset($token)){ $token=""; $tokenverbage="Create Token"; }else{ $tokenverbage="Reset Token"; }
						if(!isset($tokendecrypted)){ $tokendecrypted="No Generated Token"; }
						//echo "<tr><td>Parent Access Token</td><td class='demotext_dark'>$tokendecrypted</td><td width='200px' class='right-align'><button class='waves-effect btn-flat white-text' id='resettoken' data-studentid='$Student_ID' data-token='$token' style='background-color:"; echo getSiteColor(); echo "'>$tokenverbage</button></td></tr>";
					}

				}


				echo "</tbody></table>";
			}
		echo "</div>";


	}


?>


<script>

	$(function()
	{

		$("#resettoken").unbind().click(function(event)
		{
			event.preventDefault();
			var Student_ID = $(this).data('studentid');
			var Token = $(this).data('token');
			var result = confirm('Are you sure you want to proceed? This will create new key for this student and invalidate the current parent keys.');
			if(result){
				$("#resettoken").html("Resetting Token...");
				$.post("/modules/Abre-Students/generate_new_key.php", { studentid: Student_ID, token: Token }, function(){ })
				.done(function()
				{
					$("#dashboard").load('modules/<?php echo basename(__DIR__); ?>/student.php?Student_ID='+Student_ID, function()
					{
						$(".landingloader").hide();
						$("#dashboard").fadeTo(0,1);
					});
		  		})

			}
		});

	});

</script>
