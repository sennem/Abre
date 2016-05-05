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

	//Display the Stream
	echo "<div class='grid'>";
		if(studentaccess()==true){ if(!empty($setting_card_mail)==1 or empty($gafecards)){ echo "<div id='streammail'>"; include "../mail/load.php"; echo "</div>"; }}
		if(!empty($setting_card_drive)==1 or empty($gafecards)){ echo "<div class='hide-on-small-only'><div id='streamdrive'>"; include "../drive/load.php"; echo "</div></div>"; }
		if(!empty($setting_card_calendar)==1 or empty($gafecards)){ echo "<div id='streamcalendar'>"; include "../calendar/load.php"; echo "</div>"; }
		if(!empty($setting_card_classroom)==1 or empty($gafecards)){ echo "<div class='hide-on-small-only'><div id='streamclassroom'>"; include "../classroom/load.php"; echo "</div></div>"; }
		if(!empty($setting_card_apps)==1 or empty($gafecards)){ echo "<div class='hide-on-small-only'><div id='streamapps'>"; include "../apps/load.php"; echo "</div></div>"; }
		echo "<div id='streamcards'></div>";
	echo "</div>";

?>

<script>
	
	//Hide Mail Until Streams Load
	$("#streammail").hide();
	$("#streamdrive").hide();
	$("#streamcalendar").hide();
	$("#streamclassroom").hide();
	$("#streamapps").hide();

	//Load Masonry
	function checkWidth()
	{
		if ($(window).width() > 600) {
			$('.grid').masonry({ itemSelector: '.grid-item', isFitWidth: true, transitionDuration: 0, gutter: 15 });
		}
		else
		{
			$('.grid').masonry( 'destroy' );
		}
	}
	checkWidth();
	$(window).resize(checkWidth);
	
	//Load Streams
	var loopcounter=0;
	function loadCards()
	{
		$('#streamcards').load("modules/stream/stream_feeds.php", function () {	
			if(loopcounter==0)
			{
				init_page();
				loadOtherCards();
				loadOtherCardsApps();
				loopcounter=1;
			}
			<?php if(studentaccess()==true){ echo "$( '#streammail' ).show();"; } ?>
			$( "#streamdrive" ).show();
			$( "#streamcalendar" ).show();
			$( "#streamclassroom" ).show();
			$( "#streamapps" ).show();
			$('.grid').masonry( 'reloadItems' );
			$('.grid').masonry( 'layout' );
			mdlregister();
		});			
		setTimeout(loadCards, 300000);
	}
	loadCards();
	
	function loadOtherCards()
	{
			//Google Classroom
			<?php if(!empty($setting_card_classroom)==1 or empty($gafecards)){ ?>
				function loadClassroom() {
					$('#classroom').load("modules/classroom/card.php", function () {	
						$('.grid').masonry( 'reloadItems' );
						$('.grid').masonry( 'layout' );
					});
				}
				loadClassroom();
			<? } ?>
			
			//Google Drive
			<?php if(!empty($setting_card_drive)==1 or empty($gafecards)){ ?>
				function loadDrive() {
					$('#drive').load("modules/drive/card.php", function () {	
						$('.grid').masonry( 'reloadItems' );
						$('.grid').masonry( 'layout' );
					});
					setTimeout(loadDrive, 600000);
				}
				loadDrive();
			<? } ?>
				
			//Google Calendar
			<?php if(!empty($setting_card_calendar)==1 or empty($gafecards)){ ?>
				function loadCalendar() {
					$('#calendar').load("modules/calendar/card.php", function () {	
						$('.grid').masonry( 'reloadItems' );
						$('.grid').masonry( 'layout' );
					});
					setTimeout(loadCalendar, 600000);
				}
				loadCalendar();
			<? } ?>
				
			//Google Mail
			<?php if(studentaccess()==true){ if(!empty($setting_card_mail)==1 or empty($gafecards)){ ?>
				function loadMail() {
					$('#mail').load("modules/mail/card.php", function () {	
						$('.grid').masonry( 'reloadItems' );
						$('.grid').masonry( 'layout' );
		
					});
					setTimeout(loadMail, 120000);
				}
				loadMail();
				<?php
				}
				}
			?>
		
	}
	
	function loadOtherCardsApps()
	{
		//Apps Card
		<?php if(!empty($setting_card_apps)==1 or empty($gafecards)){ ?>
			function loadApps() {
				$('#apps').load("modules/apps/card.php", function () {	
					$('.grid').masonry( 'reloadItems' );
					$('.grid').masonry( 'layout' );
				});
			}
			loadApps();
		<? } ?>
	}
	
	//Sortable settings
	$( ".appssort" ).sortable({
		cursorAt: { top: 25, left: 45 },
		update: function(event, ui){
			var postData = $(this).sortable('serialize');
			<?php 
				echo "$.post('$portal_root/modules/apps/apps_save_order.php', {list: postData})";
			?>
			.done(function()
			{
				loadOtherCardsApps();
			});
		}
	});

	//Check card for updates once email clicked
	$(document).on("click", ".emailclick", function ()
	{
		setTimeout(function()
		{
        	loadOtherCards();
        }, 5000);
	});
	
</script>