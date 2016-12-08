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
    
    require_once(dirname(__FILE__) . '/../core/abre_functions.php');
    $studentdomain=sitesettings('studentdomain');
    $studentdomainrequired=sitesettings('studentdomainrequired');

	//Try to login the user, if they have revoke Google access, request access
	try
	{
	
		//Required configuration files
		require_once('abre_google_authentication.php');
		$cookie_name=constant("PORTAL_COOKIE_NAME");
		$site_domain=constant("SITE_GAFE_DOMAIN");
	
		//Signout the user
		if (isset($_REQUEST['signout'])){
			
			//Remove cookies and destroy session
			if (isset($_SERVER['HTTP_COOKIE'])) {
			    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
			    foreach($cookies as $cookie) {
			        $parts = explode('=', $cookie);
			        $name = trim($parts[0]);
			        setcookie($name, '', time()-1000);
			        setcookie($name, '', time()-1000, '/');
			    }
			}
			session_destroy();
			$client->revokeToken();
			
			//Redirect user
			header("Location: $portal_root");
			
		}
	
		//User is returning from closed browser that was logged in
		if (isset($_COOKIE[$cookie_name]) && !isset($_SESSION['access_token']))
		{
			include "abre_dbconnect.php";
			$HCSDOHcookievalue=$_COOKIE[$cookie_name];
			if($result=$db->query("SELECT * from users where cookie_token='$HCSDOHcookievalue'"))
			{	
				$getRefreshToken2=mysqli_fetch_assoc(mysqli_query($db,"SELECT refresh_token from users where cookie_token='$HCSDOHcookievalue'"));
				$refreshtoken2=$getRefreshToken2['refresh_token'];
				$refreshtoken2=json_decode($refreshtoken2,true);
				
				$client->setAccessToken($refreshtoken2); 
				$_SESSION['access_token']=$refreshtoken2;
				
				//Set Cookie for 7 Days
				setcookie($cookie_name,$HCSDOHcookievalue, time()+86400 * 7, '/', '', true, true);	
			}
			$db->close();
		}
		
		//Login the user
		if (isset($_GET['code']))
		{
			$client->fetchAccessTokenWithAuthCode($_GET['code']);  
			$_SESSION['access_token'] = $client->getAccessToken();
			$pagelocation=$portal_root;
			header("Location: $pagelocation");
		}     
	
		//Set access token to make request
		if (isset($_SESSION['access_token']))
		{
			$client->setAccessToken($_SESSION['access_token']);
		}
	
		//Get basic user information if they are logged in
		if(isset($_SESSION['access_token']) && $client->getAccessToken())
		{
			if(!isset($_SESSION['useremail']))
			{
				$client->setAccessToken($_SESSION['access_token']);
				$userData = $Service_Oauth2->userinfo->get();
				$userEmail=$userData["email"];
				$_SESSION['useremail']=$userEmail;
				$userPicture=$userData['picture'];
				$_SESSION['picture']=$userPicture;
				$_SESSION['usertype']=NULL;
				
				if($studentdomain==NULL){ $studentdomain=$site_domain; }
				if($site_domain==$studentdomain)
				{
					//Check for required chracters (if any)
					if(strcspn($_SESSION['useremail'], $studentdomainrequired) != strlen($_SESSION['useremail']))
					{
						$_SESSION['usertype']="student";
					}
					else
					{
						$_SESSION['usertype']="staff";
					}
				}
				else
				{
					if (strpos($_SESSION['useremail'], $site_domain) !== false){ $_SESSION['usertype']="staff"; }
					if (strpos($_SESSION['useremail'], $studentdomain) !== false){ $_SESSION['usertype']="student"; }
				}
				
				if ((strpos($_SESSION['useremail'], $site_domain) == false) && (strpos($_SESSION['useremail'], $studentdomain) == false)){ $_SESSION['usertype']=NULL; $_SESSION['useremail']=NULL; header("Location: $portal_root?signout"); }
				
				$me = $Service_Plus->people->get('me');
				$displayName = $me['displayName'];
				$_SESSION['displayName']=$displayName;
			}
		} else {
			$authUrl = $client->createAuthUrl();
		}
	
		//Save the user information to Abre users database
		if (isset($_SESSION['access_token']))
		{
			if($_SESSION['usertype']!="")
			{
				include "abre_dbconnect.php";
				if($result=$db->query("SELECT * from users where email='".$_SESSION['useremail']."'"))
				{	
					$count=$result->num_rows;
					if($count=='1')
					{
						//If not already logged in, check and get a refresh token
						if (!isset($_SESSION['loggedin'])) { $_SESSION['loggedin']=""; } 
						if($_SESSION['loggedin']!="yes")
						{
							
							//Update the token
							$getTokenKeyOnly = $_SESSION['access_token'];
							$refreshTokenKey=json_encode($getTokenKeyOnly);
							if($refreshTokenKey!="")
							{
								mysqli_query($db, "UPDATE users SET refresh_token='$refreshTokenKey' WHERE email='".$_SESSION['useremail']."'") or die (mysqli_error($db));
							}
							
							//Get the token from the database
							$getRefreshToken=mysqli_fetch_assoc(mysqli_query($db,"SELECT refresh_token from users where email='".$_SESSION['useremail']."'"));
							$refreshtoken=$getRefreshToken['refresh_token'];
							$client->setAccessToken($refreshtoken); 
							$refreshtoken=json_encode($refreshtoken);
							//$_SESSION['access_token']=$refreshtoken;
						
							//Set cookie for 7 days
							$sha1useremail=sha1($_SESSION['useremail']);
							$cookiekey=constant("PORTAL_COOKIE_KEY");
							$hash=sha1($cookiekey);
							$storetoken=$sha1useremail.$hash;
							setcookie($cookie_name,$storetoken, time()+86400 * 7, '/', '', true, true);	
							
							//Mark that they have logged in
							$_SESSION['loggedin']="yes";
							
						}		
					}
					else
					{
						$getTokenKeyOnly = json_encode($_SESSION['access_token']);
						$sha1useremail=sha1($_SESSION['useremail']);
						$cookiekey=constant("PORTAL_COOKIE_KEY");
						$hash=sha1($cookiekey);
						$storetoken=$sha1useremail.$hash;
						mysqli_query($db, "Insert into users (email, refresh_token, cookie_token) VALUES ('".$_SESSION['useremail']."', '$getTokenKeyOnly', '$storetoken')") or die (mysqli_error($db));
					
						//Set cookie for 7 days
						setcookie($cookie_name,$storetoken, time()+86400 * 7, '/', '', true, true);	
					}
			
				}
				
				//Abre setup - set first login to admin
				mysqli_query($db, "UPDATE users SET superadmin = 1 WHERE id = 1") or die (mysqli_error($db));
				
				$db->close();
			}
		}
	}
	catch (Exception $x)
	{
		
		if(strpos($x->getMessage(), 'Invalid Credentials'))
		{	
			//Remove cookies and destroy session
			if (isset($_SERVER['HTTP_COOKIE'])) {
			    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
			    foreach($cookies as $cookie) {
			        $parts = explode('=', $cookie);
			        $name = trim($parts[0]);
			        setcookie($name, '', time()-1000);
			        setcookie($name, '', time()-1000, '/');
			    }
			}
			session_destroy();
			$client->revokeToken();
			
			//Redirect user
			header("Location: $portal_root");
			
		}	
		
		if(strpos($x->getMessage(), 'Invalid Credentials'))
		{	
			//Remove cookies and destroy session
			if (isset($_SERVER['HTTP_COOKIE'])) {
			    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
			    foreach($cookies as $cookie) {
			        $parts = explode('=', $cookie);
			        $name = trim($parts[0]);
			        setcookie($name, '', time()-1000);
			        setcookie($name, '', time()-1000, '/');
			    }
			}
			
			//Destroy the OAuth & PHP session	
			session_destroy();
			$client->revokeToken();
			
			//Redirect user
			header("Location: $portal_root");
		}
		
	}
	
?>