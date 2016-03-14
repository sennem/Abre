<?php
	
	/*
	* Copyright 2015 Hamilton City School District	
	* 		
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	* 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	* 
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */
	
	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once('permissions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	
	//Display User Profile Information
	if($pageaccess==1)
	{	
		$id=htmlspecialchars($_GET["id"], ENT_QUOTES);		
		
		require_once('../../core/abre_functions.php');
	
		echo "<div class='page_container page_container_limit mdl-shadow--4dp'>";
		echo "<div class='page'>";
			
			if($id!="new")
			{
				include "../../core/abre_dbconnect.php";
				$sql = "SELECT *  FROM directory where id=$id and archived=0";
				$result = $db->query($sql);
				while($row = $result->fetch_assoc())
				{
					$firstname=htmlspecialchars($row["firstname"], ENT_QUOTES);
					$firstname=stripslashes(htmlspecialchars(decrypt($firstname, ""), ENT_QUOTES));
					$middlename=htmlspecialchars($row["middlename"], ENT_QUOTES);
					$middlename=stripslashes(htmlspecialchars(decrypt($middlename, ""), ENT_QUOTES));
					$lastname=htmlspecialchars($row["lastname"], ENT_QUOTES);
					$lastname=stripslashes(htmlspecialchars(decrypt($lastname, ""), ENT_QUOTES));
					$title=htmlspecialchars($row["title"], ENT_QUOTES);
					$title=stripslashes(htmlspecialchars(decrypt($title, ""), ENT_QUOTES));
					$contract=htmlspecialchars($row["contract"], ENT_QUOTES);
					$contract=stripslashes(htmlspecialchars(decrypt($contract, ""), ENT_QUOTES));
					$address=htmlspecialchars($row["address"], ENT_QUOTES);
					$address=stripslashes(htmlspecialchars(decrypt($address, ""), ENT_QUOTES));
					$city=htmlspecialchars($row["city"], ENT_QUOTES);
					$city=stripslashes(htmlspecialchars(decrypt($city, ""), ENT_QUOTES));
					$state=htmlspecialchars($row["state"], ENT_QUOTES);
					$state=stripslashes(htmlspecialchars(decrypt($state, ""), ENT_QUOTES));
					$zip=htmlspecialchars($row["zip"], ENT_QUOTES);
					$zip=stripslashes(htmlspecialchars(decrypt($zip, ""), ENT_QUOTES));
					$phone=htmlspecialchars($row["phone"], ENT_QUOTES);
					$phone=stripslashes(htmlspecialchars(decrypt($phone, ""), ENT_QUOTES));
					$cellphone=htmlspecialchars($row["cellphone"], ENT_QUOTES);
					$cellphone=stripslashes(htmlspecialchars(decrypt($cellphone, ""), ENT_QUOTES));
					$email=htmlspecialchars($row["email"], ENT_QUOTES);
					$email=stripslashes(htmlspecialchars(decrypt($email, ""), ENT_QUOTES));
					$ss=htmlspecialchars($row["ss"], ENT_QUOTES);
					$ss=stripslashes(htmlspecialchars(decrypt($ss, ""), ENT_QUOTES));
					$dob=htmlspecialchars($row["dob"], ENT_QUOTES);
					$dob=stripslashes(htmlspecialchars(decrypt($dob, ""), ENT_QUOTES));
					$gender=htmlspecialchars($row["gender"], ENT_QUOTES);
					$gender=stripslashes(htmlspecialchars(decrypt($gender, ""), ENT_QUOTES));
					$ethnicity=htmlspecialchars($row["ethnicity"], ENT_QUOTES);
					$ethnicity=stripslashes(htmlspecialchars(decrypt($ethnicity, ""), ENT_QUOTES));
					$classification=htmlspecialchars($row["classification"], ENT_QUOTES);
					$classification=stripslashes(htmlspecialchars(decrypt($classification, ""), ENT_QUOTES));
					$location=htmlspecialchars($row["location"], ENT_QUOTES);
					$location=stripslashes(htmlspecialchars(decrypt($location, ""), ENT_QUOTES));
					$grade=htmlspecialchars($row["grade"], ENT_QUOTES);
					$grade=stripslashes(htmlspecialchars(decrypt($grade, ""), ENT_QUOTES));
					$subject=htmlspecialchars($row["subject"], ENT_QUOTES);
					$subject=stripslashes(htmlspecialchars(decrypt($subject, ""), ENT_QUOTES));
					$doh=htmlspecialchars($row["doh"], ENT_QUOTES);
					$doh=stripslashes(htmlspecialchars(decrypt($doh, ""), ENT_QUOTES));
					$sd=htmlspecialchars($row["senioritydate"], ENT_QUOTES);
					$sd=stripslashes(htmlspecialchars(decrypt($sd, ""), ENT_QUOTES));
					$ed=htmlspecialchars($row["effectivedate"], ENT_QUOTES);
					$ed=stripslashes(htmlspecialchars(decrypt($ed, ""), ENT_QUOTES));
					$step=htmlspecialchars($row["step"], ENT_QUOTES);
					$step=stripslashes(htmlspecialchars(decrypt($step, ""), ENT_QUOTES));
					$salary=htmlspecialchars($row["salary"], ENT_QUOTES);
					$salary=stripslashes(htmlspecialchars(decrypt($salary, ""), ENT_QUOTES));
					$hours=htmlspecialchars($row["hours"], ENT_QUOTES);
					$hours=stripslashes(htmlspecialchars(decrypt($hours, ""), ENT_QUOTES));
					$probationreportdate=htmlspecialchars($row["probationreportdate"], ENT_QUOTES);
					$probationreportdate=stripslashes(htmlspecialchars(decrypt($probationreportdate, ""), ENT_QUOTES));
					$statebackgroundcheck=htmlspecialchars($row["statebackgroundcheck"], ENT_QUOTES);
					$statebackgroundcheck=stripslashes(htmlspecialchars(decrypt($statebackgroundcheck, ""), ENT_QUOTES));
					$federalbackgroundcheck=htmlspecialchars($row["federalbackgroundcheck"], ENT_QUOTES);
					$federalbackgroundcheck=stripslashes(htmlspecialchars(decrypt($federalbackgroundcheck, ""), ENT_QUOTES));
					$picture=htmlspecialchars($row["picture"], ENT_QUOTES);
					$stateeducatorid=htmlspecialchars($row["stateeducatorid"], ENT_QUOTES);
					$stateeducatorid=stripslashes(htmlspecialchars(decrypt($stateeducatorid, ""), ENT_QUOTES));
					
					$licensetype1=htmlspecialchars($row["licensetype1"], ENT_QUOTES);
					$licensetype1=stripslashes(htmlspecialchars(decrypt($licensetype1, ""), ENT_QUOTES));
					$licenseissuedate1=htmlspecialchars($row["licenseissuedate1"], ENT_QUOTES);
					$licenseissuedate1=stripslashes(htmlspecialchars(decrypt($licenseissuedate1, ""), ENT_QUOTES));
					$licenseexpirationdate1=htmlspecialchars($row["licenseexpirationdate1"], ENT_QUOTES);
					$licenseexpirationdate1=stripslashes(htmlspecialchars(decrypt($licenseexpirationdate1, ""), ENT_QUOTES));
					$licenseterm1=htmlspecialchars($row["licenseterm1"], ENT_QUOTES);
					$licenseterm1=stripslashes(htmlspecialchars(decrypt($licenseterm1, ""), ENT_QUOTES));
					
					$licensetype2=htmlspecialchars($row["licensetype2"], ENT_QUOTES);
					$licensetype2=stripslashes(htmlspecialchars(decrypt($licensetype2, ""), ENT_QUOTES));
					$licenseissuedate2=htmlspecialchars($row["licenseissuedate2"], ENT_QUOTES);
					$licenseissuedate2=stripslashes(htmlspecialchars(decrypt($licenseissuedate2, ""), ENT_QUOTES));
					$licenseexpirationdate2=htmlspecialchars($row["licenseexpirationdate2"], ENT_QUOTES);
					$licenseexpirationdate2=stripslashes(htmlspecialchars(decrypt($licenseexpirationdate2, ""), ENT_QUOTES));
					$licenseterm2=htmlspecialchars($row["licenseterm2"], ENT_QUOTES);
					$licenseterm2=stripslashes(htmlspecialchars(decrypt($licenseterm2, ""), ENT_QUOTES));
					
					$licensetype3=htmlspecialchars($row["licensetype3"], ENT_QUOTES);
					$licensetype3=stripslashes(htmlspecialchars(decrypt($licensetype3, ""), ENT_QUOTES));
					$licenseissuedate3=htmlspecialchars($row["licenseissuedate3"], ENT_QUOTES);
					$licenseissuedate3=stripslashes(htmlspecialchars(decrypt($licenseissuedate3, ""), ENT_QUOTES));
					$licenseexpirationdate3=htmlspecialchars($row["licenseexpirationdate3"], ENT_QUOTES);
					$licenseexpirationdate3=stripslashes(htmlspecialchars(decrypt($licenseexpirationdate3, ""), ENT_QUOTES));
					$licenseterm3=htmlspecialchars($row["licenseterm3"], ENT_QUOTES);
					$licenseterm3=stripslashes(htmlspecialchars(decrypt($licenseterm3, ""), ENT_QUOTES));
					
					$licensetype4=htmlspecialchars($row["licensetype4"], ENT_QUOTES);
					$licensetype4=stripslashes(htmlspecialchars(decrypt($licensetype4, ""), ENT_QUOTES));
					$licenseissuedate4=htmlspecialchars($row["licenseissuedate4"], ENT_QUOTES);
					$licenseissuedate4=stripslashes(htmlspecialchars(decrypt($licenseissuedate4, ""), ENT_QUOTES));
					$licenseexpirationdate4=htmlspecialchars($row["licenseexpirationdate4"], ENT_QUOTES);
					$licenseexpirationdate4=stripslashes(htmlspecialchars(decrypt($licenseexpirationdate4, ""), ENT_QUOTES));
					$licenseterm4=htmlspecialchars($row["licenseterm4"], ENT_QUOTES);
					$licenseterm4=stripslashes(htmlspecialchars(decrypt($licenseterm4, ""), ENT_QUOTES));
					
					$licensetype5=htmlspecialchars($row["licensetype5"], ENT_QUOTES);
					$licensetype5=stripslashes(htmlspecialchars(decrypt($licensetype5, ""), ENT_QUOTES));
					$licenseissuedate5=htmlspecialchars($row["licenseissuedate5"], ENT_QUOTES);
					$licenseissuedate5=stripslashes(htmlspecialchars(decrypt($licenseissuedate5, ""), ENT_QUOTES));
					$licenseexpirationdate5=htmlspecialchars($row["licenseexpirationdate5"], ENT_QUOTES);
					$licenseexpirationdate5=stripslashes(htmlspecialchars(decrypt($licenseexpirationdate5, ""), ENT_QUOTES));
					$licenseterm5=htmlspecialchars($row["licenseterm5"], ENT_QUOTES);
					$licenseterm5=stripslashes(htmlspecialchars(decrypt($licenseterm5, ""), ENT_QUOTES));
					
					$licensetype6=htmlspecialchars($row["licensetype6"], ENT_QUOTES);
					$licensetype6=stripslashes(htmlspecialchars(decrypt($licensetype6, ""), ENT_QUOTES));
					$licenseissuedate6=htmlspecialchars($row["licenseissuedate6"], ENT_QUOTES);
					$licenseissuedate6=stripslashes(htmlspecialchars(decrypt($licenseissuedate6, ""), ENT_QUOTES));
					$licenseexpirationdate6=htmlspecialchars($row["licenseexpirationdate6"], ENT_QUOTES);
					$licenseexpirationdate6=stripslashes(htmlspecialchars(decrypt($licenseexpirationdate6, ""), ENT_QUOTES));
					$licenseterm6=htmlspecialchars($row["licenseterm6"], ENT_QUOTES);
					$licenseterm6=stripslashes(htmlspecialchars(decrypt($licenseterm6, ""), ENT_QUOTES));
	
	
					$id=htmlspecialchars($row["id"], ENT_QUOTES);
				}
			}
			else
			{
				
				$firstname="";
				$middlename="";
				$lastname="";
				$title="";
				$contract="";
				$address="";
				$city="";
				$state="";
				$zip="";
				$phone="";
				$cellphone="";
				$email="";
				$ss="";
				$dob="";
				$gender="";
				$ethnicity="";
				$classification="";
				$location="";
				$grade="";
				$subject="";
				$doh="";
				$sd="";
				$ed="";
				$step="";
				$salary="";
				$hours="";
				$probationreportdate="";
				$statebackgroundcheck="";
				$federalbackgroundcheck="";
				$picture="";
				$stateeducatorid="";
					
				$licensetype1="";
				$licenseissuedate1="";
				$licenseexpirationdate1="";
				$licenseterm1="";
					
				$licensetype2="";
				$licenseissuedate2="";
				$licenseexpirationdate2="";
				$licenseterm2="";
					
				$licensetype3="";
				$licenseissuedate3="";
				$licenseexpirationdate3="";
				$licenseterm3="";
					
				$licensetype4="";
				$licenseissuedate4="";
				$licenseexpirationdate4="";
				$licenseterm4="";
					
				$licensetype5="";
				$licenseissuedate5="";
				$licenseexpirationdate5="";
				$licenseterm5="";
					
				$licensetype6="";
				$licenseissuedate6="";
				$licenseexpirationdate6="";
				$licenseterm6="";
				
			}
				if($picture==""){ 
					$pictureserver=$portal_root."/modules/directory/images/user.png";
				}
				else
				{
					$fileExtension = strrchr($picture, ".");
					$pictureserver=$portal_root."/modules/directory/serveimage.php?file=$picture&ext=$fileExtension";
				}
				echo "<form id='form-hr' method='post' enctype='multipart/form-data' action='modules/directory/updateuser.php'>";
			
				  echo "<div class='row'><div class='col s12'>";
				  		echo "<img src='$pictureserver' class='profile-avatar' style='display: block; margin: 0 auto;'>";
				  echo "</div></div>";
				  echo "<div class='row'><div class='col l12'><h4>Basic Information</h4></div></div>";
				  echo "<div class='row'>";
				    echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a First Name' value='$firstname' id='firstname' name='firstname' type='text' required>";
				      echo "<label class='active' for='firstname'>First Name</label>";
				    echo "</div>";
				    echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a Middle Name' value='$middlename' id='middlename' name='middlename' type='text'>";
				      echo "<label class='active' for='middlename'>Middle Name</label>";
				    echo "</div>";
				    echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a Last Name' value='$lastname' id='lastname' name='lastname' type='text' required>";
				      echo "<label class='active' for='lastname'>Last Name</label>";
				    echo "</div>";
				  echo "</div>";
				  
				  echo "<div class='row'>";
				    echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a Social Security Number' value='$ss' id='ss' name='ss' type='text'>";
				      echo "<label class='active' for='middlename'>Social Security Number</label>";
				    echo "</div>";
				    echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a Date' type='date' value='$dob' name='dob' class='datepicker'>";
				      echo "<label class='active' for='dob'>Date of Birth</label>";
				    echo "</div>";
				    echo "<div class='col l4 s12'>";
				      echo "<p>Profile Picture</p>";
				      if($picture!="" xor $picture=='user.png'){ echo "<input type='hidden' name='currentpicture' value='$picture'>"; }else{ echo "<input type='hidden' name='currentpicture' value=''>"; }
				      echo "<input type='file' name='picture' />";
				    echo "</div>";
				  echo "</div>";
				  
				  echo "<div class='row'>";
					echo "<div class='input-field col l4 s12'>";
						echo "<select name='ethnicity'>";
					      	include "ethnicity.php";
						echo "</select>";
					    echo "<label>Ethnicity</label>";
				    echo "</div>"; 
					echo "<div class='input-field col l4 s12'>";
						echo "<select name='gender'>";
					      	include "gender.php";
						echo "</select>";
					    echo "<label>Gender</label>";
				    echo "</div>"; 
				  echo "</div>";
				  
				  echo "<div class='row'><div class='col l12'><h4>Contact Information</h4></div></div>";
				  echo "<div class='row'>";
				    echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a Address' value='$address' id='address' name='address' type='text'>";
				      echo "<label class='active' for='address'>Address</label>";
				    echo "</div>";
					echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a City' value='$city' id='city' name='city' type='text'>";
				      echo "<label class='active' for='city'>City</label>";
				    echo "</div>";   
					echo "<div class='input-field col l2 s12'>";
						echo "<select name='state'>";
					      	include "states.php";
						echo "</select>";
					    echo "<label>State</label>";
				    echo "</div>"; 
					echo "<div class='input-field col l2 s12'>";
				      echo "<input placeholder='Enter a Zipcode' value='$zip' id='zip' name='zip' type='text'>";
				      echo "<label class='active' for='zip'>Zipcode</label>";
				    echo "</div>";   
				  echo "</div>";  
				  
				  echo "<div class='row'>";
				    echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a Phone Number' value='$phone' id='phone' name='phone' type='text'>";
				      echo "<label class='active' for='phone'>Phone Number</label>";
				    echo "</div>";
				    echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a Cell Number' value='$cellphone' id='cellphone' name='cellphone' type='text'>";
				      echo "<label class='active' for='cellphone'>Cell Number</label>";
				    echo "</div>";
				    echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a Email' value='$email' id='email' name='email' type='text'>";
				      echo "<label class='active' for='email'>Email</label>";
				    echo "</div>";
				  echo "</div>";
				  
				  echo "<div class='row'><div class='col l12'><h4>Job Information</h4></div></div>";
				  echo "<div class='row'>";
				    echo "<div class='input-field col l9 s12'>";
				      echo "<input placeholder='Enter a Job Title' value='$title' id='title' name='title' type='text'>";
				      echo "<label class='active' for='title'>Current Job Title</label>";
				    echo "</div>";
				    echo "<div class='input-field col l3 s12'>";
						echo "<select name='contract'>";
					      	include "contract.php";
						echo "</select>";
					    echo "<label>Contract</label>";
				    echo "</div>";
				  echo "</div>";  
				  echo "<div class='row'>";
				    echo "<div class='input-field col l3 s12'>";
						echo "<select name='classification'>";
					      	if($classification==""){ echo "<option value='$classification' selected>Choose</option>"; }
					      	if($classification!=""){ echo "<option value='$classification' selected>$classification</option>"; }
							echo "<option value='Certified'>Certified</option>";
							echo "<option value='Classified'>Classified</option>";
						echo "</select>";
					    echo "<label>Classification Type</label>";
				    echo "</div>";
				    echo "<div class='input-field col l3 s12'>";
						echo "<select name='location'>";
					      	include "locations.php";
						echo "</select>";
					    echo "<label>Home Building</label>";
				    echo "</div>";
				    echo "<div class='input-field col l3 s12'>";
						echo "<select name='grade'>";
					      	include "grade.php";
						echo "</select>";
					    echo "<label>Grade</label>";
				    echo "</div>";
				    echo "<div class='input-field col l3 s12'>";
						echo "<select name='subject'>";
					      	include "subject.php";
						echo "</select>";
					    echo "<label>Subject</label>";
				    echo "</div>";
				  echo "</div>";
				  
				  echo "<div class='row'>";
				    echo "<div class='input-field col l3 s12'>";
				      echo "<input placeholder='Enter a Date' type='date' value='$doh' name='doh' class='datepicker'>";
				      echo "<label class='active' for='doh'>Date of Hire</label>";
				    echo "</div>";
				    echo "<div class='input-field col l3 s12'>";
				      echo "<input placeholder='Enter a Date' type='date' value='$sd' name='sd' class='datepicker'>";
				      echo "<label class='active' for='sd'>Seniority Date</label>";
				    echo "</div>";
				  	echo "<div class='input-field col l3 s12'>";
				      echo "<input placeholder='Enter a Date' type='date' value='$ed' name='ed' class='datepicker'>";
				      echo "<label class='active' for='ed'>Effective Date</label>";
				    echo "</div>";
				  echo "</div>";
				  
				  echo "<div class='row'>";
				    echo "<div class='input-field col l3 s12'>";
						echo "<input placeholder='Enter a Step' value='$step' id='step' name='step' type='text'>";
				      echo "<label class='active' for='step'>Step</label>";
				    echo "</div>";
				    echo "<div class='input-field col l3 s12'>";
				      echo "<input placeholder='Enter a Salary' value='$salary' id='salary' name='salary' type='text'>";
				      echo "<label class='active' for='salary'>Salary</label>";
				    echo "</div>";
				    echo "<div class='input-field col l3 s12'>";
				      echo "<input placeholder='Enter Number of Hours' value='$hours' id='hours' name='hours' type='text'>";
				      echo "<label class='active' for='hours'>Hours</label>";
				    echo "</div>";
				  echo "</div>";
				  
				  echo "<div class='row'><div class='col l12'><h4>Background Information</h4></div></div>";
				  echo "<div class='row'>";
				    echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a Date' type='date' value='$probationreportdate' name='probationreportdate' class='datepicker'>";
				      echo "<label class='active' for='probationreportdate'>Probationary Report Date</label>";
				    echo "</div>";
				    echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a Date' type='date' value='$statebackgroundcheck' name='statebackgroundcheck' class='datepicker'>";
				      echo "<label class='active' for='statebackgroundcheck'>State Background Check</label>";
				    echo "</div>";
				    echo "<div class='input-field col l4 s12'>";
				      echo "<input placeholder='Enter a Date' type='date' value='$federalbackgroundcheck' name='federalbackgroundcheck' class='datepicker'>";
				      echo "<label class='active' for='federalbackgroundcheck'>Federal Background Check</label>";
				    echo "</div>";
				  echo "</div>";
				  
				  include "profile_licenses.php";
				  
				  if($id!="new")
				  {
					  echo "<div class='row'>";
					  		echo "<div class='col s12'><h4>Discipline Report Information</h4></div>";
					  		echo "<div id='disciplinediv'>"; include "profile_disciplinereport.php"; echo "</div>";
						  echo "<div class='input-field col s12'>";
						  	echo "<input type='file' name='discipline' />";
						  echo "</div>";
					  echo "</div>";
				  }
				
				  echo "<input type='hidden' name='id' value='$id' id='userid'><br>";
				  
				  include "profilebutton.php";
				  
				echo "</form>";

		
		echo "</div>";
		echo "</div>";
		
		?>
		
		<script>
		
			//Process the profile form
			$(function() {
				
				//Select Dropdown
		    	$('select').material_select();
		    	
		    	//Date Picture
		    	$('.datepicker').pickadate({
					selectMonths: true,
					selectYears: 160
				});
				
				//Save Form Data
				var form = $('#form-hr');
				var formMessages = $('#form-messages');
				$(form).submit(function(event) {
				    event.preventDefault();
					var formData = new FormData($(this)[0]);
					$.ajax({
					    type: 'POST',
					    url: $(form).attr('action'),
					    data: formData,
					    contentType: false,
						processData: false
					})
					
					//Show the notification
					.done(function(response) {
						<?php echo "window.location.href = '$portal_root/#directory';"; ?>
						$(formMessages).text(response);	
						$( ".notification" ).slideDown( "fast", function() {
							$( ".notification" ).delay( 2000 ).slideUp();	
						});			
					})
					
				});
			
				//Archive the User
				$("#archiveuser").click(function(event){
					event.preventDefault();
					var userid = $('#userid').val();
				    $.ajax({
					    type: 'POST',
					    url: 'modules/directory/archiveuser.php',
					    data: { id : userid }
					})
					
					//Show the notification
					.done(function(response) {
						<?php echo "window.location.href = '$portal_root/#directory';"; ?>
						$(formMessages).text(response);	
						$( ".notification" ).slideDown( "fast", function() {
							$( ".notification" ).delay( 2000 ).slideUp();	
						});			
					})
					
				});
				
				//Delete Discipline Record
				$('#disciplinediv').on('click','.deletedisciplinerecord',function(event){
					event.preventDefault();
					var fileid = $(this).find("a").attr("href");
				    $.ajax({
					    type: 'POST',
					    url: 'modules/directory/disciplinereport_delete.php',
					    data: { id : fileid }
					})
					
					//Show the notification
					.done(function(response) {
						$('.tooltipped').tooltip('remove');
						<?php echo "$( '#disciplinediv' ).load( 'modules/directory/profile_disciplinereport.php?userid=$id' );"; ?>
						$(formMessages).text(response);	
						$( ".notification" ).slideDown( "fast", function() {
							$( ".notification" ).delay( 2000 ).slideUp();	
						});			
					})
				});
				
			});
		
		<?php

	}
	
?>