<?php

  if(session_id() == ''){ session_start(); }
  require_once(dirname(__FILE__) . '/../configuration.php');
  require_once('abre_functions.php');

  $fields = array(
  	'client_id' => urlencode(sitesettings('microsoftclientid')),
  	'redirect_uri' => urlencode('http://localhost/core/microsoft_login_helper.php'),
  	'grant_type' => urlencode('authorization_code'),
  	'client_secret' => urlencode(sitesettings('microsoftclientsecret')),
  	'code' => urlencode($_POST['code']),
  	'scope' => urlencode('openid profile')
  );

  //url-ify the data for the POST
  foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
  rtrim($fields_string, '&');

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://login.microsoftonline.com/common/oauth2/v2.0/token");
  curl_setopt($ch,CURLOPT_POST, count($fields));
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  $json = json_decode($result, true);
  $accessToken = $json['id_token'];
  $payload = explode(".", $accessToken);
  $info = $payload[1];

   //Logged in
   $infoString = base64_decode($info);
   $infoObject = json_decode($infoString);
   $_SESSION['microsoft_access_token'] = $accessToken;
   $pagelocation=$portal_root;
   if(isset($_SESSION["redirecturl"])){ header("Location: $pagelocation/#".$_SESSION["redirecturl"]); }else{ header("Location: $pagelocation"); }

  try{

  // access token but useremail not set
  if(isset($_SESSION['microsoft_access_token']))
  {
    if(!isset($_SESSION['useremail']))
    {
      $_SESSION['useremail']=$infoObject->preferred_username;
      $_SESSION['usertype']= 'parent';
      $_SESSION['displayName']= $infoObject->name;
      $_SESSION['picture'] = sitesettings('sitelogo');
    }
  }else{
    //header("Location: $pagelocation");
  }

  if (isset($_SESSION['microsoft_access_token']))
  {
    if($_SESSION['usertype']!="")
    {
      include "abre_dbconnect.php";
      if($result=$db->query("SELECT * from users_parent where email='".$_SESSION['useremail']."'"))
      {
        $count=$result->num_rows;
        if($count=='1')
        {
          //If not already logged in, check and get a refresh token
          if (!isset($_SESSION['loggedin'])) { $_SESSION['loggedin']=""; }
          if($_SESSION['loggedin']!="yes")
          {
            //Mark that they have logged in
            $_SESSION['loggedin']="yes";
          }
        }
        else
        {
          $sha1useremail=sha1($_SESSION['useremail']);
          $storetoken=$sha1useremail.$hash;
          mysqli_query($db, "Insert into users_parent (email, students) VALUES ('".$_SESSION['useremail']."', '')") or die (mysqli_error($db));
        }

      }
      $db->close();
    }

  }
  }
  catch (Exception $x)
  {

  if(strpos($x->getMessage(), 'Invalid Credentials'))
  {


    session_destroy();

    //Redirect user
    header("Location: $portal_root");

  }

  if(strpos($x->getMessage(), 'Invalid Credentials'))
  {

    //Destroy the OAuth & PHP session
    session_destroy();

    //Redirect user
    header("Location: $portal_root");
  }

  }

  header("Location: $portal_root");
  // User is logged in with a long-lived access token.
  // You can redirect them to a members-only page.
  //header('Location: https://example.com/members.php');

?>
