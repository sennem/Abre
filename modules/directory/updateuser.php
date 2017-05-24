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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require('permissions.php');
	require_once('functions.php');
	
	//Update the User
	if($pageaccess==1)
	{	
		
		require_once('../../core/abre_functions.php');
		
		include "../../core/abre_dbconnect.php";
		$stack = array();
		$id=mysqli_real_escape_string($db, $_POST["id"]);
		$email=mysqli_real_escape_string($db, $_POST["email"]);
		$firstname=mysqli_real_escape_string($db, $_POST["firstname"]);
		$lastname=mysqli_real_escape_string($db, $_POST["lastname"]);
		if($email=="" && $id=="new")
		{ 
			$email=emailPrediction($firstname, $lastname);
			$email=encrypt($email, ""); 
		}
		else
		{ 
			$email=encrypt($email, ""); 
		}
		$firstname=encrypt($firstname, "");
		$middlename=mysqli_real_escape_string($db, $_POST["middlename"]);
		$middlename=encrypt($middlename, "");
		$lastname=encrypt($lastname, "");
		$title=mysqli_real_escape_string($db, $_POST["title"]);
		$title=encrypt($title, "");
		$contract=mysqli_real_escape_string($db, $_POST["contract"]);
		$contract=encrypt($contract, "");
		$address=mysqli_real_escape_string($db, $_POST["address"]);
		$address=encrypt($address, "");
		$city=mysqli_real_escape_string($db, $_POST["city"]);
		$city=encrypt($city, "");
		$state=mysqli_real_escape_string($db, $_POST["state"]);
		$state=encrypt($state, "");
		$zip=mysqli_real_escape_string($db, $_POST["zip"]);
		$zip=encrypt($zip, "");
		$phone=mysqli_real_escape_string($db, $_POST["phone"]);
		$phone=encrypt($phone, "");
		$cellphone=mysqli_real_escape_string($db, $_POST["cellphone"]);
		$cellphone=encrypt($cellphone, "");
		$ss=mysqli_real_escape_string($db, $_POST["ss"]);
		$ss=encrypt($ss, "");
		$dob=mysqli_real_escape_string($db, $_POST["dob"]);
		$dob=encrypt($dob, "");
		$gender=mysqli_real_escape_string($db, $_POST["gender"]);
		$gender=encrypt($gender, "");
		$ethnicity=mysqli_real_escape_string($db, $_POST["ethnicity"]);
		$ethnicity=encrypt($ethnicity, "");
		$classification=mysqli_real_escape_string($db, $_POST["classification"]);
		$classification=encrypt($classification, "");
		$location=mysqli_real_escape_string($db, $_POST["location"]);
		$location=encrypt($location, "");
		$grade=mysqli_real_escape_string($db, $_POST["grade"]);
		$grade=encrypt($grade, "");
		$subject=mysqli_real_escape_string($db, $_POST["subject"]);
		$subject=encrypt($subject, "");
		$doh=mysqli_real_escape_string($db, $_POST["doh"]);
		$doh=encrypt($doh, "");
		$sd=mysqli_real_escape_string($db, $_POST["sd"]);
		$sd=encrypt($sd, "");
		$ed=mysqli_real_escape_string($db, $_POST["ed"]);
		$ed=encrypt($ed, "");
		$rategroup=mysqli_real_escape_string($db, $_POST["rategroup"]);
		$rategroup=encrypt($rategroup, "");
		$step=mysqli_real_escape_string($db, $_POST["step"]);
		$step=encrypt($step, "");
		$educationlevel=mysqli_real_escape_string($db, $_POST["educationlevel"]);
		$educationlevel=encrypt($educationlevel, "");
		$salary=mysqli_real_escape_string($db, $_POST["salary"]);
		$salary=encrypt($salary, "");
		$hours=mysqli_real_escape_string($db, $_POST["hours"]);
		$hours=encrypt($hours, "");
		$probationreportdate=mysqli_real_escape_string($db, $_POST["probationreportdate"]);
		$probationreportdate=encrypt($probationreportdate, "");
		$statebackgroundcheck=mysqli_real_escape_string($db, $_POST["statebackgroundcheck"]);
		$statebackgroundcheck=encrypt($statebackgroundcheck, "");
		$federalbackgroundcheck=mysqli_real_escape_string($db, $_POST["federalbackgroundcheck"]);
		$federalbackgroundcheck=encrypt($federalbackgroundcheck, "");
		$stateeducatorid=mysqli_real_escape_string($db, $_POST["stateeducatorid"]);
		$stateeducatorid=encrypt($stateeducatorid, "");
		$currentpicture=mysqli_real_escape_string($db, $_POST["currentpicture"]);
		
		$licensetypeid1=mysqli_real_escape_string($db, $_POST["licensetypeid1"]);
		$licensetypeid1=encrypt($licensetypeid1, "");
		$licenseissuedateid1=mysqli_real_escape_string($db, $_POST["licenseissuedateid1"]);
		$licenseissuedateid1=encrypt($licenseissuedateid1, "");
		$licenseexpirationdateid1=mysqli_real_escape_string($db, $_POST["licenseexpirationdateid1"]);
		$licenseexpirationdateid1=encrypt($licenseexpirationdateid1, "");
		$licensetermid1=mysqli_real_escape_string($db, $_POST["licensetermid1"]);
		$licensetermid1=encrypt($licensetermid1, "");
		
		$licensetypeid2=mysqli_real_escape_string($db, $_POST["licensetypeid2"]);
		$licensetypeid2=encrypt($licensetypeid2, "");
		$licenseissuedateid2=mysqli_real_escape_string($db, $_POST["licenseissuedateid2"]);
		$licenseissuedateid2=encrypt($licenseissuedateid2, "");
		$licenseexpirationdateid2=mysqli_real_escape_string($db, $_POST["licenseexpirationdateid2"]);
		$licenseexpirationdateid2=encrypt($licenseexpirationdateid2, "");
		$licensetermid2=mysqli_real_escape_string($db, $_POST["licensetermid2"]);
		$licensetermid2=encrypt($licensetermid2, "");
		
		$licensetypeid3=mysqli_real_escape_string($db, $_POST["licensetypeid3"]);
		$licensetypeid3=encrypt($licensetypeid3, "");
		$licenseissuedateid3=mysqli_real_escape_string($db, $_POST["licenseissuedateid3"]);
		$licenseissuedateid3=encrypt($licenseissuedateid3, "");
		$licenseexpirationdateid3=mysqli_real_escape_string($db, $_POST["licenseexpirationdateid3"]);
		$licenseexpirationdateid3=encrypt($licenseexpirationdateid3, "");
		$licensetermid3=mysqli_real_escape_string($db, $_POST["licensetermid3"]);
		$licensetermid3=encrypt($licensetermid3, "");
		
		$licensetypeid4=mysqli_real_escape_string($db, $_POST["licensetypeid4"]);
		$licensetypeid4=encrypt($licensetypeid4, "");
		$licenseissuedateid4=mysqli_real_escape_string($db, $_POST["licenseissuedateid4"]);
		$licenseissuedateid4=encrypt($licenseissuedateid4, "");
		$licenseexpirationdateid4=mysqli_real_escape_string($db, $_POST["licenseexpirationdateid4"]);
		$licenseexpirationdateid4=encrypt($licenseexpirationdateid4, "");
		$licensetermid4=mysqli_real_escape_string($db, $_POST["licensetermid4"]);
		$licensetermid4=encrypt($licensetermid4, "");
		
		$licensetypeid5=mysqli_real_escape_string($db, $_POST["licensetypeid5"]);
		$licensetypeid5=encrypt($licensetypeid5, "");
		$licenseissuedateid5=mysqli_real_escape_string($db, $_POST["licenseissuedateid5"]);
		$licenseissuedateid5=encrypt($licenseissuedateid5, "");
		$licenseexpirationdateid5=mysqli_real_escape_string($db, $_POST["licenseexpirationdateid5"]);
		$licenseexpirationdateid5=encrypt($licenseexpirationdateid5, "");
		$licensetermid5=mysqli_real_escape_string($db, $_POST["licensetermid5"]);
		$licensetermid5=encrypt($licensetermid5, "");
		
		$licensetypeid6=mysqli_real_escape_string($db, $_POST["licensetypeid6"]);
		$licensetypeid6=encrypt($licensetypeid6, "");
		$licenseissuedateid6=mysqli_real_escape_string($db, $_POST["licenseissuedateid6"]);
		$licenseissuedateid6=encrypt($licenseissuedateid6, "");
		$licenseexpirationdateid6=mysqli_real_escape_string($db, $_POST["licenseexpirationdateid6"]);
		$licenseexpirationdateid6=encrypt($licenseexpirationdateid6, "");
		$licensetermid6=mysqli_real_escape_string($db, $_POST["licensetermid6"]);
		$licensetermid6=encrypt($licensetermid6, "");
		
		$permissions=mysqli_real_escape_string($db, $_POST["permissions"]);
		$permissions=encrypt($permissions, "");
		
		$role = implode (", ", $_POST["role"]);
		if (strpos($role, 'Directory Administrator') !== false) {
			$superadmin=1;
		}
		else
		{
			$superadmin=0;
		}
		
		if (strpos($role, 'Directory Supervisor') !== false) {
			$admin=1;
		}
		elseif(strpos($role, 'Directory Advisor') !== false)
		{
			$admin=2;
		}
		else
		{
			$admin=0;
		}
		$role=encrypt($role, "");
		
		$contractdays=mysqli_real_escape_string($db, $_POST["contractdays"]);
		$contractdays=encrypt($contractdays, "");
		
		//Process New Profile Picture
		if($_FILES['picture']['name'])
		{
			require_once("ImageManipulator.php");
			
			$validExtensions = array('.jpg', '.JPG', '.jpeg', '.JPEG', '.gif', '.GIF', '.png', '.PNG');
		    $fileExtension = strrchr($_FILES['picture']['name'], ".");
		    if (in_array($fileExtension, $validExtensions))
		    {
				$newNamePrefix = time() . '_';
		        $manipulator = new ImageManipulator($_FILES['picture']['tmp_name']);
		        $manipulator->resample(500, 500);
		        $width  = $manipulator->getWidth();
		        $height = $manipulator->getHeight();
		        $centreX = round($width / 2);
		        $centreY = round($height / 2);
		        $x1 = $centreX - 150;
		        $y1 = $centreY - 150;
		
		        $x2 = $centreX + 150;
		        $y2 = $centreY + 150;
		
		        $newImage = $manipulator->crop($x1, $y1, $x2, $y2);
		        // saving file to uploads folder
		        $picturefilename=$newNamePrefix . $_FILES['picture']['name'];
		        $manipulator->save($portal_path_root."/../$portal_private_root/directory/images/employees/" . $picturefilename);
		    }
		}
		else
		{
			$picturefilename=$currentpicture;
		}
		
		if($id!="new")
		{
			//Process the Discipline Report
			if($_FILES['discipline']['name'])
			{
				//Upload File to Server
				$validExtensions = array('.doc', '.DOC', '.docx', '.DOCX', '.pdf', '.PDF');
			    $fileExtension = strrchr($_FILES['discipline']['name'], ".");
			    if (in_array($fileExtension, $validExtensions))
			    {
				    $newNamePrefix = time() . '$_$';
				    $disfilename=$newNamePrefix . $_FILES['discipline']['name'];
					if(!move_uploaded_file($_FILES['discipline']['tmp_name'], $portal_path_root . "/../$portal_private_root/directory/discipline/" . $disfilename)){
						echo "The file was not uploaded";
					}
					
					//Add Record to Database
				    include "../../core/abre_dbconnect.php";
				    $stmtdiscipline = $db->stmt_init();
				    $sqldiscipline = "INSERT INTO directory_discipline (UserID,Filename) VALUES ('$id','$disfilename');";
				    $stmtdiscipline->prepare($sqldiscipline);
					$stmtdiscipline->execute();
					$stmtdiscipline->store_result();
					$stmtdiscipline->close();
			    }
			    
			}
		}	
		
		if($id!="")
		{
			mysqli_query($db, "UPDATE directory set updatedtime=now(), superadmin='$superadmin', admin='$admin', picture='$picturefilename', firstname='$firstname', middlename='$middlename', lastname='$lastname', address='$address', city='$city', state='$state', zip='$zip', phone='$phone', cellphone='$cellphone', email='$email', ss='$ss', dob='$dob', gender='$gender', ethnicity='$ethnicity', title='$title', contract='$contract', classification='$classification', location='$location', grade='$grade', subject='$subject', doh='$doh', senioritydate='$sd', effectivedate='$ed', rategroup='$rategroup', step='$step', educationlevel='$educationlevel', salary='$salary', hours='$hours', probationreportdate='$probationreportdate', statebackgroundcheck='$statebackgroundcheck', federalbackgroundcheck='$federalbackgroundcheck', stateeducatorid='$stateeducatorid', licensetype1='$licensetypeid1', licenseissuedate1='$licenseissuedateid1', licenseexpirationdate1='$licenseexpirationdateid1', licenseterm1='$licensetermid1', licensetype2='$licensetypeid2', licenseissuedate2='$licenseissuedateid2', licenseexpirationdate2='$licenseexpirationdateid2', licenseterm2='$licensetermid2', licensetype3='$licensetypeid3', licenseissuedate3='$licenseissuedateid3', licenseexpirationdate3='$licenseexpirationdateid3', licenseterm3='$licensetermid3', licensetype4='$licensetypeid4', licenseissuedate4='$licenseissuedateid4', licenseexpirationdate4='$licenseexpirationdateid4', licenseterm4='$licensetermid4', licensetype5='$licensetypeid5', licenseissuedate5='$licenseissuedateid5', licenseexpirationdate5='$licenseexpirationdateid5', licenseterm5='$licensetermid5', licensetype6='$licensetypeid6', licenseissuedate6='$licenseissuedateid6', licenseexpirationdate6='$licenseexpirationdateid6', licenseterm6='$licensetermid6', permissions='$permissions', role='$role', contractdays='$contractdays' where id='$id'") or die (mysqli_error($db));
		}
		if($id=="new")
		{
			mysqli_query($db, "INSERT INTO directory (id, updatedtime, superadmin, admin, picture, firstname, lastname, middlename, address, city, state, zip, email, phone, cellphone, ss, dob, gender, ethnicity, title, contract, classification, location, grade, subject, doh, senioritydate, effectivedate, rategroup, step, educationlevel, salary, hours, probationreportdate, statebackgroundcheck, federalbackgroundcheck, stateeducatorid, licensetype1, licenseissuedate1, licenseexpirationdate1, licenseterm1, licensetype2, licenseissuedate2, licenseexpirationdate2, licenseterm2, licensetype3, licenseissuedate3, licenseexpirationdate3, licenseterm3, licensetype4, licenseissuedate4, licenseexpirationdate4, licenseterm4, licensetype5, licenseissuedate5, licenseexpirationdate5, licenseterm5, licensetype6, licenseissuedate6, licenseexpirationdate6, licenseterm6, permissions, role, contractdays) VALUES (NULL, CURRENT_TIMESTAMP, '$superadmin', '$admin', '$picturefilename', '$firstname', '$lastname', '$middlename', '$address', '$city', '$state', '$zip', '$email', '$phone', '$cellphone', '$ss', '$dob', '$gender', '$ethnicity', '$title', '$contract', '$classification', '$location', '$grade', '$subject', '$doh', '$sd', '$ed', '$rategroup', '$step', '$educationlevel', '$salary', '$hours', '$probationreportdate', '$statebackgroundcheck', '$federalbackgroundcheck', '$stateeducatorid', '$licensetypeid1', '$licenseissuedateid1', '$licenseexpirationdateid1', '$licensetermid1', '$licensetypeid2', '$licenseissuedateid2', '$licenseexpirationdateid2', '$licensetermid2', '$licensetypeid3', '$licenseissuedateid3', '$licenseexpirationdateid3', '$licensetermid3', '$licensetypeid4', '$licenseissuedateid4', '$licenseexpirationdateid4', '$licensetermid4', '$licensetypeid5', '$licenseissuedateid5', '$licenseexpirationdateid5', '$licensetermid5', '$licensetypeid6', '$licenseissuedateid6', '$licenseexpirationdateid6', '$licensetermid6', '$permissions', '$role', '$contractdays');") or die (mysqli_error($db));		
		}
		$db->close();
		echo "The user has been updated.";		
	}
	
?>