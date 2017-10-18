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

  if(session_id() == ''){ session_start(); }
  require_once(dirname(__FILE__) . '/../configuration.php');
  require_once('abre_functions.php');
  require_once('abre_parent_google_authentication.php');

  try{
    if(isset($_GET['code'])){
      $client->fetchAccessTokenWithAuthCode($_GET['code']);
      $_SESSION['google_parent_access_token'] = $client->getAccessToken();
      $pagelocation = $portal_root;
      if(isset($_SESSION["redirecturl"])){ header("Location: $pagelocation/#".$_SESSION["redirecturl"]); }else{ header("Location: $pagelocation"); }
    }

    if(isset($_SESSION['google_parent_access_token'])){
      $client->setAccessToken($_SESSION['google_parent_access_token']);
    }

    //Get basic user information if they are logged in
    if(isset($_SESSION['google_parent_access_token'])){
      if(!isset($_SESSION['useremail'])){
        $client->setAccessToken($_SESSION['google_parent_access_token']);
        $userData = $Service_Oauth2->userinfo->get();
        $userEmail = $userData["email"];
        $_SESSION['useremail'] = $userEmail;
        $_SESSION['picture'] = sitesettings('sitelogo');
        $_SESSION['usertype'] = 'parent';

        $me = $Service_Plus->people->get('me');
        $displayName = $me['displayName'];
        $_SESSION['displayName'] = $displayName;
      }
    }

    if(isset($_SESSION['google_parent_access_token'])){
      if($_SESSION['usertype'] != ""){
        include "abre_dbconnect.php";
        if($result = $db->query("SELECT * FROM users_parent WHERE email='".$_SESSION['useremail']."'")){
          $count = $result->num_rows;
          if($count >= 1){
            $sql = "SELECT * FROM users_parent WHERE email='".$_SESSION['useremail']."' AND students=''";
            $result = $db->query($sql);
            $numrows = $result->num_rows;
            if($numrows == 0){
              mysqli_query($db, "INSERT INTO users_parent (email, students, studentId) VALUES ('".$_SESSION['useremail']."', '', '')") or die (mysqli_error($db));
            }

            //If not already logged in, check and get a refresh token
            if(!isset($_SESSION['loggedin'])){ $_SESSION['loggedin'] = ""; }
            if($_SESSION['loggedin'] != "yes"){
              //Mark that they have logged in
              $_SESSION['loggedin'] = "yes";
            }
          }else{
            $sha1useremail = sha1($_SESSION['useremail']);
            $storetoken = $sha1useremail.$hash;
            mysqli_query($db, "INSERT INTO users_parent (email, students, studentId) VALUES ('".$_SESSION['useremail']."', '', '')") or die (mysqli_error($db));
          }
        }
        $db->close();
      }
    }
  }catch(Exception $x){
    if(strpos($x->getMessage(), 'Invalid Credentials')){
      //Destroy the OAuth & PHP session
      session_destroy();
      $client->revokeToken();

      //Redirect user
      header("Location: $portal_root");
    }
    if(strpos($x->getMessage(), 'Invalid Credentials')){
      //Destroy the OAuth & PHP session
      session_destroy();
      $client->revokeToken();

      //Redirect user
      header("Location: $portal_root");
    }
  }

  header("Location: $portal_root");

?>