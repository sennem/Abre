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
	
	require_once('permissions.php');
	
	//Display Search Results
	if($superadmin==1)
	{
		
		require_once('../../core/portal_functions.php');
					
		//Display Recent Searches		
		echo "<div class='row'><div class='col s12'>";
			echo "<br><h6>Archived Employees</h6>";
						
			include "../../core/portal_dbconnect.php";
			$sql = "SELECT *  FROM directory where archived=1";
			$result=mysqli_query($db,$sql);
			$rowcount=mysqli_num_rows($result);
			if($rowcount!=0)
			{
							
				echo "<table id='myTable' class='tablesorter'>";
					echo "<thead>";
						echo "<tr class='pointer'>";
							echo "<th></th>";
							echo "<th>Name</th>";
	 						echo "<th class='hide-on-small-only'>Email</th>";
	 						echo "<th class='hide-on-med-and-down'>Title</th>";
	 						echo "<th style='width:30px'></th>";
	 						echo "<th style='width:30px'></th>";
						echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
						include "../../core/portal_dbconnect.php";
						$sql = "SELECT *  FROM directory where archived=1 order by updatedtime DESC";
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
							$classification=htmlspecialchars($row["classification"], ENT_QUOTES);
							$classification=stripslashes(htmlspecialchars(decrypt($classification, ""), ENT_QUOTES));
							$prd=htmlspecialchars($row["probationreportdate"], ENT_QUOTES);
							$prd=stripslashes(htmlspecialchars(decrypt($prd, ""), ENT_QUOTES));
							$picture=htmlspecialchars($row["picture"], ENT_QUOTES);
							if($picture==""){ 
								$picture='user.png'; 
								$picture=$portal_root."/modules/directory/serveimage.php?file=$picture&ext=.png";
							}
							else
							{
								$fileExtension = strrchr($picture, ".");
								$picture=$portal_root."/modules/directory/serveimage.php?file=$picture&ext=$fileExtension";
							}
							$senioritydate=htmlspecialchars($row["senioritydate"], ENT_QUOTES);
							$senioritydate=stripslashes(htmlspecialchars(decrypt($senioritydate, ""), ENT_QUOTES));
							$id=htmlspecialchars($row["id"], ENT_QUOTES);
							echo "<tr>";
								echo "<td width=60px><img src='$picture' class='profile-avatar-small' alt=''></td>";
								echo "<td><strong>$firstname $lastname</strong><a href='$portal_root/#directory/$id' class='hidden'></a></td>";
								echo "<td class='hide-on-small-only'>$email</td>";
								echo "<td class='hide-on-med-and-down'>$title</td>";
								echo "<td width=30px><button class='mdl-button mdl-js-button mdl-button--icon tooltipped restoreuser' data-position='top' data-tooltip='Restore'><a href='modules/directory/restoreuser.php?id=$id'></a><i class='material-icons'>cached</i></button></td>";	
								echo "<td width=30px><button class='mdl-button mdl-js-button mdl-button--icon tooltipped deleteuser' data-position='top' data-tooltip='Delete'><a href='modules/directory/permdeleteuser.php?id=$id'></a><i class='material-icons'>delete</i></button></td>";
							echo "</tr>";
											
						}
				
					echo "</tbody>";
				echo "</table>";
			}
			else
			{
				echo "<p>No Archived Employees.</p>";
			}
		echo "</div>";
		echo "</div>";
					
		?>
		
		<script>
			
			$(document).ready(function(){  
					
				//Add Tooltip
				$('.tooltipped').tooltip({ delay: 0 }); 
		
			});	
			
		</script>
					
		<?php
					
	}
					
?>