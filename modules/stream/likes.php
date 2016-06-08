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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');	
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');	
	
	//Get User Settings
	$query = "SELECT * FROM profiles where email='".$_SESSION['useremail']."'";
	$gafecards = databasequery($query);
	foreach ($gafecards as $value) {
		$setting_card_mail=htmlspecialchars($value['card_mail'], ENT_QUOTES);
		$setting_card_drive=htmlspecialchars($value['card_drive'], ENT_QUOTES);
		$setting_card_calendar=htmlspecialchars($value['card_calendar'], ENT_QUOTES);
		$setting_card_classroom=htmlspecialchars($value['card_classroom'], ENT_QUOTES);
		$setting_card_apps=htmlspecialchars($value['card_apps'], ENT_QUOTES);
	}

	//Display the Likes
	echo "<div id='streamlikes'></div>";

?>

<script>
	
	//Load Streams
	function loadLikes()
	{
		$('#streamlikes').load("modules/stream/stream_likes.php", function () {	
			init_page();
		});	
	}
	loadLikes();
		
</script>