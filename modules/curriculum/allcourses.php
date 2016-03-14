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
	
	//Display all courses
	if($pagerestrictions=="")
	{
		?>
		<div class='page_container mdl-shadow--4dp'>
		<div class='page'>
			<div id='searchresults'>
				<div class='row'><div class='col s12'><h4>All Courses</h4></div></div>			
				<div class='row'><div class='col s12'>
					<table id='myTable' class='tablesorter'>
						<thead>
							<tr class='pointer'>
								<th class='hide-on-med-and-down'></th>
								<th>Title</th>
								<th>Grade Level</th>
								<th style='width:30px'></th>
							</tr>
						</thead>
						<tbody>
							
							<?php
							$sql = "SELECT * FROM curriculum_course order by Title";
							$result = $db->query($sql);
							while($row = $result->fetch_assoc())
							{
								$Course_ID=htmlspecialchars($row["ID"], ENT_QUOTES);
								$Title=htmlspecialchars($row["Title"], ENT_QUOTES);
								$Subject=htmlspecialchars($row["Subject"], ENT_QUOTES);
								$Grade=htmlspecialchars($row["Grade"], ENT_QUOTES);
								$Image=htmlspecialchars($row["Image"], ENT_QUOTES);
							
								echo "<tr>";
									echo "<td class='hide-on-med-and-down'>";
										echo "<img src='$portal_root/modules/curriculum/images/$Image' class='profile-avatar-small'>";
									echo "</td>";
									echo "<td>$Title</td>";
									echo "<td>$Grade</td>";
									echo "<td width=30px>";
										include "../../core/abre_dbconnect.php";
										$userid=finduseridcore($_SESSION['useremail']);
										$sqllookup = "SELECT * FROM curriculum_libraries where User_ID='$userid' and Course_ID='$Course_ID'";
										$result2 = $db->query($sqllookup);
										$foundcourse=mysqli_num_rows($result2);
										if($foundcourse==0)
										{
											echo "<button class='mdl-button mdl-js-button mdl-button--icon tooltipped addcourse' data-position='top' data-tooltip='Add Course'><a href='modules/curriculum/addcourse.php?librarycourseid=".$Course_ID."' class='mdl-color-text--black'></a><i class='material-icons'>add_circle</i></button>";
										}
									echo "</td>";
								echo "</tr>";
							}
							echo "</tbody>";
						echo "</table>";
					echo "</div>";
					
				echo "</div>";
	
		echo "</div>";
		echo "</div>";
	}
		
?>
		
<script>
			
	//Process the profile form
	$(function() {
		
		//Add Course from Library
		$( ".addcourse" ).click(function() {
			event.preventDefault();
			$(this).hide();
			var address = $(this).find("a").attr("href");
			$.ajax({
				type: 'POST',
				url: address,
				data: '',
			})
															
			//Show the notification
			.done(function(response) {															
				$('#form-messages').text(response);	
				$( ".notification" ).slideDown( "fast", function() {
					$( ".notification" ).delay( 2000 ).slideUp();	
				});		
			})

		});  			
					
		
		//Add Tooltip
		$('.tooltipped').tooltip({ delay: 0 }); 
				
		$("#myTable").tablesorter({ 
			sortList: [[1,0],[3,0]]
    	});
					
	});
				
</script>