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

		//Add the app
		$appid=$_POST["id"];
		$appname=mysqli_real_escape_string($db, $_POST["name"]);
		$applink=mysqli_real_escape_string($db, $_POST["link"]);
		$appicon=$_POST["icon"];
		$appicon = str_replace("thumb_", "", $appicon);
		$appstaff=$_POST["staff"];
		$appstudents=$_POST["students"];
		$appparents = $_POST["parents"];
		$appminors=$_POST["minors"];


		if($appid=="")
		{
			$stmt = $db->stmt_init();
			$sql = "INSERT INTO apps (title,link,icon,image,staff,student,minor_disabled,required,parent) VALUES ('$appname','$applink','$appicon','$appicon','$appstaff','$appstudents','$appminors','1','$appparents');";
			$stmt->prepare($sql);
			$stmt->execute();
			$stmt->close();
			$db->close();
		}
		else
		{
			mysqli_query($db, "UPDATE apps set title='$appname', link='$applink', icon='$appicon', image='$appicon', staff='$appstaff', student='$appstudents', minor_disabled='$appminors', parent='$appparents' where id='$appid'") or die (mysqli_error($db));
		}

	}

?>
