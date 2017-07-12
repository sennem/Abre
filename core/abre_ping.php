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

  require_once(dirname(__FILE__) . '/../configuration.php');

	$url = 'https://status.abre.io/installation.php';
	$ch = curl_init($url);
	$jsonData = array(
		'Domain' => "$portal_root",
		'community_first_name' => $_POST['community_first_name'],
		'community_last_name' => $_POST['community_last_name'],
		'community_email' => $_POST['community_email'],
		'community_users' => $_POST['community_users']
	);
	$jsonDataEncoded = json_encode($jsonData);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result = curl_exec($ch);

?>
