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
	
	
	require_once('abre_verification.php');
	require_once(dirname(__FILE__) . '/../configuration.php'); 
	
	function encrypt($string, $encryption_key){
		$encryption_key=constant("DB_KEY");
		$string = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $encryption_key, $string, MCRYPT_MODE_ECB)));
		return $string;
	}
	
	function decrypt($string, $encryption_key){
		$encryption_key=constant("DB_KEY");
		$string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $encryption_key, base64_decode($string), MCRYPT_MODE_ECB));
		return $string;
	}
	
	function finduserid($email){
		$email=encrypt($email, "");
		$sql = "SELECT *  FROM directory where email='$email'";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc())
		{
			$id=$row["id"];
			return $id;
		}
	}
	
	function finduseridcore($email){
		include "abre_dbconnect.php";
		$sql = "SELECT *  FROM users where email='".$_SESSION['useremail']."'";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc())
		{
			$id=$row["id"];
			return $id;
		}
	}
	
	function studentaccess(){
		$email = $_SESSION['useremail'];
		if(preg_replace('/[^0-9]+/', '', $email))
		{
			$gradyear = intval(preg_replace('/[^0-9]+/', '', $email), 10);
			$currentyear = date("y");
			$difference=$gradyear-$currentyear;
			if($difference<6){
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
		}
	}
	
?>