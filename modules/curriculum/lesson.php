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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	require_once('permissions.php');
	
	//Display lesson
	if($pagerestrictions=="")
	{
	
			$Lesson_ID=htmlspecialchars($_GET["id"], ENT_QUOTES);
			
			//Get Course Information
			include "../../core/abre_dbconnect.php";
			$sqllookup = "SELECT * FROM curriculum_lesson where ID='$Lesson_ID'";
			$result2 = $db->query($sqllookup);
			$setting_preferences=mysqli_num_rows($result2);
			while($row = $result2->fetch_assoc())
			{
				
				$Title=htmlspecialchars($row["Title"], ENT_QUOTES);
				$Objective=htmlspecialchars($row["Objective"], ENT_QUOTES);
				$Big_Idea=htmlspecialchars($row["Big_Idea"], ENT_QUOTES);
				$Materials=$row["Materials"];
				$Plan_of_Instruction=$row["Plan_of_Instruction"];
				$Helpful_Hints=$row["Helpful_Hints"];
				$Attachments=$row["Attachments"];
			
				echo "<div class='page_container page_container_limit'>";
				echo "<div class='row' style='padding: 10px 0 0 0'><h2>$Title</h2><h5>Objective: $Objective</h5></div>";
				

					echo "<div class='row mdl-shadow--2dp mdl-color--white'>";
						echo "<section class='section--center mdl-grid mdl-grid--no-spacing'>";
							echo "<header class='section__play-btn mdl-cell mdl-cell--3-col-desktop mdl-cell--2-col-tablet mdl-cell--4-col-phone mdl-color--blue-800 mdl-color-text--white' style='padding: 30px; background-size: cover; background-image: url(/modules/curriculum/lessons/uploads/fossil.png');'>";
							echo "</header>";
							echo "<div class='mdl-card mdl-cell mdl-cell--9-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone' style='padding: 30px;'>";
									echo "<h3>Big Idea</h3>";
									echo "<p>$Big_Idea</p>";
							echo "</div>";
						echo "</section>";
					echo "</div>";
				  	
				  	if($Materials!="")
				  	{
						echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='border-radius: 2px; padding: 30px; margin-bottom: 20px;'>";
			            	echo "<h3>Materials</h3>";
			            	echo "<p>$Materials</p>";
			          	echo "</div>";
			        }
					
					echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='border-radius: 2px; padding: 30px; margin-bottom: 20px;'>";
		            	echo "<h3>Plan of Instruction</h3>";
		            	echo "<p>$Plan_of_Instruction</p>";
		          	echo "</div>";
					
					echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='border-radius: 2px; padding: 30px; margin-bottom: 20px;'>";
		            	echo "<h3>Helpful Hints</h3>";
		            	echo "<p>$Helpful_Hints</p>";
		          	echo "</div>";
					
					echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='border-radius: 2px; padding: 30px; margin-bottom: 20px;'>";
		            	echo "<h3>Attachments</h3>";
		            	echo "<p>$Attachments</p>";
		          	echo "</div>";
					
				echo "</div>";
				
			}
		
	}
	
?>