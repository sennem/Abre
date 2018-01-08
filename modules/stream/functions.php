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

	//Display Widget
	function DisplayWidget($path,$icon,$title,$color){
		
		$Path = "/modules/$path/widget_content.php";

		echo "<ul class='widget mdl-card mdl-shadow--2dp hoverable' data-collapsible='accordion'>";
			echo "<li>";
				echo "<div class='collapsible-header' data-path='$Path' style='border-top: solid 3px $color;'>";
					echo "<i class='material-icons' style='color: $color'>$icon</i>";
					echo "<span style='color: #000'>$title</span>";
					echo "<i class='right material-icons' style='color: #666; margin-right:2px;'>expand_more</i>";		
				echo "</div>";
				echo "<div class='collapsible-body'></div>";
			echo "</li>";
  		echo "</ul>";		

	}

?>