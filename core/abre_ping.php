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

  require_once(dirname(__FILE__) . '/../configuration.php');
  require_once(dirname(__FILE__) . '/abre_functions.php');

	$url = 'https://status.abre.io/installation.php';
	$ch = curl_init($url);
	$jsonData = array(
		'Domain' => "$portal_root",
		'community_first_name' => sitesettings('community_first_name'),
		'community_last_name' => sitesettings('community_last_name'),
		'community_email' => sitesettings('community_email'),
		'community_users' => sitesettings('community_users')
	);
	$jsonDataEncoded = json_encode($jsonData);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result = curl_exec($ch);

?>