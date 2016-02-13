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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 

	require_once('../../core/abre_functions.php');
	echo "<div class='page_container mdl-shadow--4dp'>";
	echo "<div class='page'>";
					
			//Show the Results	
			echo "<div id='searchresults'>";
						
				//Display Recent Searches
				echo "<div class='row'><div class='col s12'><h4>Book Inventory</h4></div></div>";			
				echo "<div class='row'><div class='col s12'>";
					echo "<table id='myTable' class='tablesorter'>";
						echo "<thead>";
							echo "<tr class='pointer'>";
								echo "<th></th>";
								echo "<th>Title</th>";
								echo "<th class='hide-on-med-and-down'>Author</th>";
								echo "<th class='hide-on-med-and-down'>Coupon Code</th>";
								echo "<th class='hide-on-med-and-down'>Used Licenses</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
						
						$sql = "SELECT *  FROM books order by Title";
						$result = $db->query($sql);
						while($row = $result->fetch_assoc())
						{
							$Book_ID=htmlspecialchars($row["ID"], ENT_QUOTES);
							$Title=htmlspecialchars($row["Title"], ENT_QUOTES);
							$Author=htmlspecialchars($row["Author"], ENT_QUOTES);
							$Code=htmlspecialchars($row["Code"], ENT_QUOTES);
							$Code_Limit=htmlspecialchars($row["Code_Limit"], ENT_QUOTES);
							if($Code_Limit==""){ $Code_Limit="Unlimited"; }
							$Cover=htmlspecialchars($row["Cover"], ENT_QUOTES);
							
							//Check how many licenses are left
							$sql2 = "SELECT *  FROM books_libraries where Book_ID=$Book_ID";
							$result2 = $db->query($sql2);
							$Remaining_Licenses = $result2->num_rows;
							
							echo "<tr>";
								echo "<td class='hide-on-small-only'>";
									echo "<img src='$portal_root/modules/books/books/$Cover' class='profile-avatar-small'>";
								echo "</td>";
								echo "<td class='hide-on-small-only'>$Title</td>";
								echo "<td class='hide-on-med-and-down'>$Author</td>";
								echo "<td class='hide-on-med-and-down'>$Code</td>";
								echo "<td class='hide-on-med-and-down'>$Remaining_Licenses/$Code_Limit</td>";
							echo "</tr>";
						}
						echo "</tbody>";
					echo "</table>";
				echo "</div>";
				
			echo "</div>";

	echo "</div>";
	echo "</div>";
		
?>
		
<script>
			
	//Process the profile form
	$(function() {
		
		//Table Sorter
		$("#myTable").tablesorter({ });
					
	});
				
</script>