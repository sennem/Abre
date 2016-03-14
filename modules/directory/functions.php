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
	require('permissions.php');
	require_once('../../core/abre_functions.php');
	
	//Predict Email
	function emailPrediction($first, $last)
	{
		//Construct Email Address
		$firstfirstchar=$first[0];
		$firstsecondchar=$first[1];
		$firstthirdchar=$first[2];
		$predictedemail=$firstfirstchar.$last."@hcsdoh.org";
		$predictedemail=strtolower($predictedemail);
		$predictedemailencrypted=encrypt($predictedemail, ""); 
		
		//Check to make sure email doesn't already exist
		include "../../configuration.php";
		include "../../core/abre_dbconnect.php";
		$sql = "SELECT *  FROM directory where email='$predictedemailencrypted'";
		$result = $db->query($sql);
		$count=0;
		$count=mysqli_num_rows($result);
		
		if($count==1)
		{
			$firstsecondchar=$first[1];
			$predictedemail=$firstfirstchar.$firstsecondchar.$last."@hcsdoh.org";
			$predictedemail=strtolower($predictedemail);
			
			//Check again
			$count=0;
			$predictedemailencrypted=encrypt($predictedemail, "");
			include "../../configuration.php";
			include "../../core/abre_dbconnect.php";
			$sql = "SELECT *  FROM directory where email='$predictedemailencrypted'";
			$result = $db->query($sql);
			$count=mysqli_num_rows($result);
			
			if($count==1)
			{
				$predictedemail=$firstfirstchar.$firstsecondchar.$firstthirdchar.$last."@hcsdoh.org";
				$predictedemail=strtolower($predictedemail);
				sendVarTekTicket($first, $last, $predictedemail);	
				return $predictedemail;
			}
			else
			{
				sendVarTekTicket($first, $last, $predictedemail);	
				return $predictedemail;
			}
			
		}
		else
		{		
			sendVarTekTicket($first, $last, $predictedemail);	
			return $predictedemail;
		}
		
	}
	
	function sendVarTekTicket($first, $last, $predictedemail)
	{
		//Send the VarTek Ticket to have account created.
		
		//$to = "helpdesk@vartek.com";
		$to = "chrislrose@gmail.com";
		$subject = "New User Account Needed for $first $last";
		$message = "Please create a new user account for:\n\n$first $last ($predictedemail).";
		$headers = "From: web@hcsdoh.org";
		mail($to,$subject,$message,$headers);
		
	}
	
?>