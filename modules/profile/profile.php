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
	
	//See if startup is required
	$sql = "SELECT * FROM profiles where email='".$_SESSION['useremail']."'";
	$result = $db->query($sql);
	$setting_startup_count=mysqli_num_rows($result);
	while($row = $result->fetch_assoc()) {
		$setting_startup=htmlspecialchars($row['startup'], ENT_QUOTES);
	}
	
	//Get Profile Information
	$sql = "SELECT * FROM profiles where email='".$_SESSION['useremail']."'";
	$result = $db->query($sql);
	$setting_preferences=mysqli_num_rows($result);
	while($row = $result->fetch_assoc()) {
		$setting_card_mail=htmlspecialchars($row['card_mail'], ENT_QUOTES);
		$setting_card_drive=htmlspecialchars($row['card_drive'], ENT_QUOTES);
		$setting_card_calendar=htmlspecialchars($row['card_calendar'], ENT_QUOTES);
		$setting_card_classroom=htmlspecialchars($row['card_classroom'], ENT_QUOTES);
	}
	
	//Start Form
	echo "<form id='form-profile' method='post' action='$portal_root/modules/profile/updateprofile.php'>";
	
		//My Streams
		echo "<div class='page_container page_container_limit mdl-shadow--4dp'>";
		echo "<div class='page'>";
			echo "<div class='row'>";
				echo "<div class='col s12'><h4>Streams</h4></div>";
				echo "<div class='col s12'><p>Decide which information is relevant to you. Please choose from the options below to customize your stream information. Additional Streams will soon be added.</p></div>";
			echo "</div>";
			echo "<div class='row'>";
				$sql = "SELECT *  FROM streams WHERE `group` = '".$_SESSION['usertype']."' AND `required` != 1 ORDER BY type, title";
				$result = $db->query($sql);
				$resultcount = mysqli_num_rows($result);
				$dcount=0;
				while($row = $result->fetch_assoc()) {
					$title=htmlspecialchars($row['title'], ENT_QUOTES);
					$id=htmlspecialchars($row['id'], ENT_QUOTES);
					echo "<div class='col m4 s6'>";
						$sql2 = "SELECT * FROM profiles where email='".$_SESSION['useremail']."' and streams like '%$id%'";
						$result2 = $db->query($sql2);
						$returncount=0;
						while($row2 = $result2->fetch_assoc()) {
							echo "<input type='checkbox' class='formclick filled-in' id='checkbox_$dcount' name='checkbox_$dcount' value='$id' checked='checked' /><label for='checkbox_$dcount'>$title</label>";
							$returncount=1;
						}
						if($returncount==0){ echo "<input type='checkbox' class='formclick filled-in' id='checkbox_$dcount' name='checkbox_$dcount' value='$id' /><label for='checkbox_$dcount'>$title</label>"; }
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
		
		//Account Preferences
		if($_SESSION['usertype']!="student")
		{
			echo "<div class='page_container page_container_limit mdl-shadow--4dp'>";
			echo "<div class='page'>";
				echo "<div class='row'>";
					echo "<div class='col s12'><h4>Stream Preferences</h4></div>";
					echo "<div class='col s12'>";
						echo "<table><tbody>";
							//Mail
							echo "<tr>";
								echo "<td style='padding:0; margin:0;'>Make the Google Mail card visible on my stream.</td>";
								echo "<td width='50px'><div class='switch'><label>";
									if($setting_card_mail==1 or $setting_preferences==0)
									{ echo "<input type='checkbox' class='formclick' name='card_mail' value='1' checked />"; }
									else 
									{ echo "<input type='checkbox' class='formclick' name='card_mail' value='1' />"; }
								echo "<span class='lever'></span></label></div></td>";
							echo "</tr>";
							//Drive
							echo "<tr>";
								echo "<td style='padding:0; margin:0;'>Make the Google Drive card visible on my stream.</td>";
								echo "<td width='50px'><div class='switch'><label>";
									if($setting_card_drive==1 or $setting_preferences==0)
									{ echo "<input type='checkbox' class='formclick' name='card_drive' value='1' checked />"; }
									else
									{ echo "<input type='checkbox' class='formclick' name='card_drive' value='1' />"; }
								echo "<span class='lever'></span></label></div></td>";
							echo "</tr>";
							//Calendar
							echo "<tr>";
								echo "<td style='padding:0; margin:0;'>Make the Google Calendar card visible on my stream.</td>";
								echo "<td width='50px'><div class='switch'><label>";
									if($setting_card_calendar==1 or $setting_preferences==0)
									{ echo "<input type='checkbox' class='formclick' name='card_calendar' value='1' checked />"; }
									else
									{ echo "<input type='checkbox' class='formclick' name='card_calendar' value='1' />"; }
								echo "<span class='lever'></span></label></div></td>";
							echo "</tr>";
							//Classroom
							echo "<tr>";
								echo "<td style='padding:0; margin:0;'>Make the Google Classroom card visible on my stream.</td>";
								echo "<td width='50px'><div class='switch'><label>";
									if($setting_card_classroom==1 or $setting_preferences==0)
									{ echo "<input type='checkbox' class='formclick' name='card_classroom' value='1' checked />"; }
									else
									{ echo "<input type='checkbox' class='formclick' name='card_classroom' value='1' />"; }
								echo "<span class='lever'></span></label></div></td>";
							echo "</tr>";
						echo "</tbody></table>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "</div>";
		}
		
		//App Ordering
		if($_SESSION['usertype']!="student")
		{
			echo "<div class='page_container page_container_limit mdl-shadow--4dp'>";
			echo "<div class='page'>";
				echo "<div class='row'>";
					echo "<div class='col s12'><h4>App Ordering</h4></div>";
					echo "<div class='col s12'><p>Drag the apps below to customize the display order.</p></div>";
					echo "<div class='col s12'>";
						echo "<ul class='appssort'>";
						
							//Create Array
							$required=array();
						
							//Get App preference settings (if they exist)
							$sql2 = "SELECT * FROM profiles where email='".$_SESSION['useremail']."'";
							$result2 = $db->query($sql2);
							while($row2 = $result2->fetch_assoc()) {
								$apps_order=htmlspecialchars($row2["apps_order"], ENT_QUOTES);
							}
							
							//Build Array of Required Apps
							$sql = "SELECT * FROM apps WHERE ".$_SESSION['usertype']." = 1 AND required = 1";
							$result = $db->query($sql);
							while($row = $result->fetch_assoc())
							{	
								$id=htmlspecialchars($row["id"], ENT_QUOTES);									
								array_push($required, $id);
							}
						
							//Display default order, unless they have saved prefrences
							if($apps_order!=NULL)
							{
								$order = explode(',', $apps_order);
							}
							else
							{
								$order=array();
							}
							
							//Compare 
							foreach($required as $key => $requiredvalue)
							{
								$hit=NULL;
								foreach($order as $key => $ordervalue)
								{
									if($requiredvalue==$ordervalue)
									{
										$hit="yes";
									}
								}
								
								if($hit==NULL)
								{
									array_push($order, $requiredvalue);
								}
							}
							
							foreach($order as $key => $value)
							{
								$sql = "SELECT * FROM apps WHERE id='$value'";
								$result = $db->query($sql);
								while($row = $result->fetch_assoc())
								{
									$id=htmlspecialchars($row["id"], ENT_QUOTES);
									$title=htmlspecialchars($row["title"], ENT_QUOTES);
									$image=htmlspecialchars($row["image"], ENT_QUOTES);
									//echo "<div id='item_$id'>$title</div>";

									echo "<li id='item_$id' class='pointer truncate'>";
										echo "<img src='$portal_root/core/images/$image' class='appicon' style='width:30px; height:30px; margin:0;'>";
										echo " <span>$title</span>";
									echo "</li>";

								}
							}
							
							
							
						echo "</ul>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "</div>";
		}
		
	
	echo "</form>";
	


?>

	<div class="fixed-action-btn buttonpin">
		<?php 
			echo "<a class='btn-floating btn-large waves-effect waves-light blue darken-3' href='?signout'><i class='large material-icons'>exit_to_app</i></a>"; 
		?>
	</div>


<script>

	//Process the profile form
	$(function() {
		var form = $('#form-profile');
		var formMessages = $('#form-messages');
		
		$(".formclick").click(function() {
			var formData = $('#form-profile').serialize();
			$.ajax({
			    type: 'POST',
			    url: $('#form-profile').attr('action'),
			    data: formData
			})
			
			//Show the notification
			.done(function(response) {
				$(formMessages).text('Your changes have been saved.');	
				$( ".notification" ).slideDown( "fast", function() {
					$( ".notification" ).delay( 2000 ).slideUp();	
				});			
			})
			
		});
		
		$( ".appssort" ).sortable();
		$( ".appssort" ).disableSelection();
		
		$( ".appssort" ).sortable({
			cursorAt: { top: 20, left: 20 },
			update: function(event, ui){
				var postData = $(this).sortable('serialize');
				<?php echo "$.post('$portal_root/modules/profile/saveapporder.php', {list: postData}, function(o){"; ?>
				}, 'json');
				$(formMessages).text('Your profile has been saved.');	
				$( ".notification" ).slideDown( "fast", function() {
					$( ".notification" ).delay( 2000 ).slideUp();	
				});	
			}
		});
    
	});
	
</script>