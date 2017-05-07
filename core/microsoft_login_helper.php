<?php

  if(session_id() == ''){ session_start(); }
  require_once(dirname(__FILE__) . '/../configuration.php');
  require_once('abre_functions.php');

  $fields = array(
  	'client_id' => urlencode('92c0fe4c-9956-4f78-940d-f1922b9f2fc2'),
  	'redirect_uri' => urlencode('http://localhost/core/microsoft_login_helper.php'),
  	'grant_type' => urlencode('authorization_code'),
  	'client_secret' => urlencode('nAwj6mJDkMvc3ik6s6FRyPc'),
  	'code' => urlencode($_POST['code']),
  	'scope' => urlencode('openid')
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
  echo $result;
  echo $json['id_token'];

  function base64_url_decode($input)
  {
      return base64_decode(strtr($input, '-_,', '+/='));
  }
  //Logged in
  echo base64_url_decode($json['id_token']);
   $_SESSION['microsoft_access_token'] = base64_decode($json['id_token'], true);
   echo base64_decode($json['id_token'], true);
   $pagelocation=$portal_root;
   if(isset($_SESSION["redirecturl"])){ header("Location: $pagelocation/#".$_SESSION["redirecturl"]); }else{ header("Location: $pagelocation"); }


  // $response = $fb->get('/me?fields=name,email', $accessToken->getValue());
  // $user = $response->getGraphUser();
  // $userid = $user['id'];
  // $revokeCall = '/'. $userid .'/permissions';

  // try{
  //
  // // access token but useremail not set
  // if(isset($_SESSION['microsoft_access_token']))
  // {
  //   if(!isset($_SESSION['useremail']))
  //   {
  //     $_SESSION['useremail']=$user['email'];
  //     $_SESSION['usertype']= 'parent';
  //     $_SESSION['displayName']= $user['name'];
  //     $_SESSION['picture'] = sitesettings('sitelogo');
  //   }
  // }else{
  //   //header("Location: $pagelocation");
  // }
  //
  // if (isset($_SESSION['microsoft_access_token']))
  // {
  //   if($_SESSION['usertype']!="")
  //   {
  //     include "abre_dbconnect.php";
  //     if($result=$db->query("SELECT * from users_parent where email='".$_SESSION['useremail']."'"))
  //     {
  //       $count=$result->num_rows;
  //       if($count=='1')
  //       {
  //         //If not already logged in, check and get a refresh token
  //         if (!isset($_SESSION['loggedin'])) { $_SESSION['loggedin']=""; }
  //         if($_SESSION['loggedin']!="yes")
  //         {
  //           //Mark that they have logged in
  //           $_SESSION['loggedin']="yes";
  //         }
  //       }
  //       else
  //       {
  //         $sha1useremail=sha1($_SESSION['useremail']);
  //         $storetoken=$sha1useremail.$hash;
  //         mysqli_query($db, "Insert into users_parent (email, students) VALUES ('".$_SESSION['useremail']."', '')") or die (mysqli_error($db));
  //       }
  //
  //     }
  //     $db->close();
  //   }
  //
  // }
  // }
  // catch (Exception $x)
  // {
  //
  // if(strpos($x->getMessage(), 'Invalid Credentials'))
  // {
  //
  //
  //   session_destroy();
  //   $fb->api($revokeCall, "DELETE", $accessToken);
  //   //$client->revokeToken();
  //
  //   //Redirect user
  //   //header("Location: $portal_root");
  //
  // }
  //
  // if(strpos($x->getMessage(), 'Invalid Credentials'))
  // {
  //
  //   //Destroy the OAuth & PHP session
  //   session_destroy();
  //   $fb->api($revokeCall, "DELETE", $accessToken);
  //   //$client->revokeToken();
  //
  //   //Redirect user
  //   //header("Location: $portal_root");
  // }
  //
  // }
  //
  // header("Location: $portal_root");
  // // User is logged in with a long-lived access token.
  // // You can redirect them to a members-only page.
  // //header('Location: https://example.com/members.php');

?>
