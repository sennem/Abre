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
	
	//Get Contracted Days	
	$useremailencrypt=encrypt($_SESSION['useremail'], "");
	$sql = "SELECT * FROM directory where email='$useremailencrypt'";
	$dbreturn = databasequery($sql);
	foreach ($dbreturn as $row)
	{
		$contractdays=htmlspecialchars($row['contractdays'], ENT_QUOTES);
		$contractdays=decrypt($contractdays, "");
	}
	
	//Profile form
	echo "<form id='form-profile' method='post' action='$portal_root/modules/profile/profile_update.php'>";
			
		//Streams
		echo "<div class='page_container page_container_limit mdl-shadow--4dp'>";
		echo "<div class='page'>";
			echo "<div class='row'>";
				echo "<div class='col s12'><h3>Streams</h3></div>";
				echo "<div class='col s12'><p>Decide which information is relevant to you. Please choose from the topics below to customize your stream information.</p></div>";
				echo "<div class='col s12'><div id='streamerror'></div></div>";
			echo "</div>";
			echo "<div class='row'>";
				$dcount=0;
				$sql = "SELECT *  FROM streams WHERE `group` = '".$_SESSION['usertype']."' AND `required` != 1 ORDER BY type, title";
				$dbreturn = databasequery($sql);
				foreach ($dbreturn as $row)
				{
					$title=htmlspecialchars($row['title'], ENT_QUOTES);
					$id=htmlspecialchars($row['id'], ENT_QUOTES);
					echo "<div class='col m4 s6'>";
						$returncount=0;
						$sql = "SELECT * FROM profiles where email='".$_SESSION['useremail']."' and streams like '%$id%'";
						$dbreturn = databasequery($sql);
						foreach ($dbreturn as $row)
						{
							echo "<input type='checkbox' class='formclick filled-in streamtopic' id='checkbox_$dcount' name='checkbox_$dcount' value='$id' checked='checked' /><label for='checkbox_$dcount' style='color:#000;'>$title</label>";
							$returncount=1;
						}
						if($returncount==0){ echo "<input type='checkbox' class='formclick filled-in streamtopic' id='checkbox_$dcount' name='checkbox_$dcount' value='$id' /><label for='checkbox_$dcount' style='color:#000;'>$title</label>"; }
					echo "</div>";
					$dcount++;
	    		}
	    		if($dcount==0){ echo "<div class='col s12'>No available streams</div>"; }
				echo "<div class='col s12'>";
				echo "<input type='hidden' name='departmentcount' value='$dcount'><br>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "</div>";
		
		//Stream preferences
		if($_SESSION['usertype']!="student")
		{
			echo "<div class='row'>";
			echo "<div class='page_container page_container_limit'>";
			echo "<hr style='margin-bottom:20px;'>";
			
				//Card settings
				echo "<div class='col l6 s12' style='padding-right:50px;'>";
						echo "<h3 style='margin-top:5px;'>Cards</h3><p>Cards are small pieces of information that display on your stream. You can customize your stream by controlling which cards are visible.<br><br></p>";
				echo "</div>";				
				echo "<div class='page col l6 s12 mdl-shadow--4dp'>";
					echo "<div style='margin:20px;'>";
						echo "<table><tbody>";
							//Mail
							echo "<tr>";
								echo "<td style='padding:0; margin:0;'>Show the Mail card on my stream.</td>";
								echo "<td width='50px'><div class='switch'><label>";
									if($setting_card_mail==1)
									{ echo "<input type='checkbox' class='formclick' name='card_mail' value='1' checked />"; }
									else 
									{ echo "<input type='checkbox' class='formclick' name='card_mail' value='1' />"; }
								echo "<span class='lever'></span></label></div></td>";
							echo "</tr>";
							//Drive
							echo "<tr>";
								echo "<td style='padding:0; margin:0;'>Show the Drive card on my stream.</td>";
								echo "<td width='50px'><div class='switch'><label>";
									if($setting_card_drive==1)
									{ echo "<input type='checkbox' class='formclick' name='card_drive' value='1' checked />"; }
									else
									{ echo "<input type='checkbox' class='formclick' name='card_drive' value='1' />"; }
								echo "<span class='lever'></span></label></div></td>";
							echo "</tr>";
							//Calendar
							echo "<tr>";
								echo "<td style='padding:0; margin:0;'>Show the Calendar card on my stream.</td>";
								echo "<td width='50px'><div class='switch'><label>";
									if($setting_card_calendar==1)
									{ echo "<input type='checkbox' class='formclick' name='card_calendar' value='1' checked />"; }
									else
									{ echo "<input type='checkbox' class='formclick' name='card_calendar' value='1' />"; }
								echo "<span class='lever'></span></label></div></td>";
							echo "</tr>";
							//Classroom
							echo "<tr>";
								echo "<td style='padding:0; margin:0;'>Show the Classroom card on my stream.</td>";
								echo "<td width='50px'><div class='switch'><label>";
									if($setting_card_classroom==1)
									{ echo "<input type='checkbox' class='formclick' name='card_classroom' value='1' checked />"; }
									else
									{ echo "<input type='checkbox' class='formclick' name='card_classroom' value='1' />"; }
								echo "<span class='lever'></span></label></div></td>";
							echo "</tr>";
							//Apps
							echo "<tr>";
								echo "<td style='padding:0; margin:0;'>Show the Apps card on my stream.</td>";
								echo "<td width='50px'><div class='switch'><label>";
									if($setting_card_apps==1)
									{ echo "<input type='checkbox' class='formclick' name='card_apps' value='1' checked />"; }
									else
									{ echo "<input type='checkbox' class='formclick' name='card_apps' value='1' />"; }
								echo "<span class='lever'></span></label></div></td>";
							echo "</tr>";
						echo "</tbody></table>";
					echo "</div>";
				echo "</div>";		

			
			
			echo "</div>";
			echo "</div>";
		}	
	
	echo "</form>";
	


