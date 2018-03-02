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

  if(session_id() == ''){ session_start(); }
  require_once(dirname(__FILE__) . '/../configuration.php');
  require_once('abre_functions.php');

  if(!isset($_POST['code'])){
    $clientId = getSiteMicrosoftClientId();
    $url = "https://login.microsoftonline.com/common/oauth2/v2.0/authorize?client_id=".$clientId."&response_type=code&redirect_uri=".$portal_root."/core/abre_microsoft_login.php&response_mode=form_post&scope=openid%20profile%20offline_access%20user.read%20calendars.read%20files.read%20mail.read&state=12345";
    header("Location: $url");
  }else{
    if(!isset($_SESSION['usertype'])){ $_SESSION['usertype'] = ""; }

    //Load configuration settings
    $studentdomain = getSiteStudentDomain();
    $studentdomainrequired = getSiteStudentDomainRequired();

    $cookie_name = constant("PORTAL_COOKIE_NAME");
    $site_domain = constant("SITE_GAFE_DOMAIN");

    $fields = array(
      'client_id' => urlencode(getSiteMicrosoftClientId()),
      'redirect_uri' => urlencode($portal_root . '/core/abre_microsoft_login.php'),
      'grant_type' => urlencode('authorization_code'),
      'client_secret' => urlencode(getSiteMicrosoftClientSecret()),
      'code' => urlencode($_POST['code']),
      'scope' => urlencode('openid profile user.read mail.read calendars.read files.read offline_access')
    );

    //url-ify the data for the POST
    $fields_string = "";
    foreach($fields as $key=>$value){
      $fields_string .= $key.'='.$value.'&';
    }
    rtrim($fields_string, '&');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://login.microsoftonline.com/common/oauth2/v2.0/token");
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);

    $accessTokenJson = $result;
    $accessTokenArray = json_decode($accessTokenJson, true);
    $idToken = $accessTokenArray['id_token'];
    $accessToken = $accessTokenArray['access_token'];

    $payload = explode(".", $idToken);
    $info = $payload[1];

    //Logged in
    $infoString = base64_decode($info);
    $infoObject = json_decode($infoString);
    $_SESSION['access_token'] = $accessTokenArray;
    $_SESSION['auth_service'] = "microsoft";
    $pagelocation = $portal_root;

    if(isset($_SESSION["redirecturl"])){
      header("Location: $pagelocation/#".$_SESSION["redirecturl"]);
    }else{
      header("Location: $pagelocation");
    }

    try{
      if(isset($_SESSION['access_token'])){
        if(!isset($_SESSION['useremail'])){
          $_SESSION['auth_service'] = "microsoft";
          $_SESSION['useremail'] = $infoObject->preferred_username;
          $_SESSION['displayName'] = $infoObject->name;
          if($_SESSION["usertype"] != 'parent' || !isset($_SESSION["usertype"])){

            $_SESSION['picture'] = $portal_root.'/core/images/abre/profile.png';

            //get usertype
            if($studentdomain == NULL){ $studentdomain = $site_domain; }
            $userdomain = substr($_SESSION['useremail'], strpos($_SESSION['useremail'], '@'));
            $username = substr($_SESSION['useremail'], 0, strpos($_SESSION['useremail'], '@'));
            if($site_domain == $studentdomain){
              //Check for required chracters (if any)
              if(strcspn($username, $studentdomainrequired) != strlen($username)){
                $_SESSION['usertype'] = "student";
              }else if(strpos($site_domain, $userdomain) !== false || strpos($userdomain, $site_domain) !== false){
                $_SESSION['usertype'] = "staff";
              }
            }else{
              if($studentdomainrequired == "" && (strpos($_SESSION['useremail'], $studentdomain) !== false)){
                $_SESSION['usertype'] = "student";
              }else{
                if((strpos($_SESSION['useremail'], $studentdomain) !== false) && strcspn($username, $studentdomainrequired) != strlen($username)){
                  $_SESSION['usertype'] = "student";
                }else if(strpos($site_domain, $userdomain) !== false){
                  $_SESSION['usertype'] = "staff";
                }
              }
            }
          }else{
            //we already know the user is a parent but set to ensure.
            $_SESSION['auth_service'] = "microsoft";
            $_SESSION['usertype'] = "parent";
            $_SESSION['picture'] = getSiteLogo();
          }
        }
        if($_SESSION['usertype'] != ""){
          include "abre_dbconnect.php";
          if($_SESSION['usertype'] == "parent"){
            if($result = $db->query("SELECT COUNT(*) FROM users_parent WHERE email = '".$_SESSION['useremail']."'")){
              $resultrow = $result->fetch_assoc();
              $count = $resultrow["COUNT(*)"];

              if($count == 1){
                //If not already logged in, check and get a refresh token
                if(!isset($_SESSION['loggedin'])){ $_SESSION['loggedin'] = ""; }
                if($_SESSION['loggedin'] != "yes"){
                  //Mark that they have logged in
                  $_SESSION['loggedin'] = "yes";
                }
              }else{
                $stmt = $db->stmt_init();
                $sql = "INSERT INTO users_parent (email) VALUES (?)";
                $stmt->prepare($sql);
                $stmt->bind_param("s", $_SESSION['useremail']);
                $stmt->execute();
                $stmt->close();
                $_SESSION['loggedin'] = "yes";
              }
            }
            $db->close();
          }else{
            if($result = $db->query("SELECT COUNT(*) FROM users WHERE email = '".$_SESSION['useremail']."' AND `refresh_token` LIKE '%refresh_token%' AND `auth_service` = '".$_SESSION['auth_service']."'")){
              $resultrow = $result->fetch_assoc();
              $count = $resultrow["COUNT(*)"];

              if($count == 1){
                //If not already logged in, check and get a refresh token
                if(!isset($_SESSION['loggedin'])) { $_SESSION['loggedin'] = ""; }
                if($_SESSION['loggedin'] != "yes"){
                  //Update the token (if contains refresh_token)
                  $getTokenKeyOnly = $_SESSION['access_token'];
                  $refreshTokenKey = json_encode($getTokenKeyOnly);
                  if($refreshTokenKey != ""){
                    if(strpos($refreshTokenKey, 'refresh_token') !== false){
                      $stmt = $db->stmt_init();
                      $sql = "UPDATE users SET refresh_token = ? WHERE email = ? AND auth_service = ?";
                      $stmt->prepare($sql);
                      $stmt->bind_param("sss", $refreshTokenKey, $_SESSION['useremail'], $_SESSION['auth_service']);
                      $stmt->execute();
                      $stmt->close();
                    }
                  }

                  //Get the token from the database
                  $getRefreshToken = mysqli_fetch_assoc(mysqli_query($db, "SELECT refresh_token FROM users WHERE email = '".$_SESSION['useremail']."' AND auth_service = '".$_SESSION['auth_service']."'"));
                  $refreshtoken = $getRefreshToken['refresh_token'];
                  $refreshtoken = json_decode($refreshtoken, true);
                  $_SESSION['access_token'] = $refreshtoken;

                  //Set cookie for 7 days
                  $sha1useremail = sha1($_SESSION['useremail']);
                  $cookiekey = constant("PORTAL_COOKIE_KEY");
                  $hash = sha1($cookiekey);
                  $storetoken = $sha1useremail.$hash;
                  setcookie($cookie_name, $storetoken, time()+86400 * 7, '/', '', true, true);

                  //Mark that they have logged in
                  $_SESSION['loggedin'] = "yes";
                }
              }else{

                $stmt = $db->stmt_init();
                $sql = "DELETE FROM users WHERE email = ? AND auth_service = ?";
                $stmt->prepare($sql);
                $stmt->bind_param("ss", $_SESSION['useremail'], $_SESSION['auth_service']);
                $stmt->execute();
                $stmt->close();

                $getTokenKeyOnly = json_encode($_SESSION['access_token']);

                //Insert Token if contains refresh_token, otherwise, force consent
                if(strpos($getTokenKeyOnly, 'refresh_token') !== false){
                  $sha1useremail = sha1($_SESSION['useremail']);
                  $cookiekey = constant("PORTAL_COOKIE_KEY");
                  $hash = sha1($cookiekey);
                  $storetoken = $sha1useremail.$hash;

                  $stmt = $db->stmt_init();
                  $sql = "INSERT INTO users (email, refresh_token, cookie_token, auth_service) VALUES (?, ?, ?, ?)";
                  $stmt->prepare($sql);
                  $stmt->bind_param("ssss", $_SESSION['useremail'], $getTokenKeyOnly, $storetoken, $_SESSION['auth_service']);
                  $stmt->execute();
                  $stmt->close();

                  //Set cookie for 7 days
                  setcookie($cookie_name, $storetoken, time()+86400 * 7, '/', '', true, true);
                }else{
                  //Remove cookies and destroy session
                  if(isset($_SERVER['HTTP_COOKIE'])){
                    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                    foreach($cookies as $cookie){
                      $parts = explode('=', $cookie);
                      $name = trim($parts[0]);
                      setcookie($name, '', time()-1000);
                      setcookie($name, '', time()-1000, '/');
                    }
                  }
                  header("Location: $portal_root");
                }
              }
            }
          }
        }else{
          $_SESSION['usertype'] = NULL;
          $_SESSION['useremail'] = NULL;
          header("Location: $portal_root?signout");
        }
      }else{
        $_SESSION['usertype'] = NULL;
        $_SESSION['useremail'] = NULL;
        header("Location: $portal_root?signout");
      }
    }catch(Exception $x){
      if(strpos($x->getMessage(), 'Invalid Credentials')){
        session_destroy();

        //Redirect user
        header("Location: $portal_root");
      }
      if(strpos($x->getMessage(), 'Invalid Credentials')){
        //Destroy the OAuth & PHP session
        session_destroy();

        //Redirect user
        header("Location: $portal_root");
      }
    }

    header("Location: $portal_root");

  }

?>