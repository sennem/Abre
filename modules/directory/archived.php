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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('permissions.php');
	
	//Display search results
	if($pageaccess==1)
	{

		$sql = "SELECT *  FROM directory where archived=1";
		$result=mysqli_query($db,$sql);
		$rowcount=mysqli_num_rows($result);
		if($rowcount!=0)
		{
					
			//Display Recent Searches	
			echo "<div class='page_container mdl-shadow--4dp'>";
			echo "<div class='page'>";	
			echo "<div class='row'><div class='col s12'>";
								
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
									$picture=$portal_root."/modules/directory/images/user.png";
								}
								else
								{
									$picture=$portal_root."/modules/directory/serveimage.php?file=$picture";
								}
								$senioritydate=htmlspecialchars($row["senioritydate"], ENT_QUOTES);
								$senioritydate=stripslashes(htmlspecialchars(decrypt($senioritydate, ""), ENT_QUOTES));
								$id=htmlspecialchars($row["id"], ENT_QUOTES);
								echo "<tr>";
									echo "<td width=60px><img src='$picture' class='profile-avatar-small demoimage' alt=''></td>";
									echo "<td><strong class='demotext_dark'>$firstname $lastname</strong><a href='$portal_root/#directory/$id' class='hidden'></a></td>";
									echo "<td class='hide-on-small-only demotext_dark'>$email</td>";
									echo "<td class='hide-on-med-and-down demotext_dark'>$title</td>";
									echo "<td width=30px><button class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 restoreuser'><a href='modules/directory/restoreuser.php?id=$id'></a><i class='material-icons'>cached</i></button></td>";	
									if($superadmin==1)
									{
										echo "<td width=30px><button class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 deleteuser'><a href='modules/directory/permdeleteuser.php?id=$id'></a><i class='material-icons'>delete</i></button></td>";
									}
								echo "</tr>";
												
							}
					
						echo "</tbody>";
					echo "</table>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
			}
			else
			{
				echo "<div class='row center-align'><div class='col s12'><h6>No Archived Employees</h6></div></div>";
			}
					
		?>
		
		<script>
			
			$(document).ready(function(){  
				
				$("#myTable").tablesorter({ 
					sortList: [[1,0],[3,0]]
    			});
		
			});	
			
		</script>
					
		<?php
					
	}
					
?>