?>


<script>
	
//Work Schedule Modal
$('.modal-viewschedule').leanModal({ in_duration: 0, out_duration: 0 });

<? if($setting_streams=="" && $_SESSION['usertype']=="staff"){ echo "$('.modal-viewapps').hide();"; } ?>
	
<?php if($_SESSION['usertype']=="staff"){ ?>
	if ($('.streamtopic:checked').length < 3)
	{
		$('#streamerror').show();
		$('#streamerror').html("<h6 class='mdl-color-text--red'>You must follow 3 or more streams.</h6>");	
	}

<?php } ?>
		
$(".formclick").click(function() {
	<?php if($_SESSION['usertype']=="staff"){ ?>
		if ($('.streamtopic:checked').length < 3)
		{
			$('#streamerror').show();
			$('#streamerror').html("<h6 class='mdl-color-text--red'>You must follow 3 or more streams.</h6>");	
			var notification = document.querySelector('.mdl-js-snackbar');
			var data = { message: 'You must follow 3 or more streams.' };
			notification.MaterialSnackbar.showSnackbar(data);
		}
		else
		{
			
			$('.modal-viewapps').show();
			var formData = $('#form-profile').serialize();
			$.ajax({
				type: 'POST',
				url: $('#form-profile').attr('action'),
				data: formData
			})
					
			//Show the notification
			.done(function(response) {
				$('#streamerror').show();
				$('#streamerror').html("<h6 class='mdl-color-text--blue-800'>Great picks! Follow more topics or hit Done to see your Stream. <a href='#' class='waves-effect waves-light btn mdl-color-text--white mdl-color--blue-800'>Done</a></h6>");
				var notification = document.querySelector('.mdl-js-snackbar');
				var data = { message: 'Your changes have been saved.' };
				notification.MaterialSnackbar.showSnackbar(data);
			})
			
		}
	<?php } ?>
});

	
</script>