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

	//Require the Google Configuration Settings
	require_once('portal_google_authentication.php');

	//Signout the User
	if (isset($_REQUEST['signout'])){
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
    		$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
        	$params["path"], $params["domain"],
        	$params["secure"], $params["httponly"]
		);
		}		
		//Remove All Cookies
		if (isset($_SERVER['HTTP_COOKIE'])) {
		    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		    foreach($cookies as $cookie) {
		        $parts = explode('=', $cookie);
		        $name = trim($parts[0]);
		        setcookie($name, '', time()-1000);
		        setcookie($name, '', time()-1000, '/');
		    }
		}	
		//Destroy the Session	
		session_destroy();
		$client->revokeToken();
		unset($_COOKIE["HCSD_Portal_V1"]);
		setcookie("HCSD_Portal_V1", '', time() - 3600);		
		header("Location: $portal_root");
	}

	//If Cookie Was Set and the Session is Not Set
	if (isset($_COOKIE["HCSD_Portal_V1"]) && !isset($_SESSION['access_token'])){
		include "portal_dbconnect.php";
		$HCSDOHcookievalue=$_COOKIE["HCSD_Portal_V1"];
		if($result=$db->query("SELECT * from users where cookie_token='$HCSDOHcookievalue'"))
		{	
			$getRefreshToken2=mysqli_fetch_assoc(mysqli_query($db,"SELECT refresh_token from users where cookie_token='$HCSDOHcookievalue'"));
			$refreshtoken2=$getRefreshToken2['refresh_token'];
			$client->setAccessToken($refreshtoken2); 
			$_SESSION['access_token']=$refreshtoken2;
			
			//Set Cookie for 7 Days
			setcookie("HCSD_Portal_V1",$HCSDOHcookievalue, time()+86400 * 7);
		}
		$db->close();
	}
	
	//Login the User
	if (isset($_GET['code'])){
		$client->authenticate($_GET['code']);  
		$_SESSION['access_token'] = $client->getAccessToken();  
		header("Location: $portal_root");
	}     

	//Set Access Token to Make Request
	if (isset($_SESSION['access_token'])){
		$client->setAccessToken($_SESSION['access_token']);
	}

	//If Logged In Get Basic User Information
	if(isset($_SESSION['access_token']) && $client->getAccessToken()){
		if(!isset($_SESSION['useremail']))
		{
			$client->setAccessToken($_SESSION['access_token']);
			$userData = $Service_Oauth2->userinfo->get();
			$userEmail=$userData["email"];
			$_SESSION['useremail']=$userEmail;
			$userPicture=$userData['picture'];
			$_SESSION['picture']=$userPicture;
			$_SESSION['usertype']="staff";
				if (strpos($_SESSION['useremail'],'@example.org') == false) { header("Location: $portal_root?signout");	}
				if (strcspn($_SESSION['useremail'], '0123456789') != strlen($_SESSION['useremail'])){ $_SESSION['usertype']="student"; }
			$me = $Service_Plus->people->get('me');
			$displayName = $me['displayName'];
			$_SESSION['displayName']=$displayName;
		}
	} else {
		$authUrl = $client->createAuthUrl();
	}

	//Save the Reset Token if Not Previously Saved
	if (isset($_SESSION['access_token'])) {
		if (strpos($_SESSION['useremail'],'@hcsdoh.org') != false){	
			include "portal_dbconnect.php";
			if($result=$db->query("SELECT * from users where email='".$_SESSION['useremail']."'"))
			{	
				$count=$result->num_rows;
				if($count=='1')
				{
					//If not already logged in, check and get a refresh token.
					if (!isset($_SESSION['loggedin'])) { $_SESSION['loggedin']=""; } 
					if($_SESSION['loggedin']!="yes")
					{
						
						//Update the Token if contains refresh
						$getTokenKeyOnly = json_decode($_SESSION['access_token']);
						$refreshTokenKey = $getTokenKeyOnly->{'refresh_token'};
						if($refreshTokenKey!="")
						{
							mysqli_query($db, "UPDATE users SET refresh_token='" . $_SESSION['access_token'] . "' WHERE email='".$_SESSION['useremail']."'") or die (mysqli_error($db));
						}
						
						//Get the Token from the Database
						$getRefreshToken=mysqli_fetch_assoc(mysqli_query($db,"SELECT refresh_token from users where email='".$_SESSION['useremail']."'"));
						$refreshtoken=$getRefreshToken['refresh_token'];
						$client->setAccessToken($refreshtoken); 
						$_SESSION['access_token']=$refreshtoken;
					
						//Set Cookie for 7 Days
						$sha1useremail=sha1($_SESSION['useremail']);
						$cookiekey=constant("PORTAL_COOKIE_KEY");
						$hash=sha1($cookiekey);
						$storetoken=$sha1useremail.$hash;
						setcookie("HCSD_Portal_V1",$storetoken, time()+86400 * 7);	
						
						//Mark that they have logged in
						$_SESSION['loggedin']="yes";
						
					}		
				}
				else
				{
					$sha1useremail=sha1($_SESSION['useremail']);
					$cookiekey=constant("PORTAL_COOKIE_KEY");
					$hash=sha1($cookiekey);
					$storetoken=$sha1useremail.$hash;
					mysqli_query($db, "Insert into users (email, refresh_token, cookie_token) VALUES ('".$_SESSION['useremail']."', '" . $_SESSION['access_token'] . "', '$storetoken')") or die (mysqli_error($db));
				
					//Set Cookie for 7 Days
					setcookie("HCSD_Portal_V1",$storetoken, time()+86400 * 7);
				}
		
			}
			$db->close();
		}
	}
	
?>