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
require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

if(superadmin())
{

  //Add the stream
  $streamid=$_POST["id"];
  $streamtitle=mysqli_real_escape_string($db, $_POST["title"]);
  $rsslink=mysqli_real_escape_string($db, $_POST["link"]);
  $streamgroup=mysqli_real_escape_string($db, $_POST["group"]);
  $required = mysqli_real_escape_string($db, $_POST["required"]);

  if($streamid=="")
  {
    $stmt = $db->stmt_init();
    //needed to backtick because SQL doesn't like when you use reserved words
    $sql = "INSERT INTO `streams` (`group`,`title`,`slug`,`type`,`url`,`required`) VALUES ('$streamgroup','$streamtitle','$streamtitle','flipboard','$rsslink','$required');";
    $stmt->prepare($sql);
    $stmt->execute();
    $stmt->close();
    $db->close();
  }
  else
  {
    //needed to backtick because SQL doesn't like when you use reserved words
    mysqli_query($db, "UPDATE `streams` set `group`='$streamgroup', `title`='$streamtitle', `slug`='$streamtitle', `type`='flipboard', `url`='$rsslink', `required`='$required' where `id`='$streamid'") or die (mysqli_error($db));
  }
}
?>
