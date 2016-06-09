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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');  
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	
	$streamUrl=$_POST["streamUrl"];
	$streamUrldecoded=base64_decode($streamUrl);
	$streamComment=$_POST["streamComment"];
	$streamTitleValue=$_POST["streamTitleValue"];
	$streamComment=htmlspecialchars($streamComment, ENT_QUOTES);
	
	$Commentspecial=nl2br(strip_tags(html_entity_decode($streamComment)));
	$Commentspecial=linkify($Commentspecial);
	
	$userposter=$_SESSION['useremail'];

	if($streamComment!="" && $streamTitleValue!="")
	{
		
		//Insert comment into database
		$sql = "INSERT INTO streams_comments (url, title, user, comment) VALUES ('$streamUrldecoded', '$streamTitleValue', '$userposter', '$streamComment');";
		$dbreturn = databaseexecute($sql);

		//Checks to see if anyone has already commented except user (beta)
		/*
		if($_SESSION['useremail']=='crose@hcsdoh.org' or $_SESSION['useremail']=='web@hcsdoh.org')
		{
			
			//Look up name given email from directory
			$userposterencrypted=encrypt($userposter, "");
			$sql2 = "SELECT firstname, lastname, picture FROM directory where email='$userposterencrypted'";
			$result2 = $db->query($sql2);
			$num_rows2 = mysql_num_rows($result2);
			while($row2 = $result2->fetch_assoc())
			{
				$firstname=htmlspecialchars($row2["firstname"], ENT_QUOTES);
				$firstname=stripslashes(htmlspecialchars(decrypt($firstname, ""), ENT_QUOTES));
				$lastname=htmlspecialchars($row2["lastname"], ENT_QUOTES);
				$lastname=stripslashes(htmlspecialchars(decrypt($lastname, ""), ENT_QUOTES));
				$userposter="$firstname $lastname";
			}
			
			$sql = "SELECT * FROM streams_comments where url='$streamUrldecoded' and user!='".$_SESSION['useremail']."' GROUP BY user DESC";
			$result = $db->query($sql);
			$setting_preferences=mysqli_num_rows($result);
			while($row = $result->fetch_assoc()) {
				
				$user=htmlspecialchars($row['user'], ENT_QUOTES);
				$subject = "$userposter replied to $streamTitleValue";
				$message = "Hello,<br><br>$userposter added a comment to $streamTitleValue.<br><br><i>\"$Commentspecial\"</i><br><br><a href='$portal_root/#discussion/$streamUrl'>See the comment thread</a>";
				
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: HCSD Portal <noreply@hcsdoh.org>' . "\r\n";
				mail($user,$subject,$message,$headers);
				
			}
		}
		*/
		
	
	}
	$streamUrldecoded=base64_encode($streamUrldecoded);
	echo $streamUrldecoded;
	
?>