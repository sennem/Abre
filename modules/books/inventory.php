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
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	require_once('../../core/abre_functions.php');
	require_once('permissions.php');
	
	//Display the inventory for authorized users
	if($pagerestrictions=="")
	{
		?>
		<div class='page_container mdl-shadow--4dp'>
		<div class='page'>
			<div id='searchresults'>
				<div class='row'><div class='col s12'><h4>Inventory</h4></div></div>		
					<div class='row'><div class='col s12'>
						<table id='myTable' class='tablesorter'>
							<thead>
								<tr class='pointer'>
									<th class='hide-on-med-and-down'></th>
									<th>Title</th>
									<th class='hide-on-med-and-down'>Author</th>
									<th>Coupon Code</th>
									<th class='hide-on-small-only'>Used Licenses</th>
								</tr>
							</thead>
							<tbody>
							
							<?php
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
								$sql2 = "SELECT *  FROM books_libraries where Book_ID=$Book_ID";
								$result2 = $db->query($sql2);
								$Remaining_Licenses = $result2->num_rows;
								echo "<tr>";
									echo "<td class='hide-on-med-and-down'>";
										echo "<img src='$portal_root/modules/books/books/$Cover' class='profile-avatar-small'>";
									echo "</td>";
									echo "<td>$Title</td>";
									echo "<td class='hide-on-med-and-down'>$Author</td>";
									echo "<td>$Code</td>";
									echo "<td class='hide-on-small-only'>$Remaining_Licenses/$Code_Limit</td>";
								echo "</tr>";
							}
							?>
							
							</tbody>
						</table>
					</div>
				</div>
		</div>
		</div>
	<?php
	}		
?>
		
<script>
			
	//Process the profile form
	$(function() {
		
		//Table Sorter
		$("#myTable").tablesorter({ });
					
	});
				
</script>