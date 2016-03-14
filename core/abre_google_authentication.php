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
	
	//Google API PHP library files
	require_once 'google-api-php-client-master/Google/autoload.php';
 
	//Create Client request to access Google API
	$client = new Google_Client();
	$client->setApplicationName("Abre");
	$client_id=constant("GOOGLE_CLIENT_ID");
	$client->setClientId($client_id);
	$client_secret=constant("GOOGLE_CLIENT_SECRET");
	$client->setClientSecret($client_secret);
	$redirect_uri=constant("GOOGLE_REDIRECT");
	$client->setRedirectUri($redirect_uri);
	$simple_api_key=constant("GOOGLE_API_KEY");
	$client->setDeveloperKey($simple_api_key);
	$client->setAccessType("offline");
	$client->setApprovalPrompt("force");
	$scopes=unserialize(constant("GOOGLE_SCOPES"));
	$client->setScopes($scopes);
	$hd=constant("GOOGLE_HD");
	$client->setHostedDomain($hd);

	//Send client requests
	$Service_Oauth2 = new Google_Service_Oauth2($client);
	$Service_Plus = new Google_Service_Plus($client);
	$Service_Gmail = new Google_Service_Gmail($client);
	$Service_Drive = new Google_Service_Drive($client);
	$Service_Calendar = new Google_Service_Calendar($client);
	$Service_Classroom = new Google_Service_Classroom($client);

?>