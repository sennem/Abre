<?php

	/*
	* Copyright (C) 2016-2018 Abre.io Inc.
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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');
	require_once('permissions.php');

	if($pagerestrictions=="")
	{
		//Load Page Variables
		if(isset($_GET["GroupID"])){ $GroupID=htmlspecialchars($_GET["GroupID"], ENT_QUOTES); }else{ $GroupID=""; }
		if(isset($_GET["CourseCode"])){ $CourseCode=htmlspecialchars($_GET["CourseCode"], ENT_QUOTES); }else{ $CourseCode=""; }
		if(isset($_GET["SectionCode"])){ $SectionCode=htmlspecialchars($_GET["SectionCode"], ENT_QUOTES); }else{ $SectionCode=""; }
		if(isset($_GET["CounselingID"])){ $CounselingID=htmlspecialchars($_GET["CounselingID"], ENT_QUOTES); }else{ $CounselingID=""; }

		//Overview Windows
		echo "<div class='row'>";
			echo "<div class='col s12'>";
				include "overview_top.php";
			echo "</div>";
			echo "<div class='col s12'>";
				include "overview_attendance.php";
			echo "</div>";
		echo "</div>";
	}

?>
