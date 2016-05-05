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
    
    echo "<script src='core/js/date.js'></script>";
    echo "<script src='core/js/jquery.datePicker.js'></script>";
	
	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 	
	require_once(dirname(__FILE__) . '/../../core/abre_google_login.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');	
	
	//Get profile information	
	$sql = "SELECT * FROM profiles where email='".$_SESSION['useremail']."'";
	$dbreturn = databasequery($sql);
	foreach ($dbreturn as $row)
	{
		$setting_startup=htmlspecialchars($row['startup'], ENT_QUOTES);
		$setting_streams=htmlspecialchars($row['streams'], ENT_QUOTES);
		$setting_card_mail=htmlspecialchars($row['card_mail'], ENT_QUOTES);
		$setting_card_drive=htmlspecialchars($row['card_drive'], ENT_QUOTES);
		$setting_card_calendar=htmlspecialchars($row['card_calendar'], ENT_QUOTES);
		$setting_card_classroom=htmlspecialchars($row['card_classroom'], ENT_QUOTES);
		$setting_card_apps=htmlspecialchars($row['card_apps'], ENT_QUOTES);
	}
	
	//Profile form
	echo "<form id='form-profile' method='post' action='$portal_root/modules/profile/profile_update.php'>";
			
		//Streams
		echo "<div class='page_container page_container_limit mdl-shadow--4dp'>";
		echo "<div class='page'>";
			echo "<div class='row'>";
				echo "<div class='col s12'><h4>Personal Calendar</h4></div>";
				echo "<div class='col s12'><p id='datePick'>Choose your work calendar by clicking days below.</p></div>";
			echo "</div>";
			
			
		echo "</div>";
		echo "</div>";	
	
	echo "</form>";
	


?>

<script>
	

	
$(function()
{
	$('#datePick').datePicker(
			{
				createButton:false,
				displayClose:true,
				closeOnSelect:false,
				selectMultiple:true
			}
		)
		.bind(
			'click',
			function()
			{
				$(this).dpDisplay();
				this.blur();
				return false;
			}
		)
		.bind(
			'dateSelected',
			function(e, selectedDate, $td, state)
			{
				console.log('You ' + (state ? '' : 'un') // wrap
					+ 'selected ' + selectedDate);
				
			}
		)
		.bind(
			'dpClosed',
			function(e, selectedDates)
			{
				console.log('You closed the date picker and the ' // wrap
					+ 'currently selected dates are:');
				console.log(selectedDates);
			}
		);	
});  
  
    
</script>