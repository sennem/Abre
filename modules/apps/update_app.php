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
		$appminors=$_POST["minors"];
		
		if($appid=="")
		{
			$stmt = $db->stmt_init();
			$sql = "INSERT INTO apps (title,link,icon,image,staff,student,minor_disabled,required) VALUES ('$appname','$applink','$appicon','$appicon','$appstaff','$appstudents','$appminors','1');";
			$stmt->prepare($sql);
			$stmt->execute();
			$stmt->close();
			$db->close();
		}
		else
		{
			mysqli_query($db, "UPDATE apps set title='$appname', link='$applink', icon='$appicon', image='$appicon', staff='$appstaff', student='$appstudents', minor_disabled='$appminors' where id='$appid'") or die (mysqli_error($db));
		}
		
	}
	
?>