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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	$query = "SELECT COUNT(*) FROM conduct_discipline where Owner = '".$_SESSION['useremail']."'";
	$dbreturn = $db->query($query);
	$resultrow = $dbreturn->fetch_assoc();
	$disciplinecount = $resultrow["COUNT(*)"];

	echo "<div class='row'>";
		echo "<div class='col l4 s12'>";
			echo "<div class='mdl-card mdl-shadow--2dp pointer link' style='width:100%; color:#fff; background-color: #FFC107;'>";
				echo "<div style='width:100%; background-color: #FF8F00;'><h5 class='center-align truncate'>Classroom</h5></div>";
				echo "<h1 class='center-align' style='font-size:70px; line-height:80px;'>0</h1>";
				echo "<a href='#conduct/classroom'></a>";
			echo "</div>";
		echo "</div>";
		echo "<div class='col l4 s12'>";
			echo "<div class='mdl-card mdl-shadow--2dp pointer link' style='width:100%; color:#fff; background-color: #4CAF50;'>";
				echo "<div style='width:100%; background-color: #2E7D32;'><h5 class='center-align truncate'>PBIS</h5></div>";
				echo "<h1 class='center-align' style='font-size:70px; line-height:80px;'>0</h1>";
				echo "<a href='#conduct/pbis'></a>";
			echo "</div>";
		echo "</div>";
		echo "<div class='col l4 s12'>";
			echo "<div class='mdl-card mdl-shadow--2dp pointer link' style='width:100%; color:#fff; background-color: #F44336;'>";
				echo "<div style='width:100%; background-color: #C62828;'><h5 class='center-align truncate'>Discipline</h5></div>";
				echo "<h1 class='center-align' style='font-size:70px; line-height:80px;'>$disciplinecount</h1>";
				echo "<a href='#conduct/discipline/open'></a>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
?>

<script>

	$(function(){
		$(".link").unbind().click(function(){
		    if($(this).find("a").length){
		        window.location.href = $(this).find("a:first").attr("href");
		    }
		});
	});

</script>