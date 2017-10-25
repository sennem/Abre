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

    //Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	//Setup tables if new module
	if(!$resultstreams = $db->query("SELECT * FROM streams")){
		$sql = "CREATE TABLE `streams` (`id` int(11) NOT NULL,`group` text NOT NULL,`title` text NOT NULL,`slug` text NOT NULL,`type` text NOT NULL,`url` text NOT NULL,`required` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$sql .= "ALTER TABLE `streams` ADD PRIMARY KEY (`id`);";
		$sql .= "ALTER TABLE `streams` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
		$sql .= "INSERT INTO `streams` (`id`, `group`, `title`, `slug`, `type`, `url`, `required`) VALUES (NULL, 'staff', 'Resident Educator', 'residenteducator', 'flipboard', 'https://flipboard.com/@loripierson/hcsd-resident-educator-resources-ani2c718y.rss', '0');";
		$sql .= "INSERT INTO `streams` (`id`, `group`, `title`, `slug`, `type`, `url`, `required`) VALUES (NULL, 'staff', 'Technology', 'technology', 'flipboard', 'https://flipboard.com/@chrisrose64f0/hcsd-technology-i29k1hsdy.rss', '0');";
		$sql .= "INSERT INTO `streams` (`id`, `group`, `title`, `slug`, `type`, `url`, `required`) VALUES (NULL, 'staff', 'ESL', 'esl', 'flipboard', 'https://flipboard.com/@corbinmoores2ri/esl-education-of3dj066y.rss', '0');";
		if ($db->multi_query($sql) === TRUE) { }
	}

	//Setup tables if new module
	if(!$resultstreamscomments = $db->query("SELECT * FROM streams_comments")){
		$sql = "CREATE TABLE `streams_comments` (`id` int(11) NOT NULL AUTO_INCREMENT,`url` text NOT NULL,`title` text NOT NULL,`image` text NOT NULL,`user` text NOT NULL,`comment` text NOT NULL,`creationtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,`liked` int(11) NOT NULL DEFAULT '0', PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1";
  		if ($db->multi_query($sql) === TRUE) { }
	}

	$pageview = 1;
	$drawerhidden = 0;
	$pageorder = 1;
	$pagetitle = "Home";
	$pageicon = "home";
	$pagepath = "";
	$pagerestrictions = "";

?>