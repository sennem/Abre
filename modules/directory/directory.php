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

	//Show the Search and Last 10 Modified Users
	if($pageaccess==1 or $_SESSION['usertype']=="staff")
	{
		
		$sql = "SELECT *  FROM directory where archived=0";
		$dbreturn = databasequery($sql);
		$num_users = count($dbreturn);
		
		if($num_users>0)
		{
			echo "<div class='page_container mdl-shadow--4dp'>";
			echo "<div class='page'>";
					
				//Search
				echo "<form id='form-search' method='post' action='modules/directory/searchresults.php'>";
					echo "<div class='row'>";
						echo "<div class='input-field col s12'>";
							echo "<input placeholder='Search' id='searchquery' name='searchquery' autocomplete='off' type='text'>";
						echo "</div>";
					echo "</div>";  
				echo "</form>";	
								
				//Display Recent Searches
				echo "<div id='searchresults'>";
					include "searchresults.php";
				echo "</div>";
	
			echo "</div>";
			echo "</div>";
		}
		else
		{
			echo "<div class='row center-align'><div class='col s12'><h6>No Active Staff</h6></div><div class='col s12'>Click the '+' button at the bottom left to add a staff member.</div></div>";
		}
		
		if($pageaccess==1){ include "button.php"; }
		
		?>
		
			<script>
			
				//Process the profile form
				$(function()
				{
					
					//Press the search data
					var form = $('#form-search');
					var formMessages = $('#form-messages');
					$(form).submit(function(event) {
						event.preventDefault();
						$.ajax({
						    type: 'POST',
						    data: $('#searchquery').serialize(),
						    url: $(form).attr('action'),
						    success: function(data) {   
						        $('#searchresults').html(data);
						    }
						});
			
					});
					
				});
				
			</script>
		
		<?php

	}

?>