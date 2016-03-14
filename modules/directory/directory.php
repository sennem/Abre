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
	require_once('permissions.php');

	//Show the Search and Last 10 Modified Users
	if($pageaccess==1 or $_SESSION['usertype']=="staff")
	{
		
		require_once('../../core/abre_functions.php');
		echo "<div class='page_container mdl-shadow--4dp'>";
		echo "<div class='page'>";
				
			//Search
			echo "<form id='form-search' method='post' action='modules/directory/searchresults.php'>";
				echo "<div class='row'>";
					echo "<div class='input-field col s12'>";
						echo "<input placeholder='Search' id='searchquery' name='searchquery' type='text'>";
					echo "</div>";
				echo "</div>";  
			echo "</form>";	
					
			//Show the Results	
			echo "<div id='searchresults'>";
						
				//Display Recent Searches
				echo "<div class='row'><div class='col s12'><h4>Recent Updates</h4></div></div>";			
				echo "<div class='row'><div class='col s12'>";
					echo "<table id='myTable' class='tablesorter'>";
						echo "<thead>";
							echo "<tr class='pointer'>";
								echo "<th></th>";
								echo "<th>Name</th>";
								echo "<th class='hide-on-small-only'>Email</th>";
								echo "<th class='hide-on-small-only'>Building</th>";
								echo "<th class='hide-on-med-and-down'>Title</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
						
						include "../../core/abre_dbconnect.php";
						$sql = "SELECT *  FROM directory where archived=0 order by updatedtime DESC limit 10";
						$result = $db->query($sql);
						while($row = $result->fetch_assoc())
						{
							$resultcount=1;
							$firstname=htmlspecialchars($row["firstname"], ENT_QUOTES);
							$firstname=stripslashes(htmlspecialchars(decrypt($firstname, ""), ENT_QUOTES));
							$lastname=htmlspecialchars($row["lastname"], ENT_QUOTES);
							$lastname=stripslashes(htmlspecialchars(decrypt($lastname, ""), ENT_QUOTES));
							$location=htmlspecialchars($row["location"], ENT_QUOTES);
							$location=stripslashes(htmlspecialchars(decrypt($location, ""), ENT_QUOTES));
							$email=htmlspecialchars($row["email"], ENT_QUOTES);
							$email=stripslashes(htmlspecialchars(decrypt($email, ""), ENT_QUOTES));
							$title=htmlspecialchars($row["title"], ENT_QUOTES);
							$title=stripslashes(htmlspecialchars(decrypt($title, ""), ENT_QUOTES));
							$picture=htmlspecialchars($row["picture"], ENT_QUOTES);
							if($picture==""){ 
								$picture=$portal_root."/modules/directory/images/user.png";
							}
							else
							{
								//$fileExtension = strrchr($picture, ".");
								$fileExtension = substr(strrchr($picture,'.'),1);
								
								$picture=$portal_root."/modules/directory/serveimage.php?file=$picture&ext=$fileExtension";
							}
							$id=htmlspecialchars($row["id"], ENT_QUOTES);
							if($pageaccess==1){ echo "<tr class='clickrow'>"; }else{ echo "<tr class='clickrowemail'>"; }
								echo "<td width='60px'><img src='$picture' class='profile-avatar-small'></td>";
								echo "<td><strong>$firstname $lastname</strong>";
								if($_SESSION['usertype']=="staff" && $pageaccess!=1)
								{
									echo "<a href='https://mail.google.com/mail/u/0/?view=cm&fs=1&to=$email&tf=1' class='hidden'></a>";
								}
								else
								{
									echo "<a href='$portal_root/#directory/$id' class='hidden'></a>";
								}
								echo "</td>";
								echo "<td class='hide-on-small-only'>$email</td>";
								echo "<td class='hide-on-small-only'>$location</td>";
								echo "<td class='hide-on-med-and-down'>$title</td>";
							echo "</tr>";
						}
						echo "</tbody>";
					echo "</table>";
				echo "</div>";
			echo "</div>";

		echo "</div>";
		echo "</div>";
		
		if($pageaccess==1){ include "button.php"; }
		
		?>
		
			<script>
			
				//Process the profile form
				$(function() {
					
					//Table Sorter
					$("#myTable").tablesorter({ 
    				});
					
					//Set the row links for the table
					$("tr.clickrow").click(function() {
					  window.location.href = $(this).find("a").attr("href");
					});
					
					//Email Send click
					$("tr.clickrowemail").click(function() {
						 window.open($(this).find("a").attr("href"), '_blank');
					});
					
					//Press the search data
					var form = $('#form-search');
					var formMessages = $('#form-messages');
					$(form).submit(function(event) {
						event.preventDefault();
					    $(formMessages).text('Searching...');	
					    $( ".notification" ).slideDown();	
						$.ajax({
						    type: 'POST',
						    data: $('#searchquery').serialize(),
						    url: $(form).attr('action'),
						    success: function(data) {   
						        $('#searchresults').html(data);
						        $( ".notification" ).slideDown( "fast", function() {
									$( ".notification" ).slideUp();	
								});	
						    }
						});
			
					});
				});
				
			</script>
		
		<?php

	}

?>