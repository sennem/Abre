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

	$Student_ID = htmlspecialchars($_GET["Student_ID"], ENT_QUOTES);

	if($pagerestrictions == "" || ($isParent && verifyStudent($Student_ID)))
	{

		//Get Student Profile Information
		$query = "SELECT FirstName, LastName, EthnicityDescription, DateOfBirth, Gender, IEP, Gifted, ELL, StudentId, CurrentGrade, SchoolName, Username, Password FROM Abre_Students WHERE StudentId='$Student_ID' LIMIT 1";
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
			$StudentPicture="/modules/".basename(__DIR__)."/image.php?student=$Student_ID";
			$Username = $value['Username'];
			$Password = $value["Password"];
		}

		//Find Students Email
		$query = "SELECT Email FROM Abre_AD WHERE StudentID='$Student_ID' LIMIT 1";
		$dbreturn = databasequery($query);
		foreach ($dbreturn as $value)
		{
			$Student_Email=htmlspecialchars($value["Email"], ENT_QUOTES);
		}

	    echo "<div class='row'>";

	    	//Main Content
	    	echo "<div class='col l8 m12 s12'>";

	    		echo "<div class='mdl-shadow--2dp' style='background-color:#fff; padding:20px 40px 40px 40px; margin-bottom:20px; width:100%;'>";
		    		echo "<div class='light' style='margin-bottom:40px;'>";
						echo "<ul class='tabs' style='background-color:rgba(0, 0, 0, 0)'>";
							echo "<li class='tab col s3'><a href='#assessments'><i class='material-icons hide-on-large-only'>assessment</i><span class='hide-on-med-and-down'>Assessments</span></a></li>";
							echo "<li class='tab col s3'><a href='#schedule'><i class='material-icons hide-on-large-only'>schedule</i><span class='hide-on-med-and-down'>Schedule</span></a></li>";
							echo "<li class='tab col s3'><a href='#attendance'><i class='material-icons hide-on-large-only'>alarm</i><span class='hide-on-med-and-down'>Attendance</span></a></li>";
							if(isAppActive("Abre-Conduct")){
								echo "<li class='tab col s3'><a href='#conduct'><i class='material-icons hide-on-large-only'>gavel</i><span class='hide-on-med-and-down'>Conduct</span></a></li>";
							}
						echo "</ul>";
					echo "</div>";

					//Body
					echo "<div id='assessments'>";
						include "student_assessments.php";
					echo "</div>";

					echo "<div id='schedule'>";
						include "student_schedule.php";
					echo "</div>";

					echo "<div id='attendance'>";
						include "student_attendance.php";
					echo "</div>";

					if(isAppActive("Abre-Conduct")){
						echo "<div id='conduct'>";
							include "student_conduct.php";
						echo "</div>";
					}
				echo "</div>";

			echo "</div>";

			//Profile
			echo "<div class='col l4 m12 s12'>";
				echo "<div class='mdl-shadow--2dp' style='background-color:#fff; padding:30px 35px 15px 35px;'>";

					//Name
					echo "<div class='center-align'><img src='$StudentPicture' class='circle' style='width:100px; height:100px;'></div>";
					echo "<h4 class='center-align'>$Student_FirstName $Student_LastName</h4>";
					echo "<p class='center-align'>";
						if($SchoolName != ""){ echo "$SchoolName</br>"; }
						if($Student_ID != ""){ echo "ID: <span id='studentid'>$Student_ID</span>"; }
					echo "</p>";

					//Break
					echo "<hr>";
					if($Password != "" && $Username != "" && $pagerestrictions == ""){
						echo "<h5>Student Login<i class='pointer material-icons' id='displayInfo' style='float:right;'>visibility</i></h5>";
						echo "<p id='loginInformation' style='display:none;'>";
							echo "<b>Username:</b> $Username<br>";
							echo "<b>Password:</b> <span id='studentPassword'></span><br>";
						echo "</p>";
						echo "<hr>";
					}
					//Basic Information
					echo "<h5>Student Information</h5>";

						echo "<p>";
							if($DateOfBirth!=""){ echo "<b>Birthday:</b> $DateOfBirth<br>"; }
							if($Gender!=""){ echo "<b>Gender:</b> $Gender<br>"; }
							if($CurrentGrade!=""){ echo "<b>Grade:</b> $CurrentGrade<br>"; }
							if($IEP!=""){ echo "<b>IEP Status:</b> $IEP<br>"; }
							if($Gifted!=""){
								if($pagerestrictions == "" && $db->query("SELECT * FROM Abre_Gifted LIMIT 1")){
									echo "<b>Gifted Status:</b> $Gifted<i class='pointer material-icons' id='displayGiftedDetails' style='float:right;'>visibility</i><br>";
								}else{
									echo "<b>Gifted Status:</b> $Gifted<br>";
								}
							}
							if($ELL!=""){ echo "<b>ELL Status:</b> $ELL<br>"; }

							//Student Email
							echo "<b>Email:</b> ";
							if(admin()){
								if($Student_Email != ""){
									echo "<span class='input-field'><input id='studentemail' type='text' value='$Student_Email'></span><br>";
								}else{
									echo "<span class='input-field'><input id='studentemail' type='text' placeholder='No Associated Email'></span><br>";
								}
							}
							else{
								if($Student_Email != ""){
									echo "<span>$Student_Email</span><br>";
								}else{
									echo "<span>No Associated Email</span><br>";
								}
							}
						echo "</p>";

						//Save Button for Email
						if(admin()){
							echo "<button class='waves-effect btn-flat white-text' id='updateemail' style='width:100%; background-color:"; echo getSiteColor(); echo "; margin-bottom:20px;'>Save Email</button>";
						}

					//Break
					echo "<hr>";

					//Guardian Contact
					echo "<h5>Guardian Contacts</h5>";
					$query = "SELECT FirstName, LastName, AddressLine1, City, State, Zip, Phone1, Phone2, Email1 FROM Abre_ParentContacts WHERE StudentID = '$Student_ID' LIMIT 2";
					$dbreturn = databasequery($query);
					$i = 0;
					foreach ($dbreturn as $value)
					{
						$Contact_FirstName = htmlspecialchars($value["FirstName"], ENT_QUOTES);
						$Contact_LastName = htmlspecialchars($value["LastName"], ENT_QUOTES);
						$Contact_AddressLine1 = htmlspecialchars($value["AddressLine1"], ENT_QUOTES);
						$Contact_City = htmlspecialchars($value["City"], ENT_QUOTES);
						$Contact_State = htmlspecialchars($value["State"], ENT_QUOTES);
						$Contact_Zip = htmlspecialchars($value["Zip"], ENT_QUOTES);
						$Contact_Phone1 = htmlspecialchars($value["Phone1"], ENT_QUOTES);
						$Contact_Phone2 = htmlspecialchars($value["Phone2"], ENT_QUOTES);
						$Contact_Email = htmlspecialchars($value["Email1"], ENT_QUOTES);

						if($i == 0){
							echo "<b>Primary Contact</b>";
						}
						if($i == 1){
							echo "<b>Secondary Contact</b>";
						}
						echo "<p>";
							if($Contact_FirstName != ""){ echo "$Contact_FirstName $Contact_LastName<br>"; }
							if($Contact_AddressLine1 != "" && $Contact_City != "" && $Contact_State != ""){ echo "$Contact_AddressLine1, $Contact_City, $Contact_State $Contact_Zip<br>"; }
							if($Contact_Phone1 != ""){ echo "$Contact_Phone1<br>"; }
							if($Contact_Email != ""){ echo "$Contact_Email<br>"; } else { echo "No Email Listed"; }
						echo "</p>";
						$i++;
					}
					if(count($dbreturn) == 0){
						echo "<p>No Guardian Contact on File</p>";
					}

					if($pagerestrictions == ""){
						//Check if Alert Messages from Vendorlink
						$query = "SELECT AlertMessages, MedicalAlertMessages FROM Abre_VendorLink_SIS_Students WHERE LocalId='$Student_ID' LIMIT 1";
						$dbreturn = databasequery($query);
						foreach ($dbreturn as $value)
						{
							$AlertMessages=$value["AlertMessages"];
							$AlertMessages = json_decode($AlertMessages, true);

							$MedicalAlertMessages=$value["MedicalAlertMessages"];
							$MedicalAlertMessages = json_decode($MedicalAlertMessages, true);

							//Break
							echo "<hr>";
							echo "<p>";

							//Alert Messages
							echo "<h5>Messages</h5>";
							if(!empty($AlertMessages))
							{
								echo "<b>Alert Messages: </b>";
								foreach ($AlertMessages as $key => $value)
								{
									echo $value["Value"] . " ";
								}
								echo "<br>";
							}

							if(!empty($MedicalAlertMessages))
							{
								echo "<b>Medical Messages: </b>";
								foreach ($MedicalAlertMessages as $key => $value)
								{
									echo $value["Value"] . " ";
								}
							}
							echo "</p>";

						}
					}

					//Parent Access Token
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

							//Break
							echo "<hr>";

							echo "<h5>Parent Access Token</h5>";
							if(!isset($token)){ $token=""; $tokenverbage="Create Token"; }else{ $tokenverbage="Reset Token"; }
							if(!isset($tokendecrypted)){ $tokendecrypted="No Generated Token"; }
							echo "<p><b>$tokendecrypted</b></p><button class='waves-effect btn-flat white-text' id='resettoken' data-studentid='$Student_ID' data-token='$token' style='width:100%; background-color:".getSiteColor().";'>$tokenverbage</button>";
						}
					}

				echo "</div>";
			echo "</div>";

		echo "</div>";

	}else{
		echo "<div class='row' style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>Oops! Something went wrong!</span><br><p style='font-size:16px; margin:20px 0 0 0;'>You do not have access to this student's information.</p></div>";
	}

