<?php

  if(session_id() == ''){ session_start(); }
  require_once(dirname(__FILE__) . '/../configuration.php');
  require_once('abre_functions.php');
  require(dirname(__FILE__). '/facebook/src/Facebook/autoload.php');

  $fb = new Facebook\Facebook([
    'app_id' => '1437651372975104', // Replace {app-id} with your app id
    'app_secret' => '9f1fcbb500aec4aca39d95ca672823df',
    'default_graph_version' => 'v2.9',
  ]);

  $helper = $fb->getRedirectLoginHelper();

  try {
    $accessToken = $helper->getAccessToken();
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }

  if (!isset($accessToken)) {
    if ($helper->getError()) {
      header('HTTP/1.0 401 Unauthorized');
      echo "Error: " . $helper->getError() . "\n";
      echo "Error Code: " . $helper->getErrorCode() . "\n";
      echo "Error Reason: " . $helper->getErrorReason() . "\n";
      echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
      header('HTTP/1.0 400 Bad Request');
      echo 'Bad request';
    }
    exit;
  }

  // Logged in
  echo '<h3>Access Token</h3>';
  $_SESSION['access_token'] = $accessToken->getValue();
  $pagelocation=$portal_root;
  if(isset($_SESSION["redirecturl"])){ header("Location: $pagelocation/#".$_SESSION["redirecturl"]); }else{ header("Location: $pagelocation"); }

  $response = $fb->get('/me?fields=name,email', $accessToken->getValue());
  $user = $response->getGraphUser();
  $userid = $user['id'];
  $revokeCall = '/'. $userid .'/permissions';

try{

  // access token but useremail not set
  if(isset($_SESSION['access_token']))
  {
    if(!isset($_SESSION['useremail']))
    {
      $_SESSION['useremail']=$user['email'];
      $_SESSION['usertype']= 'parent';
      $_SESSION['displayName']= $user['name'];
    }
  }else{
    header("Location: $pagelocation");
  }

  if (isset($_SESSION['access_token']))
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
    $fb->api($revokeCall, "DELETE", $accessToken);
    //$client->revokeToken();

    //Redirect user
    header("Location: $portal_root");

  }

  if(strpos($x->getMessage(), 'Invalid Credentials'))
  {

    //Destroy the OAuth & PHP session
    session_destroy();
    $fb->api($revokeCall, "DELETE", $accessToken);
    //$client->revokeToken();

    //Redirect user
    header("Location: $portal_root");
  }

}
  // The OAuth 2.0 client handler helps us manage access tokens
  $oAuth2Client = $fb->getOAuth2Client();
  // Get the access token metadata from /debug_token
  $tokenMetadata = $oAuth2Client->debugToken($accessToken);
  echo '<h3>Metadata</h3>';
  var_dump($tokenMetadata);

  // Validation (these will throw FacebookSDKException's when they fail)
  $tokenMetadata->validateAppId('9f1fcbb500aec4aca39d95ca672823df'); // Replace {app-id} with your app id
  // If you know the user ID this access token belongs to, you can validate it here
  //$tokenMetadata->validateUserId('123');
  $tokenMetadata->validateExpiration();

  if (! $accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
      $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
      echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
      exit;
    }

    echo '<h3>Long-lived</h3>';
    var_dump($accessToken->getValue());
  }

  $_SESSION['fb_access_token'] = (string) $accessToken;

  // User is logged in with a long-lived access token.
  // You can redirect them to a members-only page.
  //header('Location: https://example.com/members.php');


 ?>
