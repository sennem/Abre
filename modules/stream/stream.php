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

	$StreamEnd=$_GET["StreamEnd"];

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
		if($_SESSION['usertype'] == 'parent'){
			echo "<div class='row center-align'><div class='col s12'><h6>Parent Access Coming Soon!</h6></div><div class='col s12'>Soon you will able to access student documents and grades via Abre!</div></div>"; 
		}
		echo "<div id='streamcards'></div>";
	echo "</div>";

	echo "<div style='height:80px;'><div id='showmorestream' style='display:none; position:absolute; left:50%; padding:20px; margin-left:-35px;'><div class='mdl-spinner mdl-js-spinner is-active'></div></div></div>";

?>

<script>

	$(function()
	{

		//Hide Mail Until Streams Load
		$("#streammail").hide();
		$("#streamdrive").hide();
		$("#streamcalendar").hide();
		$("#streamclassroom").hide();
		$("#streamapps").hide();

		//Load Masonry
		function checkWidth()
		{
			if ($(window).width() > 600)
			{
				$('.grid').masonry({ itemSelector: '.grid-item', isFitWidth: true, transitionDuration: 0, gutter: 15 });
			}
			else
			{
				$('.grid').masonry({ });
				$('.grid').masonry( 'destroy' );
			}
		}
		checkWidth();
		$(window).resize(checkWidth);

		//Load Streams
		var loopcounter=0;
		var streamCount=<?php echo $StreamEnd; ?>;
		function loadCards(streamEndCount)
		{
			loadingStream=1;
			$('#streamcards').load('modules/stream/stream_feeds.php?StreamEndResult='+streamEndCount, function () {
				$('#showmorestream').hide();
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
				if ($(window).width() >= 600){ $('.grid').masonry( 'reloadItems' ); $('.grid').masonry( 'layout' ); }
				mdlregister();
				loadingStream=0;
			});

			//Refresh
			setTimeout(function() {
				loadCards(streamCount);
			}, 300000)

		}
		loadCards(streamCount);

		function loadOtherCards()
		{
				//Google Classroom
				<?php if(!empty($setting_card_classroom)==1 or empty($gafecards)){ ?>
					function loadClassroom() {
						$('#classroom').load("modules/classroom/card.php", function () {
							if ($(window).width() >= 600){ $('.grid').masonry( 'reloadItems' ); $('.grid').masonry( 'layout' ); }
						});
					}
					loadClassroom();
				<?php } ?>

				//Google Drive
				<?php if(!empty($setting_card_drive)==1 or empty($gafecards)){ ?>
					function loadDrive() {
						$('#drive').load("modules/drive/card.php", function () {
							if ($(window).width() >= 600){ $('.grid').masonry( 'reloadItems' ); $('.grid').masonry( 'layout' ); }
						});
						setTimeout(loadDrive, 600000);
					}
					loadDrive();
				<?php } ?>

				//Google Calendar
				<?php if(!empty($setting_card_calendar)==1 or empty($gafecards)){ ?>
					function loadCalendar() {
						$('#calendar').load("modules/calendar/card.php", function () {
							if ($(window).width() >= 600){ $('.grid').masonry( 'reloadItems' ); $('.grid').masonry( 'layout' ); }
						});
						setTimeout(loadCalendar, 600000);
					}
					loadCalendar();
				<?php } ?>

				//Google Mail
				<?php if(studentaccess()==true){ if(!empty($setting_card_mail)==1 or empty($gafecards)){ ?>
					function loadMail() {
						$('#mail').load("modules/mail/card.php", function () {
							if ($(window).width() >= 600){ $('.grid').masonry( 'reloadItems' ); $('.grid').masonry( 'layout' ); }
						});
						setTimeout(loadMail, 180000);
					}
					loadMail();
					<?php
					}
					}
				?>

		}

		//Check card for updates once email clicked
		$(document).on("click", ".emailclick", function ()
		{
			setTimeout(function()
			{
	        	loadOtherCards();
	        }, 5000);
		});

		//Load more when at bottom of page
		$(".mdl-layout__content").unbind('scroll');
		$(".mdl-layout__content").bind('scroll', function ()
		{
		    if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight - 500)
		    {
			    if(loadingStream==0)
				{
			   		$('#showmorestream').show();
			   		streamCount=streamCount+20;
			   		loadCards(streamCount);
			   	}
		    }
	    });

	});

	//Re-Order Cards
	function loadOtherCardsApps()
	{
		//Apps Card
		<?php if(!empty($setting_card_apps)==1 or empty($gafecards)){ ?>
			function loadApps() {
				$('#apps').load("modules/apps/card.php", function () {
					if ($(window).width() >= 600){ $('.grid').masonry( 'reloadItems' ); $('.grid').masonry( 'layout' ); }
				});
			}
			loadApps();
		<?php } ?>
	}

</script>