?>

<script>

	$(function()
	{

	    $('ul.tabs').tabs();

	    $("#myTable").tablesorter({

    	});

		//Reset Parent Access Token
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

		//Update Student Email
		$("#updateemail").unbind().click(function()
		{
			var Email = $( "#studentemail" ).val();
			var StudentID = $( "#studentid" ).text();

			$.post("modules/<?php echo basename(__DIR__); ?>/savestudentemail.php", { Email: Email, StudentID: StudentID })
			.done(function( data ) {
				var notification = document.querySelector('.mdl-js-snackbar');
				var data = { message: "Email Updated" };
				notification.MaterialSnackbar.showSnackbar(data);
  			});
		});

		var isOpen = false;
		$("#displayInfo").off().on('click', function(){
			isOpen = !isOpen;
			if(isOpen){
				$("#loginInformation").show();
				$("#studentPassword").text("<?php if($Password != ""){ echo decrypt($Password, ''); }else{ echo ""; }?>");
				$("#displayInfo").text('visibility_off');
			}else{
				$("#loginInformation").hide();
				$("#studentPassword").text("");
				$("#displayInfo").text('visibility');
			}
		});

		$("#displayGiftedDetails").off().on('click', function(){
			var studentID = "<?php echo $Student_ID ?>";

			$('#giftedDetailsModal').openModal({
				in_duration: 0,
				out_duration: 0,
				ready: function() {
					$("#giftedDetails").load('/modules/Abre-Students/gifteddetails.php?studentID='+studentID);
				}
			});
		});

	});

</script>
