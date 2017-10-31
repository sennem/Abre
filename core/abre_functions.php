<?php

	/*
	* Copyright (C) 2016-2017 Abre.io LLC
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

	//Include required files
	require_once(dirname(__FILE__) . '/../configuration.php');

	//Encryption function
	function encrypt($string, $encryption_key){
		$encryption_key = constant("DB_KEY");
		$string = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $encryption_key, $string, MCRYPT_MODE_ECB)));

		return $string;
	}

	//Decryption function
	function decrypt($string, $encryption_key){
		$encryption_key = constant("DB_KEY");
		$string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $encryption_key, base64_decode($string), MCRYPT_MODE_ECB));

		return $string;
	}

	//Find user ID in directory module given an email
	function finduserid($email){
		$email = encrypt($email, "");
		$sql = "SELECT * FROM directory WHERE email = '$email'";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc()){
			$id = $row["id"];
			return $id;
		}
	}

	//Find user ID given an email
	function superadmin(){
		include "abre_dbconnect.php";
		$sql = "SELECT * FROM users WHERE email = '".$_SESSION['useremail']."' AND superadmin = 1";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc()){
			return true;
		}
	}

	//Find user ID given an email
	function finduseridcore($email){
		include "abre_dbconnect.php";
		$sql = "SELECT * FROM users WHERE email = '".$_SESSION['useremail']."'";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc()){
			$id = $row["id"];
			return $id;
		}
	}

	//Determine the grades that students do not have email access
	function studentaccess(){
		$email = $_SESSION['useremail'];
		if(preg_replace('/[^0-9]+/', '', $email)){
			$gradyear = intval(preg_replace('/[^0-9]+/', '', $email), 10);
			$currentyear = date("y");
			$difference = $gradyear - $currentyear;
			if($difference < 6){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}

	//set verified session data for parent
	/* the first part of this function finds students who have a registered
	parent in the abre parent contact table, but not claimed in the
	users_parents table. We wanted to make parents who are registered as a contact
	for the school to be able to "fastpass" registering a student token */
	function isVerified(){
		include "abre_dbconnect.php";
		if($_SESSION['usertype'] == 'parent'){
			if($db->query("SELECT * FROM student_tokens") && $db->query("SELECT * FROM users_parent")
			    && $db->query("SELECT * FROM Abre_Students") && $db->query("SELECT * FROM Abre_ParentContacts")){
				//see if email matches any records
				$sql = "SELECT * FROM Abre_ParentContacts WHERE Email1 LIKE '".$_SESSION['useremail']."'";
				$result = $db->query($sql);
				while($row = $result->fetch_assoc()){
					//for records that match find kids associated with that email
					$sql2 = "SELECT * FROM student_tokens WHERE studentId = '".$row['StudentID']."'";
					$result2 = $db->query($sql2);
					while($row2 = $result2->fetch_assoc()){
						//for kids associated with that email
						$studenttokenencrypted = $row2['token'];
						$studentId = $row2['studentId'];

						//Check to see if student has already been claimed by parent
						$sqlcheck = "SELECT * FROM users_parent WHERE students = '$studenttokenencrypted' AND email LIKE '".$_SESSION['useremail']."' AND studentId = '$studentId'";
						$resultcheck = $db->query($sqlcheck);
						$numrows2 = $resultcheck->num_rows;

						//this parent does not have access
						if($numrows2 == 0 && $_SESSION['useremail'] != ''){
								$stmt = $db->stmt_init();
								$sql = "INSERT INTO users_parent (email, students, studentId) VALUES ('".$_SESSION['useremail']."', '$studenttokenencrypted', '$studentId')";
								$stmt->prepare($sql);
								$stmt->execute();
								$stmt->close();
						}
					}
				}
			}
		}
		$db->close();
		include "abre_dbconnect.php";
		if($db->query("SELECT * FROM student_tokens") && $db->query("SELECT * FROM users_parent")){
			$sql = "SELECT * FROM users_parent WHERE email LIKE '".$_SESSION['useremail']."'";
			$result = $db->query($sql);
			$_SESSION['auth_students'] = '';
			while($row = $result->fetch_assoc()){
				$sql2 = "SELECT * FROM student_tokens WHERE token = '".$row['students']."'";
				$result2 = $db->query($sql2);
				while($row2 = $result2->fetch_assoc()){
					$_SESSION['auth_students'] .= $row2['studentId'].',';
				}
			}
			$_SESSION['auth_students'] = rtrim($_SESSION['auth_students'],", ");
		}
	}

	//Query the database
	function databasequery($query){
		include "abre_dbconnect.php";
		$result = $db->query($query);
		$rowarray = array();
		while($row = $result->fetch_assoc()){
			array_push($rowarray, $row);
		}
		$db->close();

		return $rowarray;
	}

	//Insert into the database
	function databaseexecute($query){
		include "abre_dbconnect.php";
		$stmt = $db->stmt_init();
		$stmt->prepare($query);
		$stmt->execute();
		$newcommentid = $stmt->insert_id;
		$stmt->close();
		$db->close();
		
		return $newcommentid;
	}

	//Insert into the database
	function pingupdate(){
		$url = 'https://status.abre.io/installation.php';
		$ch = curl_init($url);
		$jsonData = array(
		    'Domain' => "$portal_root"
		);
		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
	}

	//Save Screenshot to server
	function savescreenshot($website, $filename){
		//Get Image and Use Google Page Speed API
		$website = $website;
		$api = "https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$website&screenshot=true";
		$string = file_get_contents($api);
		$json = json_decode($string, true);

		//Get Data from JSON
		$data = $json['screenshot']['data'];

		//Replace characters for correct decode
		$data = str_replace("_","/",$data);
		$data = str_replace("-","+",$data);

		//Decode base64
		$data = base64_decode($data);

		//Save image to server
		$im = imagecreatefromstring($data);
		if(!file_exists("../../../$portal_private_root/guide")){
			mkdir("../../../$portal_private_root/guide", 0777, true);
		}
		imagejpeg($im, "../../../$portal_private_root/guide/$filename");
	}

	//Retrieve Site Title
	//DEPRECIATED
	function sitesettings($value){
		include "abre_dbconnect.php";
		if(!$result = $db->query("SELECT * FROM settings")){
	  		$sql = "CREATE TABLE `settings` (`id` int(11) NOT NULL,`options` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	  		$sql .= "INSERT INTO `settings` (`id`, `options`) VALUES (1, '');";
	  		$sql .= "ALTER TABLE `settings` ADD PRIMARY KEY (`id`);";
	  		$sql .= "ALTER TABLE `settings` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
	  		$db->multi_query($sql);
		}

		$sql2 = "SELECT * FROM settings LIMIT 1";
		$result2 = $db->query($sql2);
		if($result2){
			while($row = $result2->fetch_assoc()){
				$options = $row["options"];
				if($options != ""){
					$options = json_decode($options);
					if(isset($options->$value)){
						$valuereturn = $options->$value;
					}else{
						$valuereturn = "";
					}
				}else{
					$valuereturn = "";
				}
				if(($value == "googleclientsecret" && $valuereturn != "") || ($value == "facebookclientsecret" && $valuereturn != "")
				    || ($value == "microsoftclientsecret" && $valuereturn != "")){
					$valuereturn = decrypt($valuereturn, '');
				}
				if($value == "sitetitle" && $valuereturn == ""){ $valuereturn = "Abre"; }
				if($value == "sitecolor" && $valuereturn == ""){ $valuereturn = "#2B2E4A"; }
				if($value == "sitedescription" && $valuereturn == ""){ $valuereturn = "Abre Open Platform for Education"; }
				if($value == "sitelogintext" && $valuereturn == ""){ $valuereturn = "Open Platform for Education"; }
				if($value == "siteanalytics" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "siteadminemail" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "sitevendorlinkurl" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "sitevendorlinkidentifier" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "sitevendorlinkkey" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "certicabaseurl" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "certicaaccesskey" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "studentdomain" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "studentdomainrequired" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "sitelogo" && $valuereturn !=""){
					if($valuereturn != '/core/images/abre_glyph.png'){
						$valuereturn = "/content/$valuereturn";
					}else{
						$valuereturn="/core/images/abre_glyph.png";
					}
				}
				if($value == "sitelogo" && $valuereturn == ""){ $valuereturn = "/core/images/abre_glyph.png"; }
				if($value == "googleclientid" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "parentaccess" && $valuereturn == ""){ $valuereturn = "unchecked"; }
				if($value == "googleclientsecret" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "facebookclientid" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "facebookclientsecret" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "microsoftclientid" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "microsoftclientsecret" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "abre_community" && $valuereturn == ""){ $valuereturn = "unchecked"; }
				if($value == "community_first_name" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "community_last_name" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "community_email" && $valuereturn == ""){ $valuereturn = ""; }
				if($value == "community_users" && $valuereturn == ""){ $valuereturn = ""; }
			}
		}
		$db->close();
		return $valuereturn;
	}

	function getSettingsDbValue($value){
		include "abre_dbconnect.php";
		$sql2 = "SELECT * FROM settings LIMIT 1";
		$result2 = $db->query($sql2);
		if($result2){
			$row = $result2->fetch_assoc();
			$options = $row["options"];
			if($options != ""){
				$options = json_decode($options);
				if(isset($options->$value)){
					$valuereturn = $options->$value;
				}else{
					$valuereturn = "";
				}
			}else{
				$valuereturn = "";
			}
		}else{
			$sql = "CREATE TABLE `settings` (`id` int(11) NOT NULL,`options` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "INSERT INTO `settings` (`id`, `options`) VALUES (1, '');";
			$sql .= "ALTER TABLE `settings` ADD PRIMARY KEY (`id`);";
			$sql .= "ALTER TABLE `settings` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);

			$valuereturn = "";
		}
		$db->close();
		return $valuereturn;
	}

	function getSiteTitle(){
		$valuereturn = getSettingsDbValue('sitetitle');
		if($valuereturn == ""){ $valuereturn = "Abre"; }

		return $valuereturn;
	}

	function getSiteColor(){
		$valuereturn = getSettingsDbValue('sitecolor');
		if($valuereturn == ""){ $valuereturn = "#2B2E4A"; }

		return $valuereturn;
	}

	function getSiteDescription(){
		$valuereturn = getSettingsDbValue('sitedescription');
		if($valuereturn == ""){ $valuereturn = "Abre Open Platform for Education"; }

		return $valuereturn;
	}

	function getSiteLoginText(){
		$valuereturn = getSettingsDbValue('sitelogintext');
		if($valuereturn == ""){ $valuereturn = "Open Platform for Education"; }

		return $valuereturn;
	}

	function getSiteAnalytics(){
		$valuereturn = getSettingsDbValue('siteanalytics');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}

	function getSiteAdminEmail(){
		$valuereturn = getSettingsDbValue('siteadminemail');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}

	function getSiteCerticaBaseUrl(){
		$valuereturn = getSettingsDbValue('certicabaseurl');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}

	function getSiteCerticaAccessKey(){
		$valuereturn = getSettingsDbValue('certicaaccesskey');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}

	function getSiteStudentDomain(){
		$valuereturn = getSettingsDbValue('studentdomain');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}

	function getSiteStudentDomainRequired(){
		$valuereturn = getSettingsDbValue('studentdomainrequired');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}

	function getSiteLogo(){
		$valuereturn = getSettingsDbValue('sitelogo');
		if($valuereturn == ""){
			$valuereturn = "/core/images/abre_glyph.png";
		}else{
			if($valuereturn != '/core/images/abre_glyph.png'){
				$valuereturn = "/content/$valuereturn";
			}else{
				$valuereturn="/core/images/abre_glyph.png";
			}
		}

		return $valuereturn;
	}

	function getSiteAbreCommunity(){
		$valuereturn = getSettingsDbValue('abre_community');
		if($valuereturn == ""){ $valuereturn = "unchecked"; }

		return $valuereturn;
	}

	function getSiteCommunityFirstName(){
		$valuereturn = getSettingsDbValue('community_first_name');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}

	function getSiteCommunityLastName(){
		$valuereturn = getSettingsDbValue('community_last_name');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}

	function getSiteCommunityEmail(){
		$valuereturn = getSettingsDbValue('community_email');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}

	function getSiteCommunityUsers(){
		$valuereturn = getSettingsDbValue('community_users');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}
	
	function getIntegrationsDbValue($value){
		include "abre_dbconnect.php";
		$sql2 = "SELECT integrations FROM settings LIMIT 1";
		$result2 = $db->query($sql2);
		if($result2){
			$row = $result2->fetch_assoc();
			$options = $row["integrations"];
			if($options != ""){
				$options = json_decode($options);
				if(isset($options->$value)){
					$valuereturn = $options->$value;
				}else{
					$valuereturn = "";
				}
			}else{
				$valuereturn = "";
			}
		}else{
			$sql = "ALTER TABLE `settings` ADD `integrations` text NOT NULL;";
			$db->multi_query($sql);
			$valuereturn = "";
		}
		$db->close();
		return $valuereturn;
	}

	function getSoftwareAnswersURL(){
		$valuereturn = getIntegrationsDbValue('softwareanswersurl');
		if($valuereturn == ""){ $valuereturn = ""; }
		return $valuereturn;
	}

	function getSoftwareAnswersIdentifier(){
		$valuereturn = getIntegrationsDbValue('softwareanswersidentifier');
		if($valuereturn == ""){ $valuereturn = ""; }
		return $valuereturn;
	}
	
	function getSoftwareAnswersKey(){
		$valuereturn = getIntegrationsDbValue('softwareanswerskey');
		if($valuereturn == ""){ $valuereturn = ""; }
		return $valuereturn;
	}
	
	function getParentAccessDbValue($value){
		include "abre_dbconnect.php";
		$sql2 = "SELECT parentaccess FROM settings LIMIT 1";
		$result2 = $db->query($sql2);
		if($result2){
			$row = $result2->fetch_assoc();
			$options = $row["parentaccess"];
			if($options != ""){
				$options = json_decode($options);
				if(isset($options->$value)){
					$valuereturn = $options->$value;
				}else{
					$valuereturn = "";
				}
			}else{
				$valuereturn = "";
			}
		}else{
			$sql = "ALTER TABLE `settings` ADD `parentaccess` text NOT NULL;";
			$db->multi_query($sql);
			$valuereturn = "";
		}
		$db->close();
		return $valuereturn;
	}

	function getSiteGoogleClientId(){
		$valuereturn = getParentAccessDbValue('googleclientid');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}

	function getSiteParentAccess(){
		$valuereturn = getParentAccessDbValue('parentaccess');
		if($valuereturn == ""){ $valuereturn = "unchecked"; }

		return $valuereturn;
	}

	function getSiteGoogleClientSecret(){
		$valuereturn = getParentAccessDbValue('googleclientsecret');
		if($valuereturn == ""){
			$valuereturn = "";
		}else{
			$valuereturn = decrypt($valuereturn, '');
		}

		return $valuereturn;
	}

	function getSiteFacebookClientId(){
		$valuereturn = getParentAccessDbValue('facebookclientid');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}

	function getSiteFacebookClientSecret(){
		$valuereturn = getParentAccessDbValue('facebookclientsecret');
		if($valuereturn == ""){
			$valuereturn = "";
		}else{
			$valuereturn = decrypt($valuereturn, '');
		}

		return $valuereturn;
	}

	function getSiteMicrosoftClientId(){
		$valuereturn = getParentAccessDbValue('microsoftclientid');
		if($valuereturn == ""){ $valuereturn = ""; }

		return $valuereturn;
	}

	function getSiteMicrosoftClientSecret(){
		$valuereturn = getParentAccessDbValue('microsoftclientsecret');
		if($valuereturn == ""){
			$valuereturn = "";
		}else{
			$valuereturn = decrypt($valuereturn, '');
		}

		return $valuereturn;
	}

	function linkify($value, $protocols = array('http', 'mail'), array $attributes = array()){
		// Link attributes
		$attr = '';
    foreach($attributes as $key => $val){
        $attr = ' ' . $key . '="' . htmlentities($val) . '"';
    }
    $links = array();

    // Extract existing links and tags
    $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links){ return '<' . array_push($links, $match[1]) . '>'; }, $value);

    // Extract text links for each protocol
    foreach ((array)$protocols as $protocol){
        switch ($protocol){
            case 'http':
            case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { if ($match[1]) $protocol = $match[1]; $link = $match[2] ?: $match[3]; return '<' . array_push($links, "<a $attr href=\"$protocol://$link\" target=\"_blank\" style='color: ".getSiteColor()."'>$link</a>") . '>'; }, $value); break;
            case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\" target=\"_blank\" style='color: ".getSiteColor()."'>{$match[1]}</a>") . '>'; }, $value); break;
            case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\" target=\"_blank\" style='color: ".getSiteColor()."'>{$match[0]}</a>") . '>'; }, $value); break;
            default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\" target=\"_blank\" style='color: ".getSiteColor()."'>{$match[1]}</a>") . '>'; }, $value); break;
        }
    }
    // Insert all link
    return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links){ return $links[$match[1] - 1]; }, $value);
  }

	//Insert into the database
	function vendorLinkGet($call){
		$VendorLinkURL = getSiteVendorLinkUrl();
		$vendorIdentifier = getSiteVendorLinkIdentifier();
		$vendorKey = getSiteVendorLinkKey();
		$userID = "";
		$requestDate = gmdate('D, d M Y H:i:s').' GMT';
		$userName = $vendorIdentifier."|".$userID."|".$requestDate;
		$password = $vendorIdentifier.$userID.$requestDate.$vendorKey;
		$hmacData = $vendorIdentifier.$userID.$requestDate.$vendorKey;
		$hmacSignature = base64_encode(pack("H*", sha1($hmacData)));
		$vlauthheader = $vendorIdentifier."||".$hmacSignature;

		$url = $call;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('VL-Authorization: '.$vlauthheader, 'Date: '.$requestDate));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$json = json_decode($result,true);

		return $json;
	}

	//Insert into the database
	function vendorLinkPost($call,$fields){
		$VendorLinkURL = getSoftwareAnswersURL();
		$vendorIdentifier = getSoftwareAnswersIdentifier();
		$vendorKey = getSoftwareAnswersKey();
		$userID = "";
		$requestDate = gmdate('D, d M Y H:i:s').' GMT';
		$userName = $vendorIdentifier."|".$userID."|".$requestDate;
		$password = $vendorIdentifier.$userID.$requestDate.$vendorKey;
		$hmacData = $vendorIdentifier.$userID.$requestDate.$vendorKey;
		$hmacSignature = base64_encode(pack("H*", sha1($hmacData)));
		$vlauthheader = $vendorIdentifier."||".$hmacSignature;

		$url = $call;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('VL-Authorization: '.$vlauthheader, 'Date: '.$requestDate));
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$json = json_decode($result,true);

		return $json;
	}

?>