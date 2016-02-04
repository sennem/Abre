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
	
	//Configuration
	require(dirname(__FILE__) . '/../../configuration.php'); 
	
	//Login Validation
	require_once(dirname(__FILE__) . '/../../core/portal_verification.php'); 
	require_once(dirname(__FILE__) . '/../../core/portal_functions.php'); 
	
	require_once('button_scrolltop.php');
	
	//Get User Settings
	include "../../core/portal_dbconnect.php";
	$sql = "SELECT * FROM profiles where email='".$_SESSION['useremail']."'";
	$result = $db->query($sql);
	$setting_preferences=mysqli_num_rows($result);
	while($row = $result->fetch_assoc()) {
		$setting_card_mail=htmlspecialchars($row['card_mail'], ENT_QUOTES);
		$setting_card_drive=htmlspecialchars($row['card_drive'], ENT_QUOTES);
		$setting_card_calendar=htmlspecialchars($row['card_calendar'], ENT_QUOTES);
		$setting_card_classroom=htmlspecialchars($row['card_classroom'], ENT_QUOTES);
	}
	mysqli_close($db);

	//Display the Stream
	echo "<div class='grid'>";
		if(studentaccess()==true){ if($setting_card_mail==1 or $setting_preferences==0){ echo "<div id='streammail'>"; include "../mail/load.php"; echo "</div>"; }}
		if($setting_card_drive==1 or $setting_preferences==0){ echo "<div class='hide-on-small-only'><div id='streamdrive'>"; include "../drive/load.php"; echo "</div></div>"; }
		if($setting_card_calendar==1 or $setting_preferences==0){ echo "<div id='streamcalendar'>"; include "../calendar/load.php"; echo "</div>"; }
		if($setting_card_classroom==1 or $setting_preferences==0){ echo "<div class='hide-on-small-only'><div id='streamclassroom'>"; include "../classroom/load.php"; echo "</div></div>"; }
		echo "<div id='streamcards'></div>";
	echo "</div>";
	
?>

<script>
	
	//Hide Mail Until Streams Load
	<?php
		if(studentaccess()==true){ 
			echo "$('#streammail').hide();";
		}
	?>
	$("#streamdrive").hide();
	$("#streamcalendar").hide();
	$("#streamclassroom").hide();

	//Load Masonry
	$('.grid').masonry({
		itemSelector: '.grid-item',
		isFitWidth: true,
		transitionDuration: 0,
		gutter: 15
	});	
	
	//Register Material Design Lite Elements
	function mdlregister() {
		var html = document.createElement('content_holder');
		$(document.body).append(html);      
		componentHandler.upgradeAllRegistered();	
	}
	
	//Load the Stream Cards Into Page
	counter=0;
	function loadCards() {
		if(counter===0)
		{
			counter=1;
			$('#streamcards').load("modules/stream/stream_cards.php", function () {	
				$( "#loader" ).hide();
				
				<?php
					if(studentaccess()==true)
					{ 
						echo "$( '#streammail' ).show();"; 
					}
				?>
				
				$( "#streamdrive" ).show();
				$( "#streamcalendar" ).show();
				$( "#streamclassroom" ).show();
				$('.grid').masonry( 'reloadItems' );
				$('.grid').masonry( 'layout' );
				mdlregister();
			});
		}
		else
		{
			$('#streamcards').load("modules/stream/stream_cards.php", function () {	
				$('.grid').masonry( 'reloadItems' );
				$('.grid').masonry( 'layout' );
				mdlregister();
			});
		}
		//Reload every 5 minutes
		setTimeout(loadCards, 300000);
	}
	loadCards();
	
</script>